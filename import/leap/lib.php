<?php
/**
 *
 * @package    mahara
 * @subpackage artefact-epos-import-leap
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL version 3 or later
 * @copyright  For copyright information on Mahara, please see the README file distributed with this software.
 *
 */

defined('INTERNAL') || die();

class LeapImportEpos extends LeapImportArtefactPlugin {

    const STRATEGY_IMPORT_AS_EVALUATION = 1;

    public static function get_import_strategies_for_entry(SimpleXMLElement $entry, PluginImportLeap $importer) {
        $strategies = array();

        if (PluginImportLeap::is_rdf_type($entry, $importer, 'evaluation')
            && (empty($entry->content['type']) || (string)$entry->content['type'] == 'text')) {
            $strategies[] = array(
                'strategy' => self::STRATEGY_IMPORT_AS_EVALUATION,
                'score'    => 100,
                'other_required_entries' => array(),
            );
        }
        return $strategies;
    }

    public static function import_using_strategy(SimpleXMLElement $entry, PluginImportLeap $importer, $strategy, array $otherentries) {}

    public static function add_import_entry_request_using_strategy(SimpleXMLElement $entry, PluginImportLeap $importer, $strategy, array $otherentries) {
        if ($strategy != self::STRATEGY_IMPORT_AS_EVALUATION) {
            throw new ImportException($importer, 'TODO: get_string: unknown strategy chosen for importing entry');
        }

//         if (isset($entry->author->name) && strlen($entry->author->name)) {
//             $authorname = (string)$entry->author->name;
//         }
//         else {
//             $author = $importer->get('usr');
//         }

        PluginImportLeap::add_import_entry_request(
            $importer->get('importertransport')->get('importid'),
            (string)$entry->id,
            self::STRATEGY_IMPORT_AS_EVALUATION,
            'epos',
            array(
                'owner'   => $importer->get('usr'),
                'type'    => 'evaluation',
                'content' => array(
                    'title'         => (string)$entry->title,
                    'data'          => PluginImportLeap::get_entry_content($entry, $importer),
                    'ctime'         => (string)$entry->published,
                    'mtime'         => (string)$entry->updated
                ),
            )
        );
    }

    /**
     * Import from entry requests for evaluations
     *
     * @param PluginImportLeap $importer
     * @return updated DB
     * @throw    ImportException
     */
    public static function import_from_requests(PluginImportLeap $importer) {
        $importid = $importer->get('importertransport')->get('importid');
        if ($entry_requests = get_records_select_array('import_entry_requests', 'importid = ? AND plugin = ? AND entrytype = ?', array($importid, 'epos', 'evaluation'))) {
            foreach ($entry_requests as $entry_request) {
                self::create_artefact_from_request($importer, $entry_request);
            }
        }
    }

    public static function create_artefact_from_request($importer, $entry_request, $parent=null) {
        if ($entry_request->decision == PluginImport::DECISION_ADDNEW) {
            $content = unserialize($entry_request->entrycontent);
            $content['owner'] = $entry_request->ownerid;

            $data = json_decode($content['data']);
            $data->owner = $entry_request->ownerid;

            $errmsg = "Self-evaluation import failed.";

            // insert descriptorset
            $descriptorset = $data->descriptorset;
            $descriptorset->visible = 0;
            $descriptorset->active = 0;
            unset($descriptorset->id);
            unset($descriptorset->file);

            if (!$descriptorsetid = insert_record('artefact_epos_descriptorset', $descriptorset, 'id', true)) {
                throw new ImportException($importer, $errmsg);
            }

            // insert competences, levels, ratings
            $competenceids = array();
            foreach ($descriptorset->competences as $oldid => $competence) {
                unset($competence->id);
                if (!$competenceids[$oldid] = insert_record('artefact_epos_competence', $competence, 'id', true)) {
                    throw new ImportException($importer, $errmsg);
                }
            }
            $levelids = array();
            foreach ($descriptorset->levels as $oldid => $level) {
                unset($level->id);
                if (!$levelids[$oldid] = insert_record('artefact_epos_level', $level, 'id', true)) {
                    throw new ImportException($importer, $errmsg);
                }
            }
            foreach ($descriptorset->ratings as $rating) {
                unset($rating->id);
                $rating->descriptorset = $descriptorsetid;
                if (!insert_record('artefact_epos_rating', $rating)) {
                    throw new ImportException($importer, $errmsg);
                }
            }
            // insert descriptors
            $descriptorids = array();
            foreach ($descriptorset->descriptors as $oldid => $descriptor) {
                unset($descriptor->id);
                $descriptor->competence = $competenceids[$descriptor->competence];
                $descriptor->level = $levelids[$descriptor->level];
                $descriptor->descriptorset = $descriptorsetid;
                if (!$descriptorids[$oldid] = insert_record('artefact_epos_descriptor', $descriptor, 'id', true)) {
                    throw new ImportException($importer, $errmsg);
                }
            }
            // insert custom competences and descriptors
            foreach ($data->customcompetences as $oldid => $competence) {
                unset($competence->id);
                if (!$competenceids[$oldid] = insert_record('artefact_epos_competence', $competence, 'id', true)) {
                    throw new ImportException($importer, $errmsg);
                }
            }
            foreach ($data->customdescriptors as $oldid => $descriptor) {
                unset($descriptor->id);
                $descriptor->competence = $competenceids[$descriptor->competence];
                $descriptor->goal_available = 1;
                if (!$descriptorids[$oldid] = insert_record('artefact_epos_descriptor', $descriptor, 'id', true)) {
                    throw new ImportException($importer, $errmsg);
                }

            }
            // update evaluation items
            foreach ($data->itemsbycompetencelevel as $competenceid => &$competence) {
                foreach ($competence as $levelid => &$level) {
                    foreach ($level as &$item) {
                        $item->descriptor = $descriptorids[$item->descriptor];
                    }
                }
            }
            // set descriptorset id
            $data->descriptorset = $descriptorsetid;

            // If authorname is null, it is the importer's own evaluation;
            // otherwise it is an evaluation by someone else.
            if (!isset($data->authorname)) {
                $data->author = $data->evaluator = $importer->get('usr');
            }

            $a = new ArtefactTypeEvaluation(0, $data);
            $a->commit();
            return $a->get('id');
        }
        return parent::create_artefact_from_request($importer, $entry_request, $parent);
    }

    /**
     * Render import entry requests for evaluation
     * @param PluginImportLeap $importer
     * @return HTML code for displaying evaluations and choosing how to import them
     */
    public static function render_import_entry_requests(PluginImportLeap $importer) {
        $importid = $importer->get('importertransport')->get('importid');
        // Get import entry requests for evaluations
        $entryevaluations = array();
        if ($requests = get_records_select_array('import_entry_requests', 'importid = ? AND entrytype = ?', array($importid, 'evaluation'))) {
            foreach ($requests as $request) {
                $evaluation = unserialize($request->entrycontent);
                $evaluation['id'] = $request->id;
                $evaluation['decision'] = $request->decision;
                if (is_string($request->duplicateditemids)) {
                    $request->duplicateditemids = unserialize($request->duplicateditemids);
                }
                if (is_string($request->existingitemids)) {
                    $request->existingitemids = unserialize($request->existingitemids);
                }
                $evaluation['disabled'][PluginImport::DECISION_IGNORE] = false;
                $evaluation['disabled'][PluginImport::DECISION_ADDNEW] = false;
                $evaluation['disabled'][PluginImport::DECISION_APPEND] = true;
                $evaluation['disabled'][PluginImport::DECISION_REPLACE] = true;
                if (!empty($request->duplicateditemids)) {
                    $duplicated_item = artefact_instance_from_id($request->duplicateditemids[0]);
                    $evaluation['duplicateditem']['id'] = $duplicated_item->get('id');
                    $evaluation['duplicateditem']['title'] = $duplicated_item->get('title');
                    $res = $duplicated_item->render_self(array());
                    $evaluation['duplicateditem']['html'] = $res['html'];
                }
                else if (!empty($request->existingitemids)) {
                    foreach ($request->existingitemids as $id) {
                        $existing_item = artefact_instance_from_id($id);
                        $res = $existing_item->render_self(array());
                        $evaluation['existingitems'][] = array(
                            'id'    => $existing_item->get('id'),
                            'title' => $existing_item->get('title'),
                            'html'  => $res['html'],
                        );
                    }
                }
                $entryevaluations[] = $evaluation;
            }
        }
        $smarty = smarty_core();
        $smarty->assign_by_ref('displaydecisions', $importer->get('displaydecisions'));
        $smarty->assign_by_ref('entryevaluations', $entryevaluations);
        return $smarty->fetch('artefact:epos:import/evaluations.tpl');
    }
}
