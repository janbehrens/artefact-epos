<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2010 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage artefact-epos
 * @author     Jan Behrens, Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

defined('INTERNAL') || die();

include_once('xmlize.php');

define('EVALUATION_ITEM_TYPE_DESCRIPTOR', 0);
define('EVALUATION_ITEM_TYPE_COMPLEVEL', 1);
define('EVALUATION_ITEM_TYPE_CUSTOM_GOAL', 2);

class PluginArtefactEpos extends PluginArtefact {

    public static function get_artefact_types() {
        return array('subject', 'evaluation', 'customgoal', 'customcompetence');
    }

    public static function get_block_types() {
        return array('evaluation', 'goals');
    }

    public static function get_plugin_name() {
        return 'epos';
    }

    public static function menu_items() {
        return array(
            array(
                'path' => 'evaluation',
                'title' => get_string('selfevaluation', 'artefact.epos'),
                'url' => 'artefact/epos/evaluation/self-eval.php',
                'weight' => 28,
            ),
            array(
                'path' => 'evaluation/selfevaluation',
                'title' => get_string('selfevaluation', 'artefact.epos'),
                'url' => 'artefact/epos/evaluation/self-eval.php',
                'weight' => 20,
            ),
            array(
                'path' => 'evaluation/stored',
                'title' => get_string('storedevaluations', 'artefact.epos'),
                'url' => 'artefact/epos/evaluation/stored.php',
                'weight' => 21,
            ),
            array(
                'path' => 'evaluation/external',
                'title' => get_string('externalevaluations', 'artefact.epos'),
                'url' => 'artefact/epos/evaluation/external.php',
                'weight' => 22,
            ),
            array(
                'path' => 'evaluation/addremove',
                'title' => get_string('addremoveevaluations', 'artefact.epos'),
                'url' => 'artefact/epos',
                'weight' => 27,
            ),
            array(
                'path' => 'goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 29,
            ),
            array(
                'path' => 'goals/goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 28,
            ),
        );
    }

    public static function admin_menu_items() {
        return PluginArtefactEpos::institution_menu_items();
    }

    public static function institution_menu_items() {
        return PluginArtefactEpos::institution_staff_menu_items();
    }

    public static function institution_staff_menu_items() {
        return array(
            'templates' => array(
                'path'   => 'templates',
                'url'    => 'artefact/epos/templates/subjects.php',
                'title'  => get_string('templates', 'artefact.epos'),
                'weight' => 70,
            ),
            'templates/subjects' => array(
                'path'   => 'templates/subjects',
                'title'  => get_string('subjects', 'artefact.epos'),
                'url'    => 'artefact/epos/templates/subjects.php',
                'weight' => 10,
            ),
            'templates/selfevaluation' => array(
                'path'   => 'templates/selfevaluation',
                'url'    => 'artefact/epos/templates/selfevaluation.php',
                'title'  => get_string('selfevaluation', 'artefact.epos'),
                'weight' => 20,
            )
        );
    }

    public static function jsstrings($type) {
        switch ($type) {
            case 'customgoals':
                return array(
                    'mahara' => array(
                        'save',
                        'cancel'
                     ),
                    'artefact.epos' => array(
                        'customlearninggoalwanttodelete'
                    ),
                );
            default:
                return array();
        }
    }
}

/**
 * ArtefactTypeSubject implementing ArtefactType
 */
class ArtefactTypeSubject extends ArtefactType {

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    /**
     * Overriding the delete() function to clear table references
     */
    public function delete() {
        db_begin();
        delete_records('artefact_epos_mysubject', 'artefact', $this->id);
        parent::delete();
        db_commit();
    }

    public static function get_all_subjects() {
        global $USER;
        $records = get_records_sql_array("
                SELECT * FROM artefact
                WHERE artefacttype = 'subject'
                    AND owner = ?
                ORDER BY title
                ", array($USER->get('id'))
        );
        $subjects = array();
        if ($records) {
            foreach ($records as $record) {
                $subjects []= new ArtefactTypeSubject($record->id, $record);
            }
        }
        return $subjects;
    }
}


class ArtefactTypeEvaluation extends ArtefactType {

    public $subject_id;

    public $descriptorset_id;

    protected $descriptorset;

    protected $customcompetences = array();

    public $items = array();

    protected $items_by_descriptor_id = array();

    protected $items_by_target_id = array();

    public $final = 0;

    public $evaluator;

    public $evaluator_display_name;

    /**
     * Override the constructor to fetch extra data.
     *
     * @param integer $idOrEvaluation The id of the element to load or an evaluation to clone
     * @param object $data Data to fill the object with instead from the db
     * @param boolean $full_load Indicate whether the evaluation items should be loaded
     */
    public function __construct($idOrEvaluation = 0, $data = null, $full_load = true) {
        if (is_a($idOrEvaluation, 'ArtefactTypeEvaluation')) {
            parent::__construct();
            // create a new evaluation from an evaluation
            $this->populate_from_evaluation($idOrEvaluation);
        }
        else {
            parent::__construct($idOrEvaluation, $data);
            if ($this->id && $full_load) {
                if (!isset($this->descriptorset_id)) {
                	$sql = 'SELECT e.*, u.firstname, u.lastname
                            FROM artefact a
                            LEFT JOIN artefact_epos_evaluation e ON a.id = e.artefact
                            LEFT JOIN usr u ON e.evaluator = u.id
                            WHERE a.id = ?';
                	$data = get_record_sql($sql, array($this->id));
                	if ($data) {
                		$this->descriptorset_id = $data->descriptorset;
                		$this->evaluator = $data->evaluator;
                		$this->final = $data->final;
                		$this->evaluator_display_name = "$data->firstname $data->lastname";
                	}
                	else {
                		// This should never happen unless the user is playing around with task IDs in the location bar or similar
                		throw new ArtefactNotFoundException(get_string('evaluationnotfound', 'artefact.epos'));
                	}
                }
            	if ($items = get_records_array('artefact_epos_evaluation_item', 'evaluation', $this->id, 'id')) {
            		foreach ($items as $item) {
            			$this->items[$item->id] = $item;
            			if (isset($item->descriptor)) {
            			    $this->items_by_descriptor_id[$item->descriptor] = $item;
            			}
            			if (isset($item->target_key)) {
            			    $this->items_by_target_id[$item->target_key] = $item;
            			}
            		}
            	}
                $subject = $this->get_parent_metadata();
                $this->subject_id = $subject->id;
            }
        }
    }

    private function populate_from_evaluation(ArtefactTypeEvaluation $evaluation) {
        $this->descriptorset_id = $evaluation->get_descriptorset_id();
        foreach ($evaluation->items as $item) {
            $item = clone $item;
            $item->evaluation = null;
            $this->items []= $item;
        }
        foreach ($evaluation->get_customcompetences() as $customcompetence) {
            // custom competences clone their goals internally
            $customcompetence = clone $customcompetence;
            $customcompetence->set('parent', null);
            $customcompetence->set('id', null);
            $this->customcompetences []= $customcompetence;
        }
        $this->owner = $evaluation->get('owner');
        $this->parent = $evaluation->get('parent');
        $this->evaluator = $evaluation->get('evaluator');
    }

    public function commit() {
        db_begin();
        $new = empty($this->id);
    	parent::commit();
    	$data = (object) array(
    			'artefact' => $this->get('id'),
    			'descriptorset' => $this->descriptorset_id,
    	        'evaluator' => $this->evaluator,
    	        'final' => $this->final
    	);
    	if ($new) {
    	    global $USER;
    		insert_record('artefact_epos_evaluation', $data);
    		$goal_id_map = array();
    		foreach ($this->customcompetences as $customcompetence) {
    		    $customcompetence->set('parent', $this->id);
    		    $customcompetence->set('owner', $USER->get('id'));
    		    $goal_id_map = $goal_id_map + $customcompetence->commit();
    		}
    		foreach ($this->items as $item) {
    		    $item->evaluation = $this->id;
    		    if ($item->type == EVALUATION_ITEM_TYPE_CUSTOM_GOAL && isset($item->id)) {
    		        // we are new, but this item has an id => must be cloned, use new id and insert
    		        if (isset($goal_id_map[$item->target_key])) {
    		            $item->target_key = $goal_id_map[$item->target_key];
    		        }
    		    }
    		    unset($item->id);
    		    insert_record('artefact_epos_evaluation_item', $item);
    		}
    	}
    	else {
    		update_record('artefact_epos_evaluation', $data, 'artefact');
    	}
    	db_commit();
    }

    /**
     * Overriding the delete() function to clear the evaluation table
     */
    public function delete() {
        db_begin();
        delete_records('artefact_epos_evaluation_item', 'evaluation', $this->id);
        delete_records('artefact_epos_evaluation', 'artefact', $this->id);
        parent::delete();
        db_commit();
    }

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    /**
     * This function builds the artefact title from language and evaluation information
     * @see ArtefactType::display_title()
     */
    public function display_title() {
        $language = get_field('artefact', 'title', 'id', $this->parent);
        return $language . ' (' . $this->title . ')';
    }

    /**
     * Create an evaluation artefact for a user
     * @param $descriptorset_id The descriptorset to use as evaluation in this instance
     * @param $title The title of the evaluation created for this subject
     * @param $parent The parent item (e.g. subject)
     * @param $user_id The user to create the subject artefact for, defaults to the current user
     */
    public static function create_evaluation_for_user($descriptorset_id, $title, $parent, $user_id=null, $type=EVALUATION_ITEM_TYPE_DESCRIPTOR) {
        if (!isset($user_id)) {
            global $USER;
            $user_id = $USER->get('id');
        }

        // create evaluation artefact
        $evaluation = new ArtefactTypeEvaluation(0, array(
            'owner' => $user_id,
            'title' => $title,
            'parent' => $parent,
        	'descriptorset' => $descriptorset_id,
            'evaluator' => $user_id
        ));
        $evaluation->commit();

        if ($type == EVALUATION_ITEM_TYPE_DESCRIPTOR) {
            $descriptors = array();
            $descriptors_sql = 'SELECT d.id, d.goal_available
                    FROM artefact_epos_descriptor d
                    JOIN artefact_epos_descriptorset s ON s.id = d.descriptorset
                    WHERE s.id = ?';
            if ($descriptors = get_records_sql_array($descriptors_sql, array($descriptorset_id))) {
                $evaluation_item = (object) array('evaluation' => $evaluation->get('id'), 'value' => 0);
                foreach ($descriptors as $descriptor) {
                    $evaluation_item->descriptor = $descriptor->id;
                    if ($descriptor->goal_available == 1) {
                        $evaluation_item->goal = 0;
                    }
                    else {
                        unset($evaluation_item->goal);
                    }
                    insert_record('artefact_epos_evaluation_item', $evaluation_item);
                }
            }
        }
        else if ($type == EVALUATION_ITEM_TYPE_COMPLEVEL) {
            $competences = get_records_array('artefact_epos_competence', 'descriptorset', $descriptorset_id);
            $levels = get_records_array('artefact_epos_level', 'descriptorset', $descriptorset_id);
            foreach ($competences as $competence) {
                foreach ($levels as $level) {
                    $target_key = "$competence->id;$level->id";
                    $evaluation->add_item($type, null, $target_key);
                }
            }
        }
        else {
            throw new Exception("Cannot create evaluation with type '$type'");
        }
        return $evaluation;
    }

    public function add_item($type, $descriptor_id=null, $target_key=null, $goal=0) {
        $item = new stdClass();
        $item->evaluation = $this->id;
        $item->value = 0;
        $item->goal = $goal ? 1 : 0;
        $item->type = $type;
        $item->descriptor = $descriptor_id;
        $item->target_key = $target_key;
        return insert_record('artefact_epos_evaluation_item', $item, 'id', true);
    }

    public function delete_item($type, $descriptor_id=null, $target_key=null) {
        $args = array('artefact_epos_evaluation_item', 'type', $type, 'evaluation', $this->id);
        if ($descriptor_id !== null) {
            if ($target_key !== null) {
                throw new Exception("You must not specify both, descriptor and target_key.");
            }
            $args []= 'descriptor';
            $args []= $descriptor_id;
        }
        if ($target_key !== null) {
            $args []= 'target_key';
            $args []= $target_key;
        }
        call_user_func_array('delete_records', $args);
    }

    public function get_descriptorset() {
		if (!isset($this->descriptorset)) {
	        $this->descriptorset = Descriptorset::get_instance($this->descriptorset_id);
		}
		return $this->descriptorset;
    }

    public function get_descriptorset_id() {
        return $this->descriptorset_id;
    }

    public function get_customcompetences() {
        if (!$this->customcompetences) {
            $this->customcompetences = array();
            $sql = "SELECT * FROM artefact
                    WHERE artefacttype='customcompetence'
                    AND parent = ?";
            $competences = get_records_sql_array($sql, array($this->id));
            if ($competences) {
                foreach ($competences as $competence) {
                    $this->customcompetences[$competence->id] = new ArtefactTypeCustomCompetence(0, $competence);
                    $this->customcompetences[$competence->id]->set('dirty', false);
                }
            }
        }
        return $this->customcompetences;
    }

    public function check_permission() {
        global $USER;
        $user = $USER->get('id');
        if ($user !== $this->owner && $user !== $this->evaluator) {
            throw new AccessDeniedException(get_string('youarenottheownerofthisevaluation', 'artefact.epos'));
        }
    }

    /**
     * Retrieve the types of evaluation other than the given one.
     * @param int The type of evaluation which is not to return
     * @return array A list of evaluation types as id => form title
     */
    public static function other_types($type) {
        if ($type == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
            return array();
        }
        $allTypes = array(
            EVALUATION_ITEM_TYPE_DESCRIPTOR => get_string('evaluationtypedescriptor', 'artefact.epos'),
            EVALUATION_ITEM_TYPE_COMPLEVEL => get_string('evaluationtypecompetencelevel', 'artefact.epos')
        );
        unset($allTypes[$type]);
        return $allTypes;
    }

    public function get_complevel_type($competence_id, $level_id) {
        $key = "$competence_id;$level_id";
        if (isset($this->items_by_target_id[$key])) {
            $item = $this->items_by_target_id[$key];
            return $item->type;
        }
        else {
            return EVALUATION_ITEM_TYPE_DESCRIPTOR;
        }
    }

    /**
     * Calculate the results in an array of competences of levels.
     */
    public function results() {
        $descriptorset = $this->get_descriptorset();
        $customcompetences = $this->get_customcompetences();
        $customgoals = array();
        foreach ($customcompetences as $competence) {
            foreach ($competence->get_customgoals() as $goal) {
                $customgoals[(string)$goal->get('id')] = $goal;
            }
        }
        $max_rating = count($descriptorset->ratings) - 1;
        $results = array();
        $empty_complevel = array(
            'value' => 0,
            'max' => 0,
            'evaluation_sums' => array_fill(0, $max_rating+1, 0)
        );
        foreach ($this->items as $item) {
            if ($item->type == EVALUATION_ITEM_TYPE_DESCRIPTOR) {
                $descriptor = $descriptorset[$item->descriptor];
                $competence_id = $descriptor->competence;
                $level_id = $descriptor->level;
            }
            else if ($item->type == EVALUATION_ITEM_TYPE_COMPLEVEL) {
                list($competence_id, $level_id) = split(";", $item->target_key);
            }
            else if ($item->type == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                $goal = $customgoals[$item->target_key];
                $competence_id = $goal->get('parent');
                $level_id = 0; // there is always only one level
            }
            if (!isset($results[$competence_id]['levels'][$level_id])) {
                $results[$competence_id]['levels'][$level_id] = $empty_complevel;
            }
            $complevel = &$results[$competence_id]['levels'][$level_id];
            $complevel['value'] += $item->value;
            $complevel['max'] += $max_rating;
            $complevel['type'] = $item->type;
            increase_array_value($complevel['evaluation_sums'], $item->value);
        }
        foreach ($results as $competence_id => &$competence) {
            $competence['id'] = $competence_id;
            $levels = &$competence['levels'];
            ksort($levels);
            foreach ($levels as &$complevel) {
                $complevel['average'] = round(100 * $complevel['value'] / $complevel['max']);
            }
            $competence['type'] = $complevel['type'];
            if ($complevel['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                $competence['name'] = $this->customcompetences[$competence_id]->get('title');
            }
            else {
                if (is_object($descriptorset->competences[$competence_id])) {
                    $competence['name'] = $descriptorset->competences[$competence_id]->name;
                }
            }
        }
        // sort results alphabetically with custom competences at the very buttom
        usort($results, function($left, $right) {
            if ($left['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL &&
                $right['type'] != EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                return 1;
            }
            if ($right['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL &&
                $left['type'] != EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                return -1;
            }
            return strcmp($left['name'], $right['name']);
        });
        return $results;
    }

    /**
     * Used by views to display this artefact.
     * @see ArtefactType::render_self()
     */
    public function render_self($options, $blockid = 0) {
        return array('html' => $this->render_evaluation_table(false), 'javascript' => '');
    }

    /**
     * Get the forms and JS necessary to display the self-evaluation.
     * @return array ($html, $includejs)
     */
    public function render_evaluation() {
        $evaluationform = $this->form_evaluation_all_types();
        $smarty = smarty();
        $smarty->assign('id', $this->get('id'));
        $smarty->assign('evaluationform', $evaluationform);
        $smarty->assign('evaltable', $this->render_evaluation_table(true));
        $includejs = array(
            'artefact/epos/js/jquery/jquery.simplemodal.1.4.4.min.js',
            'artefact/epos/js/evaluation.js',
            'artefact/epos/js/customgoals.js'
        );
        return array(
            'html' => $smarty->fetch('artefact:epos:evaluation.tpl'),
            'includejs' => $includejs
        );
    }

    /**
     * Build all forms for all competences > levels > types
     */
    private function form_evaluation_all_types() {
        $descriptorset = $this->get_descriptorset();
        $descriptorsetfile = substr($descriptorset->file, 0, count($descriptorset->file) - 5);
        $ratings = array();
        foreach ($descriptorset->ratings as $id => $rating) {
            $ratings[] = $rating->name;
        }
        $types = array(EVALUATION_ITEM_TYPE_DESCRIPTOR, EVALUATION_ITEM_TYPE_COMPLEVEL);
        $elements = array();
        // Add empty header cells so the "Goal?" header is in its place
        $header = array(
                'type' => 'html',
                'title' => '',
                'value' => ''
        );
        $elements['header1'] = $elements['header2'] = $elements['header3'] = $header;
        $elements['header_goal'] = array(
                'type' => 'html',
                'title' => '',
                'value' => get_string('goal', 'artefact.epos') . '?'
        );
        foreach ($descriptorset->competences as $competence) {
            foreach ($descriptorset->levels as $level) {
                $elements["item_{$competence->id}_{$level->id}_overall"] = array(
                        'type' => 'checkbox',
                        'title' => "Overall $competence->id $level->id",
                        'defaultvalue' => false
                );
                $this->form_evaluation_descriptors($elements, $ratings, $descriptorsetfile, $competence, $level);
                $this->form_evaluation_complevel($elements, $ratings, $competence, $level);
            }
        }
        foreach ($this->get_customcompetences() as $competence) {
            $elements["item_{$competence->id}_0_overall"] = array(
                    'type' => 'hidden',
                    'title' => "Overall $competence->id 0",
                    'value' => false
            );
            $this->form_evaluation_customgoals($elements, $ratings, $competence);
        }
        $elements['id'] = array(
                'type' => 'hidden',
                'value' => $this->id
        );
        $elements['submit'] = array(
                'type' => 'submit',
                'title' => ' ',
                'value' => get_string('save', 'artefact.epos')
        );
        $evaluationform = array(
                'name' => "evaluationform",
                'plugintype' => 'artefact',
                'pluginname' => 'epos',
                'jsform' => true,
                'renderer' => 'multicolumntable',
                'elements' => $elements,
                'elementclasses' => true,
                'successcallback' => array('ArtefactTypeEvaluation', 'submit_evaluationform'),
                'jssuccesscallback' => 'evaluationSaveCallback'
        );
        return pieform($evaluationform);
    }

    /**
     * Create form elements for the overall rating of this competence and level.
     * @param array $elements
     * @param array $ratings
     * @param object $competence
     * @param object $level
     */
    private function form_evaluation_complevel(&$elements, $ratings, $competence, $level) {
        $key = "$competence->id;$level->id";
        if (array_key_exists($key, $this->items_by_target_id)) {
            $item = $this->items_by_target_id[$key];
            $value = $item->value;
            // Override the "is overall evaluation" setting (default: false)
            $elements["item_{$competence->id}_{$level->id}_overall"]['defaultvalue'] = true;
        }
        else {
            $value = 0;
        }
        $index = "item_{$competence->id}_{$level->id}_" . EVALUATION_ITEM_TYPE_COMPLEVEL;
        $elements[$index] = array(
                'type' => 'radio',
                'title' => get_string('overallrating', 'artefact.epos') . " $competence->name – $level->name",
                'options' => $ratings,
                'defaultvalue' => $value,
        );
    }

    /**
     * Create form elements for each descriptor in this competence and level.
     * @param array $elements
     * @param array $ratings
     * @param string $descriptorsetfile
     * @param object $competence
     * @param object $level
     */
    private function form_evaluation_descriptors(&$elements, $ratings, $descriptorsetfile, $competence, $level) {
        $descriptorset = $this->get_descriptorset();
        $goals = false;
        foreach ($descriptorset->get_descriptors($competence->id, $level->id) as $descriptor) {
            if ($descriptor->goal_available) {
                $goals = true;
            }
            $this->form_evaluation_descriptor($elements, $descriptor, $ratings, $descriptorsetfile, $competence, $level);
        }
        if (!$goals) {
            unset($elements['header_goal']);
        }
    }

    private function form_evaluation_descriptor(&$elements, $descriptor, $ratings, $descriptorsetfile, $competence, $level) {
        global $THEME;
        if (isset($this->items_by_descriptor_id[$descriptor->id])) {
            $item = $this->items_by_descriptor_id[$descriptor->id];
        }
        else {
            $item = new stdClass();
            $item->value = 0;
            $item->goal = 0;
        }
        $index = "item_{$competence->id}_{$level->id}_" . EVALUATION_ITEM_TYPE_DESCRIPTOR . '_' . $descriptor->id;
        $elements[$index . '_link'] = array(
                'type' => 'html',
                'title' => $descriptor->name,
                'value' => ''
        );
        //link
        $imgUrl = $THEME->get_url('images/help.png');;
        if ($descriptor->link != '') {
            //check if http(s):// is present in link
            if (substr($descriptor->link, 0, 7) != "http://" && substr($descriptor->link, 0, 8) != "https://") {
                $descriptor->link = "../example.php?d=" . $descriptorsetfile . "&l=" . $descriptor->link;
            }
            $elements[$index . '_link']['value'] = "<a href=\"$descriptor->link\" onclick=\"openPopup('$descriptor->link'); return false;\">"
                    . "<img src=\"$imgUrl\" /></a>";
        }
        $elements[$index] = array(
                'type' => 'radio',
                'title' => $descriptor->name,
                'options' => $ratings,
                'defaultvalue' => $item->value,
        );
        //goal checkbox
        if ($descriptor->goal_available) {
            $elements[$index . '_goal'] = array(
                    'type' => 'checkbox',
                    'title' => $descriptor->name,
                    'defaultvalue' => $item->goal,
            );
        }
    }

    /**
     * Create form elements for each custom goal in this custom competence
     * @param array $elements
     * @param array $ratings
     * @param string $descriptorsetfile
     * @param object $competence
     * @param object $level
     */
    private function form_evaluation_customgoals(&$elements, $ratings, $customcompetence) {
        global $THEME;
        foreach ($customcompetence->get_customgoals() as $goal) {
            $key = (string)$goal->get('id');
            if (isset($this->items_by_target_id[$key])) {
                $item = $this->items_by_target_id[$key];
                $value = $item->value;
            }
            else {
                throw new Exception("No evaluation item for custom goal " . $goal->get('id'));
            }
            $goal_id = $goal->get('id');
            $title = $goal->get('description');
            $editCustomgoal = get_string('edit');
            $deleteCustomgoal = get_string('delete');
            $editbuttonurl = $THEME->get_url('images/btn_edit.png');
            $deletebuttonurl = $THEME->get_url('images/btn_deleteremove.png');
            $index = "item_{$customcompetence->id}_0_" . EVALUATION_ITEM_TYPE_CUSTOM_GOAL . "_$goal_id";

            $elements[$index] = array(
                    'type' => 'radio',
                    'title' => $title,
                    'options' => $ratings,
                    'defaultvalue' => $value,
            );
            $elements[$index . '_goal'] = array(
    				'type' => 'checkbox',
    				'title' => $title,
    				'defaultvalue' => $item->goal,
    		);
            $elements[$index . '_actions'] = array(
                    'type' => 'html',
                    'title' => $title,
                    'value' => <<< EOL
                        <div style="white-space:nowrap;">
                            <a href="javascript: deleteCustomGoal('$goal_id');" title="$deleteCustomgoal">
                                <img src="$deletebuttonurl" alt="$deleteCustomgoal">
                            </a>
                        </div>
EOL
            );
        }
    }

    /**
     * Render the HTML table for this evaluation.
     * @param string $interactive Whether javascript links should be generated that toggle forms
     * @return string The HTML of the table
     */
    public function render_evaluation_table($interactive = true) {
        $descriptorset = $this->get_descriptorset();
        $results = $this->results();

        $column_titles = array_map(function ($item) {
        	// If column labels contain a colon, return only the part before it (useful in cases where competence level names are very long)
            $returnstr = explode(':', $item->name);
            return $returnstr[0];
        }, $descriptorset->levels);
        array_unshift($column_titles, get_string('competence', 'artefact.epos'));

        $column_definitions = array(
            function ($row) {
                $cell = array('content' => $row['name']);
                $cell['properties']['title'] = get_string('standardcompetencearea', 'artefact.epos');
                if ($row['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                    $cell['properties']['class'] = "custom";
                    $cell['properties']['title'] = get_string('customcompetencearea', 'artefact.epos');
                }
                return $cell;
            }
        );
        $levelcount = count($descriptorset->levels);
        foreach ($descriptorset->levels as $level) {
            $column_definitions []= function ($row) use ($level, $levelcount, $interactive) {
                if ($row['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                    $level_id = 0;
                }
                else {
                    $level_id = $level->id;
                }
                $content = isset($row['levels'][$level_id]) ? html_progressbar($row['levels'][$level_id]['average']) : '';
                $cell = array('content' => $content);
                $classes = array();
                if ($interactive) {
                    $competence_id = $row['id'];
                    if (is_string($competence_id)) {
                        $competence_id = "'$competence_id'";
                    }
                    if (isset($row['levels'][$level_id])) {
                        $type = $row['levels'][$level_id]['type'];
                        $name = $row['name'];
                        $cell['properties'] = array(
                                'onclick' => "toggleEvaluationForm($competence_id, $level_id, $type, '$name', '$level->name')"
                        );
                    }
                    $classes []= "interactive";
                }
                if ($row['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                    $cell['properties']['colspan'] = $levelcount;
                    $cell['break'] = true;
                    $classes []= "custom";
                }
                $cell['properties']['class'] = implode(' ', $classes);
                return $cell;
            };
        }
        $eval_table = new HTMLTable_epos($column_titles, $column_definitions);
        $eval_table->add_table_classes('evaluation');
        $eval_table->always_even = true;
        return $eval_table->render($results);
    }

    /**
     * This writes changed evaluation items to the database.
     */
    public static function submit_evaluationform(Pieform $form, $values) {
        $evaluation = array();
        $id = $values['id'];

        foreach ($values as $key => $value) {
            $parts = explode('_', $key);

            if (preg_match('/^item_[0-9]+_[0-9]+_.+$/', $key)) {
                $complevel = "$parts[1];$parts[2]";
                if (!isset($evaluation[$complevel])) {
                    $evaluation[$complevel] = array();
                }
                // e.g. "item_5_6_typeused"
                if (preg_match('/^item_[0-9]+_[0-9]+_overall$/', $key)) {
                    $evaluation[$complevel]['overall'] = $value;
                }
                if (preg_match('/^item_[0-9]+_[0-9]+_[0-9]_.+$/', $key)) {
                    $descriptor = $parts[4];
                    if (!isset($evaluation[$complevel]['descriptors'])) {
                        $evaluation[$complevel]['descriptors'] = array();
                        $evaluation[$complevel]['descriptors'][$descriptor] = array();
                    }
                    if (!isset($evaluation[$complevel]['type'])) {
                        $evaluation[$complevel]['type'] = intval($parts[3]);
                    }
                    // e.g. "item_5_6_0_60"
                    if (preg_match('/^item_[0-9]+_[0-9]+_[0-9]_[0-9]+$/', $key)) {
                        $evaluation[$complevel]['descriptors'][$descriptor]['value'] = intval($value);
                    }
                    // e.g. "item_5_6_0_60_goal"
                    else if (preg_match('/^item_[0-9]+_[0-9]+_[0-9]_[0-9]+_goal$/', $key)) {
                        $evaluation[$complevel]['descriptors'][$descriptor]['goal'] = $value ? 1 : 0;
                    }
                }
                // e.g. "item_5_6_1"
                if (preg_match('/^item_[0-9]+_[0-9]+_1$/', $key)) {
                    $evaluation[$complevel]['value'] = intval($value);
                }
            }
        }

        try {
            db_begin();
            foreach ($evaluation as $complevel => $compleveldata) {
                if (!array_key_exists('type', $compleveldata) || !array_key_exists('overall', $compleveldata)) {
                    continue;
                }
                list($competence, $level) = explode(';', $complevel);
                $type = $compleveldata['type'];
                $isOverall = $compleveldata['overall'];

                $data = new stdClass();
                $data->evaluation = $id;
                $where = new stdClass();
                $where->evaluation = $id;

                // Delete descriptor values when overall evaluation is used, and vice versa
                if ($isOverall) {
                    $sql = "DELETE FROM artefact_epos_evaluation_item ei
                            USING artefact_epos_descriptor d
                            WHERE ei.descriptor = d.id
                            AND ei.evaluation = ? AND ei.type = ? AND d.competence = ? AND d.level = ?";
                    if (is_mysql()) {
                        $sql = "DELETE FROM ei
                                USING artefact_epos_evaluation_item ei
                                INNER JOIN artefact_epos_descriptor d ON ei.descriptor = d.id
                                WHERE ei.evaluation = ? AND ei.type = ? AND d.competence = ? AND d.level = ?";
                    }
                    execute_sql($sql, array($id, EVALUATION_ITEM_TYPE_DESCRIPTOR, $competence, $level));

                    $where->target_key = $complevel;
                    $data->target_key = $complevel;
                    $data->type = EVALUATION_ITEM_TYPE_COMPLEVEL;
                    $data->value = $compleveldata['value'];
                    ensure_record_exists('artefact_epos_evaluation_item', $where, $data);
                }
                else {
                    delete_records('artefact_epos_evaluation_item',
                        'evaluation', $id,
                        'type', EVALUATION_ITEM_TYPE_COMPLEVEL,
                        'target_key', $complevel);

                    foreach ($compleveldata['descriptors'] as $descriptor => $descriptordata) {
                        if ($type === EVALUATION_ITEM_TYPE_DESCRIPTOR) {
                            $where->descriptor = $descriptor;
                            $data->descriptor = $descriptor;
                        }
                        else if ($type === EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                            $where->target_key = $descriptor;
                            $data->target_key = $descriptor;
                        }
                        $data->type = $type;
                        $data->value = $descriptordata['value'];
                        $data->goal = $descriptordata['goal'];
                        ensure_record_exists('artefact_epos_evaluation_item', $where, $data);
                    }
                }
            }
            $evaluation = new ArtefactTypeEvaluation($id);
            $evaluation->set('mtime', time());
            $evaluation->commit();
            db_commit();
        }
        catch (Exception $e) {
            db_rollback();
            $form->json_reply(PIEFORM_ERR, $e->getMessage());
        }
        $form->json_reply(PIEFORM_OK, get_string('savedevaluation', 'artefact.epos'));
    }

    /**
     * Return a selector form for the user's evaluations that navigates
     * to the current site with id parameter set to the selected evaluation's id.
     * @param string $owner The owner of the evaluations.
     * @return array ($selectform, $selected)
     */
    public static function form_user_evaluation_selector($selected = null, $owner = null) {
        if (!isset($owner)) {
            global $USER;
            $owner = $USER->get('id');
        }
        $sql = "SELECT a.id, a.parent, a.title as descriptorset, b.title
            	FROM artefact a, artefact b, artefact_epos_evaluation e
            	WHERE a.parent = b.id
                    AND a.id = e.artefact
                    AND a.owner = ?
                    AND a.artefacttype = ?
                    AND e.final = 0";

        if (!$data = get_records_sql_array($sql, array($owner, 'evaluation'))) {
            return array(null, false);
        }
        // sort alphabetically by title
        usort($data, function ($a, $b) { return strcoll($a->title, $b->title); });
        // select first language if no selected is given
        if (!$selected) {
            $id = $data[0]->id;
        }
        else {
            $id = $selected;
        }
        foreach ($data as $subject) {
            $subject->title = "$subject->title ($subject->descriptorset)";
        }
        //$selectform = get_string('selfevaluations', 'artefact.epos') . ': ';
        $selectform = html_select($data, get_string('select'), "id", $id);
        return array($selectform, $id);
    }

    public static function get_users_evaluations() {
        global $USER;
        $evaluations = get_records_sql_array("
                SELECT e.id, e.title, e.ctime, s.id as s_id, s.title s_title
                FROM artefact e
                    LEFT JOIN artefacts ON e.parent = s.id
                WHERE e.artefacttype = 'storedevaluation'
                    AND e.owner = ?
                ORDERY BY s_id, e.ctime
                ", array($USER->get('id')));
        // TODO: do sth.
    }

    public static function form_store_evaluation($evaluation_id) {
        $elements = array();
        $elements['name'] = array(
                'type' => 'text',
                'title' => get_string('evaluationname', 'artefact.epos'),
                'defaultvalue' => '',
                'rules' => array('required' => true)
        );
        $elements['evaluation'] = array(
                'type' => 'hidden',
                'value' => $evaluation_id
        );
        $elements['submit'] = array(
                'type' => 'submit',
                'value' => get_string('save'),
        );
        return pieform(array(
                'name' => 'store_evaluation',
                'class' => 'store_evaluation',
                'plugintype' => 'artefact',
                'pluginname' => 'epos',
                'elements' => $elements,
                'jsform' => false,
                'renderer' => 'oneline',
                'validatecallback' => array('ArtefactTypeEvaluation', 'form_store_evaluation_validate'),
                'successcallback' => array('ArtefactTypeEvaluation', 'form_store_evaluation_submit')
        ));
    }

    public static function form_store_evaluation_validate($form, $values) {
        global $USER;
        $records = get_records_array('artefact', 'artefacttype', 'evaluation',
                'owner', $USER->get('id'), 'title', $values['name']);
        if ($records) {
            $form->set_error("name", get_string('evaluationnamealreadyexists', 'artefact.epos'));
        }
    }

    public static function form_store_evaluation_submit($form, $values) {
        global $USER, $SESSION;
        $evaluation = new ArtefactTypeEvaluation($values['evaluation']);
        $evaluation->check_permission();
        $stored_evaluation = new ArtefactTypeEvaluation($evaluation);
        $stored_evaluation->set('title', $values['name']);
        $stored_evaluation->final = 1;
        $stored_evaluation->evaluator = $USER->get('id');
        $stored_evaluation->commit();
        $SESSION->add_info_msg(get_string('evaluationsuccessfullystored', 'artefact.epos'));
        redirect(get_config('wwwroot') . '/artefact/epos/evaluation/stored.php');
    }

    public static function form_delete_evaluation($evaluation_id) {
        $elements = array();
        $elements['evaluation'] = array(
                'type' => 'hidden',
                'value' => $evaluation_id
        );
        $elements['submit'] = array(
                'type' => 'submitcancel',
                'value' => array(get_string('deleteevaluation', 'artefact.epos'), get_string('cancel')),
                'goto' => get_config('wwwroot') . '/artefact/epos/evaluation/stored.php'
        );
        return pieform(array(
                'name' => 'delete_evaluation',
                'class' => 'delete_evaluation',
                'plugintype' => 'artefact',
                'pluginname' => 'epos',
                'elements' => $elements,
                'jsform' => false,
                'renderer' => 'oneline',
                'successcallback' => array('ArtefactTypeEvaluation', 'form_delete_evaluation_submit')
        ));
    }

    public static function form_delete_evaluation_submit(Pieform $form, $values) {
        global $evaluation;
        $evaluation->delete();
        redirect(get_config('wwwroot') . '/artefact/epos/evaluation/stored.php');
    }

    /**
     * Get all records (not instances) of evaluations, final and current
     * ordered by mtime
     * @return array The records: id, title, mtime, subject (title), evaluator (id), final, firstname, lastname, descriptorset_id, descriptorset
     */
    public static function get_all_stored_evaluation_records() {
        global $USER;
        // "AND NOT (a.owner != e.evaluator AND e.final = 0)" makes sure open evaluation requests are not shown
        $evaluations = get_records_sql_array("
                SELECT a.owner, a.id, a.title, a.mtime, s.title AS subject, e.evaluator, e.final, usr.firstname,
                        usr.lastname, d.id AS descriptorset, d.name AS descriptorset
                FROM artefact a
                INNER JOIN artefact s ON a.parent = s.id
                INNER JOIN artefact_epos_evaluation e ON a.id = e.artefact
                LEFT JOIN artefact_epos_descriptorset d ON e.descriptorset = d.id
                LEFT JOIN usr ON e.evaluator = usr.id
                RIGHT JOIN (
                    SELECT e1.parent, d1.id
                    FROM artefact e1
                    LEFT JOIN artefact_epos_evaluation e2 ON e1.id = e2.artefact
                    LEFT JOIN artefact_epos_descriptorset d1 ON e2.descriptorset = d1.id
                    WHERE e1.artefacttype = 'evaluation'
                        AND NOT (e1.owner != e2.evaluator AND e2.final = 0)
                    GROUP BY e1.parent, d1.id
                    HAVING count(d1.id) > 1
                ) c ON s.id = c.parent
                WHERE a.artefacttype = 'evaluation'
                    AND c.id = d.id
                    AND a.owner = ?
                    AND NOT (a.owner != e.evaluator AND e.final = 0)
                ORDER BY s.title, descriptorset, e.final DESC, a.mtime
                ", array($USER->get('id')));
        if ($evaluations) {
            foreach ($evaluations as $evaluation) {
                $evaluation->mtime = format_date(strtotime($evaluation->mtime));
            }
            return $evaluations;
        }
        return array();
    }

}


class ArtefactTypeCustomGoal extends ArtefactType {

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    public static function form_add_customgoal($is_goal=false, $jscallback='evaluationSaveCallback') {
        $elements = array();
        $elements['customcompetence'] = array(
            'type' => 'text',
            'width' => '565px',
            'title' => get_string('competence', 'artefact.epos'),
            'defaultvalue' => '',
            'rules' => array('required' => true)
        );
        $elements['customgoal'] = array(
            'type' => 'textarea',
            'rows' => '2',
            'width' => '565px',
            'resizable' => false,
            'title' => get_string('customlearninggoal', 'artefact.epos'),
            'defaultvalue' => '',
            'rules' => array('required' => true)
        );
        $elements['competence'] = array(
                'type' => 'hidden',
                'value' => -1, // will be set on client side
                'sesskey' => true // indicate that the value may be changed by the client
        );
        $elements['is_goal'] = array(
            'type' => 'hidden',
            'value' => $is_goal
        );
        $elements['submit'] = array(
            'type' => 'submit',
            'value' => get_string('add'),
        );
        $customdescriptorform = pieform(array(
            'name' => 'addcustomgoal',
            'class' => 'addcustomgoal',
            'plugintype' => 'artefact',
            'pluginname' => 'epos',
            'elements' => $elements,
            'jsform' => true,
            'validatecallback' => array('ArtefactTypeCustomGoal', 'form_addcustomgoal_validate'),
            'successcallback' => array('ArtefactTypeCustomGoal', 'form_addcustomgoal_submit'),
            'jssuccesscallback' => $jscallback
        ));
        return $customdescriptorform;
    }

    /**
     * Make sure the competence for the new custom goal is a custom one and the
     * new goal does not already exist.
     * @param Pieform $form
     * @param array $values
     */
    public static function form_addcustomgoal_validate(Pieform $form, $values) {
        if (isset($values['customcompetence'])) {
            global $evaluation;
            $descriptorset = $evaluation->get_descriptorset();
            $name = trim($values['customcompetence']);
            foreach ($descriptorset->competences as $competence) {
                if ($competence->name == $name) {
                    $form->set_error("customcompetence", get_string('customgoalsonlyincustomcompetence', 'artefact.epos'));
                    break;
                }
            }
            if (isset($values['customgoal'])) {
                $alreadyexistsincompetencesql = "
                        SELECT * FROM artefact acompetence
                        LEFT JOIN artefact agoal ON acompetence.id = agoal.parent
                        WHERE agoal.description = ? AND acompetence.title = ? AND acompetence.parent = ?
                        ";
                $description = trim($values['customgoal']);
                $containing_competences = get_records_sql_array($alreadyexistsincompetencesql,
                        array($description, $name, $evaluation->get('id')));
                if ($containing_competences) {
                    $form->set_error('customgoal', get_string('customgoalalreadyexistsincompetence', 'artefact.epos'));
                }
            }
        }
    }

    public static function form_addcustomgoal_submit(Pieform $form, $values) {
        try {
            global $evaluation, $USER;
            $text = $values['customgoal'];
            $competencename = trim($values['customcompetence']);
            $descriptorset = $evaluation->get_descriptorset();
            db_begin();
            $competence = get_record('artefact', 'artefacttype', 'customcompetence',
                    'parent', $evaluation->get('id'),
                    'title', $competencename);
            if (!$competence) {
                $competence = new ArtefactTypeCustomCompetence();
                $competence->set('title', $competencename);
                $competence->set('parent', $evaluation->get('id'));
                $competence->set('owner', $USER->get('id'));
                $competence->commit();
            }
            else {
                $competence = new ArtefactTypeCustomCompetence(0, $competence);
                $competence->set('dirty', false);
            }
            $customgoal = new ArtefactTypeCustomGoal();
            $customgoal->set('title', 'customgoal');
            $customgoal->set('description', $text);
            $customgoal->set('parent', $competence->get('id'));
            $customgoal->set('owner', $USER->get('id'));
            $customgoal->commit();
            $evaluation->add_item(EVALUATION_ITEM_TYPE_CUSTOM_GOAL, null, $customgoal->get('id'), $values['is_goal']);
            db_commit();
        }
        catch (Exception $e) {
            db_rollback();
            throw $e;
            $form->json_reply(PIEFORM_ERR, $e->getMessage());
        }
        $form->json_reply(PIEFORM_OK, get_string('savedevaluation', 'artefact.epos'));
    }

    /**
     * Delete this goal and also the competence it's in if it becomes empty.
     * @see ArtefactType::delete()
     */
    public function delete() {
        $competence = $this->get_parent_instance();
        $evaluation = $competence->get_parent_instance();
        $evaluation->delete_item(EVALUATION_ITEM_TYPE_CUSTOM_GOAL, null, $this->id);
        parent::delete();
        if ($competence->count_customgoals() == 0) {
            $competence->delete();
        }
    }

}



class ArtefactTypeCustomCompetence extends ArtefactType {

    protected $goals;

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    public function __clone() {
        $this->get_customgoals();
        foreach ($this->goals as &$goal) {
            $goal = clone $goal;
            $goal->set('parent', null);
        }
    }

    /**
     * Commit the changes. Return a map of goal ids (old => new) in case
     * the competence has been cloned.
     * @see ArtefactType::commit()
     */
    public function commit() {
        $new = empty($this->id);
        parent::commit();
        $id_map = array();
        foreach ($this->get_customgoals() as $goal) {
            $old_id = $goal->get('id');
            if ($new) {
                $goal->set('id', null);
                $goal->set('parent', $this->id);
            }
            $goal->commit();
            $id_map[$old_id] = $goal->get('id');
        }
        return $id_map;
    }

    public function get_customgoals() {
        if (!isset($this->goals)) {
            $records = get_records_array('artefact', 'parent', $this->id, 'id');
            $this->goals = array();
            if ($records !== false) {
                foreach ($records as $record) {
                    $this->goals []= new ArtefactTypeCustomGoal($record->id, $record);
                }
            }
        }
        return $this->goals;
    }

    public function count_customgoals() {
        $count = get_record_sql('SELECT COUNT(*) num FROM artefact WHERE artefacttype = ? AND parent = ?',
                array('customgoal', $this->id));
        return $count->num;
    }

}



class Descriptorset implements ArrayAccess, Iterator {

	private $id;

	private $name;

	public $file;

	public $visible;

	public $active;

	public $descriptors = array();

	public $ratings = array();

	public $levels = array();

	public $competences = array();

	private $descriptors_by_competence_level = array();

	private function __construct($id=0) {
		global $USER;
		// load
		if (!empty($id)) {
			if (!$data = get_record('artefact_epos_descriptorset', 'id', $id)) {
				throw new Exception(get_string('descriptorsetnotfound', 'artefact.epos'));
			}
			foreach((array)$data as $field => $value) {
				if (property_exists($this, $field)) {
					$this->{$field} = $value;
				}
			}
			$descriptor_sql = "SELECT d.id, d.name, d.link, d.goal_available, d.descriptorset, d.competence, d.level, c.name as competence_name
			        FROM artefact_epos_descriptor d
			        LEFT JOIN artefact_epos_competence c ON d.competence = c.id
			        WHERE d.descriptorset = ?
			        ORDER BY competence, level, id";
			if ($descriptors = get_records_sql_array($descriptor_sql, array($this->id))) {
				foreach ($descriptors as $descriptor) {
					$this->descriptors[$descriptor->id] = $descriptor;
					$this->descriptors_by_competence_level[$descriptor->competence][$descriptor->level] []= $descriptor;
				}
			}
			else exit;
			if ($ratings = get_records_array('artefact_epos_rating', 'descriptorset', $id, 'id')) {
				foreach ($ratings as $rating) {
					$this->ratings[$rating->id] = $rating;
				}
			}
			if ($levels = get_records_array('artefact_epos_level', 'descriptorset', $id, 'id')) {
				uasort($levels, function($a, $b) {
				    return strcasecmp($a->name, $b->name);
				});
				foreach ($levels as $level) {
					$this->levels[$level->id] = $level;
				}
			}
			if ($competences = get_records_array('artefact_epos_competence', 'descriptorset', $id, 'id')) {
				foreach ($competences as $competence) {
					$this->competences[$competence->id] = $competence;
				}
			}
		}
	}

	public static function get_instance($id) {
        static $cache = array();
        if (!isset($cache[$id])) {
            $cache[$id] = new Descriptorset($id);
        }
        return $cache[$id];
	}

	public function commit() {
		db_begin();
		$new = empty($this->id);
		$data = (object)array(
				'id'  => $this->id,
		);
		if ($new) {
			$success = insert_record('artefact_epos_descriptorset', $data);
		}
		else {
			$success = update_record('artefact_epos_descriptorset', $data, array('id'));
		}
		db_commit();
	}

	public function delete() {
		if (empty($this->id)) {
			return;
		}
		db_begin();
		// TODO: delete competences, ratings and levels
		delete_records('artefact_epos_descriptorset', 'id', $this->id);
		db_commit();
	}

	// array interface

	public function offsetExists($offset) {
		return isset($this->descriptors);
	}

	public function offsetGet($offset) {
		return $this->descriptors[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->descriptors[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->descriptors[$offset]);
	}

	// iterator interface

	public function rewind() {
        return reset($this->descriptors);
    }

    public function current() {
        return current($this->descriptors);
    }

    public function key() {
        return key($this->descriptors);
    }

    public function next() {
        return next($this->descriptors);
    }

    public function valid() {
        return current($this->descriptors) !== false;
    }

    // other

    public function get_id() {
        return $this->id;
    }

    public function get_descriptors($competence_id, $level_id) {
        if (array_key_exists($competence_id, $this->descriptors_by_competence_level) &&
            array_key_exists($level_id, $this->descriptors_by_competence_level[$competence_id])) {
            return $this->descriptors_by_competence_level[$competence_id][$level_id];
        }
        return array();
    }

    /**
     * Gets all descriptorsets for a given user's subject (artefact, not institution offer)
     * @param int $subject
     */
    public static function get_descriptorsets_for_mysubject_records($subject) {
        global $USER;
        $sets = get_records_sql_array("
                SELECT d.*
                FROM artefact_epos_descriptorset d
                INNER JOIN artefact_epos_evaluation e ON d.id = e.descriptorset_id
                INNER JOIN artefact ON e.artefact = artefact.id
                WHERE artefact.owner = ?
                    AND artefact.parent = ?
                ORDER BY d.name
                ", array((int)$USER->id, $subject)
        );
        return $sets ? $sets : array();
    }

    /**
     * Select the descriptorset of the first non-final evaluation of that subject.
     * @param int $subject
     */
    public static function get_default_descriptorset_for_subject_record($subject) {
        $set = get_record_sql("
                SELECT d.*
                FROM artefact_epos_descriptorset d
                INNER JOIN artefact_epos_evaluation e ON d.id = e.descriptorset
                INNER JOIN artefact a ON e.artefact = a.id
                WHERE a.parent = ?
                    AND e.final = 0
                    AND d.active = 1
                ORDER BY a.id
                LIMIT 1
                ", array($subject)
        );
        return $set ? $set : null;
    }

    /**
     * Check if the descriptorset is available for the subject (may be inactive).
     * @param int $descriptorset_id
     * @param int $subject_id
     * @return boolean
     */
    public static function is_valid_descriptorset_for_subject($descriptorset_id, $subject_id) {
        $sets = get_record_sql("
                SELECT d.*
                FROM artefact_epos_descriptorset d
                INNER JOIN artefact_epos_descriptorset_subject ds ON ds.descriptorset = d.id
                INNER JOIN artefact_epos_mysubject my ON ds.subject = my.subject
                WHERE my.artefact = ?
                    AND d.id = ?
                ", array($subject_id,$descriptorset_id)
        );
        return $sets != false;
    }
}


/**
 * load_descriptorset()
 *
 * will return something like:
 *     array(
 *         'Listening' => array(
 *             'A1' => array(
 *                 101 => array(
 *                     'name' => 'I can something',
 *                     'evaluations' => 'not at all; satisfactory; good',
 *                     'goal' => 1
 *                 102 => array(...),
 *                 etc.
 *             ),
 *             'A2' => array(
 *                 ...
 *             ),
 *             etc.
 *         ),
 *         'Reading' => array(
 *             ...
 *         ),
 *         etc.
 *     )
 */
function load_descriptors($id) {
    $sql = 'SELECT d.id, d.name, d.link, d.goal_available, c.name AS competence, l.name AS level FROM artefact_epos_descriptor d
            LEFT JOIN artefact_epos_competence c ON d.competence = c.id
            LEFT JOIN artefact_epos_level l ON d.level = l.id
            WHERE d.descriptorset = ?
            ORDER BY c.name, l.id, id';

    if (!$descriptors = get_records_sql_array($sql, array($id))) {
        $descriptors = array();
    }
    // TODO: move ratings to up to descriptor set layer
    if (!$ratings = get_records_array('artefact_epos_rating', 'descriptorset', $id, 'id')) {
        $ratings = array();
    }
    $ratings = implode(';', array_map(
        function($rating) { return $rating->name; }, $ratings));
    $competences = array();

    // group them by competences and levels:
    foreach ($descriptors as $desc) {
        if (!isset($competences[$desc->competence])) {
            $competences[$desc->competence] = array();
        }
        if (!isset($competences[$desc->competence][$desc->level])) {
            $competences[$desc->competence][$desc->level] = array();
        }
        $competences[$desc->competence][$desc->level][$desc->id] = array(
                'name' => $desc->name,
                'evaluations' => $ratings,
                'goal' => $desc->goal_available,
                'link' => $desc->link
        );
    }
    return $competences;
}

/*
 * write descriptors from xml into database
 * @param $xml path to the xml file
 *        $fileistemporary whether the file will be moved to its final destination later
 *        $subjectid ID of the subject the descriptorset shall be associated with
 *        $descriptorsetid = ID of the descriptorset that is to be replaced by a new one
 */
function write_descriptor_db($xml, $fileistemporary, $subjectid, $descriptorsetid=null) {
    if (file_exists($xml) && is_readable($xml)) {
        $contents = file_get_contents($xml);
        $xmlarr = xmlize($contents);

        $descriptorsettable = 'artefact_epos_descriptorset';
        $descriptortable = 'artefact_epos_descriptor';

        $descriptorset = $xmlarr['DESCRIPTORSET'];
        $values['name'] = $descriptorsetname = $descriptorset['@']['NAME'];
        if ($fileistemporary) {
            $values['file'] = 'unknown'; //file name may not be known yet
        }
        else {
            //extract file name from path
            $path = explode('/', $xml);
            foreach ($path as $word) {
                $values['file'] = $word;
            }
        }
        $values['visible'] = 1;
        $values['active'] = 1;

        //insert
        db_begin();
        $values['descriptorset'] = insert_record($descriptorsettable, (object)$values, 'id', true);

        insert_record('artefact_epos_descriptorset_subject', array(
                'descriptorset' => $values['descriptorset'],
                'subject' => $subjectid
        ));

        if ($descriptorsetid != null) {
            update_record(
                    $descriptorsettable,
                    (object) array('id' => $descriptorsetid, 'visible' => 0, 'active' => 0),
                    'id'
            );
        }

        $competences = array();
        $levels = array();

        foreach ($xmlarr['DESCRIPTORSET']['#']['DESCRIPTOR'] as $x) {
            $competence = $x['@']['COMPETENCE'];
            $level = $x['@']['LEVEL'];
            if (!isset($competences[$competence])) {
                $cid = insert_record('artefact_epos_competence', (object) array (
                    'descriptorset' => $values['descriptorset'],
                    'name' => $competence
                ), 'id', true);
                $competences[$competence] = $cid;
            }
            if (!isset($levels[$level])) {
                $lid = insert_record('artefact_epos_level', (object) array (
                    'descriptorset' => $values['descriptorset'],
                    'name' => $level
                ), 'id', true);
                $levels[$level] = $lid;
            }
            $values['competence'] = $competences[$competence];
            $values['level'] = $levels[$level];
            $values['name'] = $x['@']['NAME'];
            $values['link'] = $x['@']['LINK'];
            $values['goal_available'] = $x['@']['GOAL'];
            insert_record($descriptortable, (object)$values);
        }
        $ratings = array_map('trim', explode(';', $x['@']['EVALUATIONS']));
        foreach ($ratings as $rating) {
            insert_record('artefact_epos_rating', (object) array(
                'descriptorset' => $values['descriptorset'],
                'name' => $rating
            ));
        }
        db_commit();
        return array('id' => $values['descriptorset'], 'name' => $descriptorsetname);
    }
    return false;
}

function get_manageable_institutions($user) {
    if ($user->get('staff') == 1 || $user->get('admin') == 1) {
        $sql = "SELECT name, displayname FROM institution ORDER BY displayname";
        if (!$data = get_records_sql_array($sql, array())) {
            $data = array();
        }
    }
    else {
        $sql = "SELECT i.name, i.displayname FROM institution i
        JOIN usr_institution ui ON ui.institution = i.name
        WHERE ui.usr = ? AND (ui.staff = 1 OR ui.admin = 1)
        ORDER BY i.displayname";
        if (!$data = get_records_sql_array($sql, array($user->id))) {
            $data = array();
        }
    }
    return $data;
}

/**
 * Create a subject artefact for a user with a evaluation assigned
 * @param $subject_id The subject the user chooses to partake in
 * @param $subject_title The title the user assigns to that subject's instance
 * @param $descriptorset_id The descriptorset to use as evaluation in this instance
 * @param $evaluation_title The title of the evaluation created for this subject
 * @param $user_id The user to create the subject artefact for, defaults to the current user
 */
function create_subject_for_user($subject_id, $subject_title, $descriptorset_id, $evaluation_title, $user_id=null) {
    if (!isset($user_id)) {
        global $USER;
        $user_id = $USER->get('id');
    }

    // update artefact 'subject' ...
    $sql = "SELECT * FROM artefact WHERE owner = ? AND artefacttype = 'subject' AND title = ?";
    if ($subjects = get_records_sql_array($sql, array($user_id, $subject_title))) {
        $subject = artefact_instance_from_id($subjects[0]->id);
        $subject->set('mtime', time());
        $subject->commit();
        $id = $subject->get('id');
    }
    // ... or create it if it doesn't exist
    else {
        safe_require('artefact', 'epos');
        $subject = new ArtefactTypeSubject(0, array(
                'owner' => $user_id,
                'title' => $subject_title,
            )
        );
        $subject->commit();
        $id = $subject->get('id');
        //insert: artefact_epos_mysubject
        $values_artefact_subject = array('artefact' => $id, 'subject' => $subject_id);
        insert_record('artefact_epos_mysubject', (object)$values_artefact_subject);
    }

    /*
    // if there is already an evaluation with the given title, don't create another one
    $sql = 'SELECT * FROM artefact WHERE parent = ? AND title = ?';
    if (get_records_sql_array($sql, array($id, $evaluation_title))) {
        return;
    }
    */
    ArtefactTypeEvaluation::create_evaluation_for_user($descriptorset_id, $evaluation_title, $id, $user_id);
}



function increase_array_value(&$data, $key, $value=1) {
    if (!array_key_exists($key, $data)) {
        $data[$key] = $value;
    }
    else {
        $data[$key] += $value;
    }
}


class HTMLTable_epos {

    public $titles;
    public $cols;
    public $id;
    public $data;
    private $even = true;
    public $table_classes = array();
    public $properties = array();

    // if true, appends an empty row in case there's an odd number of rows
    public $always_even = false;

    /**
     *
     * @param array $titles
     *            List of column titles
     * @param array $cols
     *            Column definition e.g. array('propertyName', callback($row), ...)
     * @param array $data
     *            List of objects
     */
    public function __construct($titles, $cols) {
        $this->titles = $titles;
        $this->cols = $cols;
        if (count($cols) != count($titles)) {
            throw new Exception("The number or column definitions does not match the number of column titles.");
        }
    }

    public function add_table_classes($classes) {
        if (!is_array($classes)) {
            $classes = array($classes);
        }
        $this->table_classes = array_merge($this->table_classes, $classes);
    }

    private function zebra_classes() {
        $this->even = !$this->even;
        return $this->even ? "even r0" : "odd r1";
    }

    /**
     * Generate HTML from a list of data objects (like record sets)
     *
     * @param array $data List of objects
     */
    public function render($data) {
        $this->data = $data;
        $classes = ' class="' . implode(" ", $this->table_classes) . '"';
        $properties = $this->render_properties($this->properties);
        $out = "<table $classes $properties>\n";
        $out .= "<thead><tr>\n";
        foreach ($this->titles as $id => $title) {
            $column_id = "column_";
            $column_id .= isset($this->id) ? $this->id . '_' . $id : $id;
            $out .= "<th class=\"$column_id\">$title</th>";
        }
        $out .= "</tr></thead>\n";
        $out .= "<tbody>\n";
        while ($row = current($this->data)) {
            $out .= $this->render_row($row);
            next($this->data);
        }
        if ($this->always_even && !$this->even) {
            $out .= $this->render_empty_row();
        }
        $out .= "</tbody>\n";
        $out .= "</table>\n";
        return $out;
    }

    private function render_row($row) {
        $classes = $this->zebra_classes();
        $out = "<tr class=\"$classes\">";
        if (is_array($row)) {
            $row['__id'] = key($this->data);
        }
        else if (is_object($row)) {
            $row->__id = key($this->data);
        }
        foreach ($this->cols as $col) {
            if (is_callable($col)) {
                $value = $col($row);
            }
            else if (is_array($row) && isset($row[$col])) {
                $value = $row[$col];
            }
            else if (is_object($row) && isset($row->$col)) {
                $value = $row->$col;
            }
            else {
                throw new Exception("Unexpected column definition: " . $col);
            }
            $properties = "";
            $break = false;
            if (is_array($value)) {
                if (isset($value['properties'])) {
                    $properties = $this->render_properties($value['properties']);
                }
                $break = isset($value['break']) && $value['break'];
                $value = $value['content'];
            }
            $out .= "<td $properties>$value</td>";
            if ($break) {
                break;
            }
        }
        $out .= "</tr>\n";
        return $out;
    }

    private function render_empty_row() {
        $classes = $this->zebra_classes();
        $colspan = count($this->cols);
        return "<tr class=\"$classes\"><td colspan=\"$colspan\"></td>\n";
    }

    private function render_properties($properties) {
        if (is_object($properties)) {
            $properties = (array) $properties;
        }
        $rendered = array();
        foreach ($properties as $property => $propvalue) {
            $rendered []= "$property=\"$propvalue\"";
        }
        return implode(" ", $rendered);
    }

}

function html_progressbar($value, $content=null, $color="") {
    if ($color) {
        $color = '-' . $color;
    }
    $wwwroot = get_config('wwwroot');
    $html = <<<EOF
<div class="progressbar">
    <div class="progressbar-value" style="width: {$value}%; background-image: url('{$wwwroot}artefact/epos/images/progressbar-fill{$color}.png');">
    </div>
EOF;
    if (isset($content)) {
        $html .= <<<EOF
    <span class="progressbar-content">
        {$content}
    </span>
EOF;
    }
    $html .= <<<EOF
</div>
EOF;
    return $html;
}

/**
 * Render an html select form.
 * @param array $data An array of objects with id and title
 * @param string $value The value of the submit button
 * @param string $name The name of the select
 * @param string $selected The id of the selected element if any
 * @param array $hidden Hidden values to store in the form (array of objects with name and value)
 */
function html_select($data, $value, $name, $selected=null, $hidden=array()) {
    $selectform = '<form action="" method="GET"><select name="' . $name . '">';
    foreach ($data as $item) {
        $selected_property = '';
        if ($item->id == $selected) {
            $selected_property = 'selected="selected"';
        }
        $selectform .= "<option value=\"$item->id\" $selected_property>$item->title</option>";
    }
    $selectform .= '</select>';
    $selectform .= "<input type=\"submit\" value=\"$value\" />";
    foreach ($hidden as $hidden_input) {
        $selectform .= '<input type="hidden" name="' . $hidden_input->name . '" value="' . $hidden_input->value . '" />';
    }
    $selectform .= '</form>';
    return $selectform;
}

function assert_integer($value) {
    $value = trim($value);
    if (preg_match('/^\d+$/', $value)) {
        return (int)$value;
    }
    throw new ParameterException("$value is not an integer");
}
