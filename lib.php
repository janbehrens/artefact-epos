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
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 TZI / Universität Bremen
 *
 */

defined('INTERNAL') || die();

include_once('xmlize.php');

class PluginArtefactEpos extends PluginArtefact {

    public static function get_artefact_types() {
        return array('evaluation');
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
                'path' => 'identify/selfevaluation',
                'title' => get_string('selfevaluation', 'artefact.epos'),
                'url' => 'artefact/epos/evaluation/self-eval.php',
                'weight' => 20,
            ),
            array(
                'path' => 'identify/storedevaluations',
                'title' => get_string('storedevaluations', 'artefact.epos'),
                'url' => 'artefact/epos/evaluation/stored.php',
                'weight' => 21,
            ),
            array(
                'path' => 'identify/addremoveselfevaluations',
                'title' => get_string('addremoveevaluations', 'artefact.epos'),
                'url' => 'artefact/epos/index.php',
                'weight' => 22,
            ),
            array(
                'path' => 'plan',
                'url' => 'artefact/epos/goals.php',
                'title' => get_string('plan', 'pdp'),
                'weight' => 30,
            ),
            array(
                'path' => 'plan/goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 10,
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

class ArtefactTypeEvaluation extends ArtefactType {

    protected $descriptorset;

    protected $competences = array();

    protected $levels = array();

    protected $customcompetences = array();

    protected $competencelevels = array();

    protected $itemsbycompetencelevel = array();

    protected $final = 0;

    protected $evaluator;

    protected $evaluator_display_name;

    /**
     * Override the constructor to fetch extra data.
     *
     * @param integer $id The id of the element to load, 0 if new
     * @param object $data Data to fill the object with instead from the db
     * @param boolean $full_load Indicate whether the evaluation items should be loaded
     */
    public function __construct($id = 0, $data = null, $full_load = true) {
        parent::__construct($id, $data);
        if ($this->id && $full_load) {
            if (!isset($this->descriptorset)) {
                $sql = 'SELECT e.*, u.firstname, u.lastname
                        FROM artefact a
                        LEFT JOIN artefact_epos_evaluation e ON a.id = e.artefact
                        LEFT JOIN usr u ON e.evaluator = u.id
                        WHERE a.id = ?';
                $data = get_record_sql($sql, array($this->id));
                if ($data) {
                    foreach ($data as $field => $value) {
                        $this->{$field} = $value;
                    }
                    $fields = array('id', 'descriptorset', 'final');
                    foreach ($fields as $field) {
                        $this->{$field} = (int)$this->{$field};
                    }
                    $this->evaluator_display_name = "$data->firstname $data->lastname";
                }
                else {
                    // This should never happen unless the user is playing around with task IDs in the location bar or similar
                    throw new ArtefactNotFoundException(get_string('evaluationnotfound', 'artefact.epos'));
                }
            }
            $sql = "SELECT
                        ei.descriptor, ei.value, ei.goal,
                        d.name AS descriptor_name, d.link, d.competence, d.level, d.goal_available,
                        c.name AS competence_name,
                        l.name AS level_name
                    FROM artefact_epos_evaluation_item ei
                    LEFT JOIN artefact_epos_descriptor d ON ei.descriptor = d.id
                    LEFT JOIN artefact_epos_competence c ON d.competence = c.id
                    LEFT JOIN artefact_epos_level l ON d.level = l.id
                    WHERE ei.evaluation = ?";
            if ($items = get_records_sql_array($sql, array($this->id))) {
                foreach ($items as $item) {
                    $fields = array('descriptor', 'value', 'goal', 'competence', 'level', 'goal_available');
                    foreach ($fields as $field) {
                        $item->{$field} = (int)$item->{$field};
                    }
                    // If level is 0, it is a custom descriptor
                    if ($item->level == 0) {
                        $competence = new stdClass();
                        $competence->name = $item->competence_name;
                        $this->customcompetences[$item->competence] = $competence;
                        $item->level = 0;
                    }
                    if (!array_key_exists($item->competence, $this->itemsbycompetencelevel)) {
                        $this->itemsbycompetencelevel[$item->competence] = array();
                    }
                    if (!array_key_exists($item->level, $this->itemsbycompetencelevel[$item->competence])) {
                        $this->itemsbycompetencelevel[$item->competence][$item->level] = array();
                    }
                    $this->itemsbycompetencelevel[$item->competence][$item->level][] = $item;

                    // store competence and level names
                    if (!array_key_exists($item->competence, $this->competences)) {
                        $this->competences[$item->competence] = $item->competence_name;
                    }
                    if ($item->level != 0 && !array_key_exists($item->level, $this->levels)) {
                        $this->levels[$item->level] = $item->level_name;
                    }
                }
            }
            if ($items = get_records_array('artefact_epos_evaluation_competencelevel', 'evaluation', $this->id)) {
                foreach ($items as $item) {
                    $this->competencelevels["$item->competence;$item->level"] = $item;
                }
            }
        }
    }

    public function commit() {
        db_begin();
        $new = empty($this->id);
        parent::commit();
        $data = (object) array(
            'artefact' => $this->id,
            'descriptorset' => $this->descriptorset,
            'evaluator' => $this->evaluator,
            'final' => $this->final
        );
        if ($new) {
            insert_record('artefact_epos_evaluation', $data);
            $evaluationitems = array();
            foreach ($this->itemsbycompetencelevel as $competence) {
                foreach ($competence as $level) {
                    $evaluationitems = array_merge($evaluationitems, $level);
                }
            }
            foreach ($evaluationitems as $item) {
                $newitem = (object) array(
                    'evaluation' => $this->id,
                    'descriptor' => $item->descriptor,
                    'value' => $item->value,
                    'goal' => $item->goal
                );
                insert_record('artefact_epos_evaluation_item', $newitem);
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
        delete_records('artefact_epos_evaluation_competencelevel', 'evaluation', $this->id);
        delete_records('artefact_epos_evaluation_request', 'inquirer_evaluation', $this->id);
        delete_records('artefact_epos_evaluation_request', 'evaluator_evaluation', $this->id);
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
        return "$this->title ($this->description)";
    }

    /**
     * Create an evaluation artefact for a user
     * @param $descriptorsetid The descriptorset to use as evaluation in this instance
     * @param $title The title of the evaluation created for this subject
     * @param $description
     * @param $user_id The user to create the subject artefact for, defaults to the current user
     */
    public static function create_evaluation_for_user($descriptorsetid, $title, $user_id = null) {
        if (!isset($user_id)) {
            global $USER;
            $user_id = $USER->get('id');
        }

        $descriptorset = new Descriptorset($descriptorsetid);

        // create evaluation artefact
        $evaluation = new ArtefactTypeEvaluation(0, array(
            'owner' => $user_id,
            'title' => $title,
            'description' => $descriptorset->name,
            'descriptorset' => $descriptorsetid,
            'evaluator' => $user_id
        ));
        $evaluation->commit();

        foreach ($descriptorset->descriptors as $descriptor) {
            $evaluation->add_item($descriptor->id);
        }
        return $evaluation;
    }

    public function add_item($descriptorid, $goal = 0) {
        $item = new stdClass();
        $item->evaluation = $this->id;
        $item->value = 0;
        $item->goal = $goal ? 1 : 0;
        $item->descriptor = $descriptorid;
        return insert_record('artefact_epos_evaluation_item', $item, 'id', true);
    }

    public function add_competencelevel($competence, $level) {
        $complevel = new stdClass();
        $complevel->evaluation = $this->id;
        $complevel->competence = $competence;
        $complevel->level = $level;
        $complevel->value = 0;
        return insert_record('artefact_epos_evaluation_competencelevel', $complevel);
    }

    public function get_descriptorset() {
        return Descriptorset::get_instance($this->descriptorset);
    }

    public function check_permission() {
        global $USER;
        $user = $USER->get('id');
        if ($user !== $this->owner && $user !== $this->evaluator) {
            throw new AccessDeniedException(get_string('youarenottheownerofthisevaluation', 'artefact.epos'));
        }
    }

    public function get_levels() {
        asort($this->levels);
        return $this->levels;
    }

    /**
     * Calculate the results in an array of competences of levels.
     */
    public function get_results() {
        $descriptorset = $this->get_descriptorset();
        $maxrating = count($descriptorset->ratings) - 1;
        $results = array();

        foreach ($this->itemsbycompetencelevel as $competenceid => $levels) {
            // custom competences
            if (array_keys($levels) == array(0)) {
                $complevel = self::get_evaluation_result_for_competencelevel($levels[0], $maxrating);
                $results[$competenceid]['levels'][0] = $complevel;
                $results[$competenceid]['id'] = $competenceid;
                $results[$competenceid]['name'] = $this->competences[$competenceid];
                $results[$competenceid]['custom'] = true;
            }
            // normal descriptors
            else {
                $_levels = $this->levels;
                uksort($levels, function($a, $b) use($_levels) {
                    return strcmp($_levels[$a], $_levels[$b]);
                });
                foreach ($levels as $levelid => $descriptors) {
                    $complevel = self::get_evaluation_result_for_competencelevel($descriptors, $maxrating);
                    // different logic for overall evaluations
                    $key = "$competenceid;$levelid";
                    if (array_key_exists($key, $this->competencelevels)) {
                        $complevel['average'] = round(100 * $this->competencelevels[$key]->value / $maxrating);
                    }
                    $results[$competenceid]['levels'][$levelid] = $complevel;
                }
                $results[$competenceid]['id'] = $competenceid;
                $results[$competenceid]['name'] = $this->competences[$competenceid];
                $results[$competenceid]['custom'] = false;
            }
        }
        // sort: normal competences before custom competences, then ordered by name
        usort($results, function ($a, $b) {
            if ($a['custom'] === $b['custom']) {
                return strcmp($a['name'], $b['name']);
            }
            return $a['custom'] && !$b['custom'] ? 1 : -1;
        });
        return $results;
    }

    private static function get_evaluation_result_for_competencelevel($descriptors, $maxrating) {
        $complevel = array(
            'value' => 0,
            'max' => 0,
            'evaluationsums' => array_fill(0, $maxrating + 1, 0)
        );
        foreach ($descriptors as $descriptor) {
            $complevel['value'] += $descriptor->value;
            $complevel['max'] += $maxrating;
            $complevel['evaluationsums'][$descriptor->value]++;
        }
        $complevel['average'] = round(100 * $complevel['value'] / $complevel['max']);
        return $complevel;
    }

    public function get_goals() {
        $goals = array();
        $callback = function ($item) {
            return $item->goal;
        };
        foreach ($this->itemsbycompetencelevel as $competence) {
            foreach ($competence as $level) {
                $goals = array_merge($goals, array_filter($level, $callback));
            }
        }
        return $goals;
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
     * Render the HTML table for this evaluation.
     * @param string $interactive Whether javascript links should be generated that toggle forms
     * @return string The HTML of the table
     */
    public function render_evaluation_table($interactive = true) {
        $results = $this->get_results();
        $levels = $this->get_levels();

        $columntitles = array_values($levels);
        array_unshift($columntitles, get_string('competencearea', 'artefact.epos'));

        $columndefinitions = array(
            function ($row) {
                $cell = array('content' => $row['name']);
                $cell['properties']['title'] = get_string('standardcompetencearea', 'artefact.epos');
                if ($row['custom']) {
                    $cell['properties']['class'] = "custom";
                    $cell['properties']['title'] = get_string('customcompetencearea', 'artefact.epos');
                }
                return $cell;
            }
        );
        $levelcount = count($levels);
        foreach ($levels as $levelid => $level) {
            $columndefinitions []= function ($row) use ($levelid, $level, $levelcount, $interactive) {
                if ($row['custom']) {
                    $levelid = 0;
                }
                $content = isset($row['levels'][$levelid]) ? html_progressbar($row['levels'][$levelid]['average']) : '';
                $cell = array('content' => $content);
                $classes = array();
                if ($interactive) {
                    $competenceid = $row['id'];
                    if (isset($row['levels'][$levelid])) {
                        $name = $row['name'];
                        $cell['properties'] = array(
                            'onclick' => "toggleEvaluationForm($competenceid, $levelid, '$name', '$level')"
                        );
                    }
                    $classes []= "interactive";
                }
                if ($row['custom']) {
                    $cell['properties']['colspan'] = $levelcount;
                    $cell['break'] = true;
                    $classes []= "custom";
                }
                $cell['properties']['class'] = implode(' ', $classes);
                return $cell;
            };
        }
        $eval_table = new HTMLTable_epos($columntitles, $columndefinitions);
        $eval_table->add_table_classes('evaluation');
        return $eval_table->render($results);
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
        if (count($ratings) === 0) {
            throw new MaharaException("There must be at least one rating option.");
        }
        $elements = array();
        // Add empty header cells so the "Goal?" header is in its place
        $elements['header3'] = $elements['header2'] = $elements['header1'] = array(
            'type' => 'html',
            'title' => '',
            'value' => ''
        );
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
        foreach ($this->customcompetences as $competenceid => $competencename) {
            $elements["item_{$competenceid}_0_overall"] = array(
                'type' => 'hidden',
                'title' => "Overall $competenceid 0",
                'value' => false
            );
            $this->form_evaluation_customdescriptors($elements, $ratings, $competenceid);
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
        $value = 0;
        if (array_key_exists($key, $this->competencelevels)) {
            $value = $this->competencelevels[$key]->value;
            // Override the "is overall evaluation" setting (default: false)
            $elements["item_{$competence->id}_{$level->id}_overall"]['defaultvalue'] = true;
        }
        $index = "item_{$competence->id}_{$level->id}";
        $title = get_string('overallrating', 'artefact.epos') . " $competence->name – $level->name";
        $elements[$index . '_link'] = array(
            'type' => 'html',
            'title' => $title,
            'value' => ''
        );
        $elements[$index] = array(
            'type' => 'radio',
            'title' => $title,
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
        global $THEME;
        $descriptorset = $this->get_descriptorset();
        if (!array_key_exists($competence->id, $this->itemsbycompetencelevel)
            || !array_key_exists($level->id, $this->itemsbycompetencelevel[$competence->id])) {
            return;
        }
        foreach ($this->itemsbycompetencelevel[$competence->id][$level->id] as $item) {
            $title = $item->descriptor_name;
            $index = "item_{$competence->id}_{$level->id}_{$item->descriptor}";
            $elements[$index . '_link'] = array(
                'type' => 'html',
                'title' => $title,
                'value' => ''
            );
            //link
            $imgUrl = $THEME->get_url('images/comment.png');
            if (filter_var($item->link, FILTER_VALIDATE_URL)) {
                $elements[$index . '_link']['value'] = "<a href=\"\" onclick=\"return openPopup('$item->link')\"><img src=\"$imgUrl\" /></a>";
            }
            $elements[$index] = array(
                'type' => 'radio',
                'title' => $title,
                'options' => $ratings,
                'defaultvalue' => $item->value,
            );
            //goal checkbox
            if ($item->goal_available) {
                $elements[$index . '_goal'] = array(
                    'type' => 'checkbox',
                    'title' => $title,
                    'defaultvalue' => $item->goal,
                );
            }
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
    private function form_evaluation_customdescriptors(&$elements, $ratings, $competenceid) {
        global $THEME;
        foreach ($this->itemsbycompetencelevel[$competenceid][0] as $item) {
            $editCustomgoal = get_string('edit');
            $deleteCustomgoal = get_string('delete');
            $editbuttonurl = $THEME->get_url('images/btn_edit.png');
            $deletebuttonurl = $THEME->get_url('images/btn_deleteremove.png');
            $index = "item_{$competenceid}_0_{$item->descriptor}";
            $title = $item->descriptor_name;

            $elements[$index . '_link'] = array(
                'type' => 'html',
                'title' => $title,
                'value' => ''
            );
            $elements[$index] = array(
                    'type' => 'radio',
                    'title' => $title,
                    'options' => $ratings,
                    'defaultvalue' => $item->value,
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
                            <a href="javascript: deleteCustomGoal('$item->descriptor');" title="$deleteCustomgoal">
                                <img src="$deletebuttonurl" alt="$deleteCustomgoal">
                            </a>
                        </div>
EOL
            );
        }
    }

    /**
     * Write changed evaluation items to the database.
     */
    public static function submit_evaluationform(Pieform $form, $values) {
        $data = array();
        $evaluation = new ArtefactTypeEvaluation($values['id']);

        foreach ($values as $key => $value) {
            $parts = explode('_', $key);

            if (preg_match('/^item_[0-9]+_[0-9]+.*$/', $key)) {
                $complevel = "$parts[1];$parts[2]";
                if (!isset($data[$complevel])) {
                    $data[$complevel] = array();
                }
                // e.g. "item_5_6_overall"
                if (preg_match('/^item_[0-9]+_[0-9]+_overall$/', $key)) {
                    $data[$complevel]['overall'] = $value;
                }
                if (preg_match('/^item_[0-9]+_[0-9]+_[0-9]+.*$/', $key)) {
                    $descriptor = $parts[3];
                    if (!isset($data[$complevel]['descriptors'])) {
                        $data[$complevel]['descriptors'] = array();
                        $data[$complevel]['descriptors'][$descriptor] = array();
                    }
                    // e.g. "item_5_6_60"
                    if (preg_match('/^item_[0-9]+_[0-9]+_[0-9]+$/', $key)) {
                        $data[$complevel]['descriptors'][$descriptor]['value'] = intval($value);
                    }
                    // e.g. "item_5_6_60_goal"
                    else if (preg_match('/^item_[0-9]+_[0-9]+_[0-9]+_goal$/', $key)) {
                        $data[$complevel]['descriptors'][$descriptor]['goal'] = $value ? 1 : 0;
                    }
                }
                // e.g. "item_5_6"
                if (preg_match('/^item_[0-9]+_[0-9]+$/', $key)) {
                    $data[$complevel]['value'] = intval($value);
                }
            }
        }

        try {
            db_begin();
            foreach ($data as $complevel => $compleveldata) {
                if (!array_key_exists('overall', $compleveldata)) {
                    continue;
                }
                list($competence, $level) = explode(';', $complevel);
                $isOverall = $compleveldata['overall'];

                if ($isOverall) {
                    $dataobject = new stdClass();
                    $dataobject->evaluation = $evaluation->id;
                    $dataobject->competence = $competence;
                    $dataobject->level = $level;
                    $dataobject->value = $compleveldata['value'];
                    $where = new stdClass();
                    $where->evaluation = $evaluation->id;
                    $where->competence = $competence;
                    $where->level = $level;
                    ensure_record_exists('artefact_epos_evaluation_competencelevel', $where, $dataobject);

                    foreach ($compleveldata['descriptors'] as $descriptorid => $descriptor) {
                        $evaluation->update_evaluation_item($descriptorid, $compleveldata['value']);
                    }
                }
                else {
                    foreach ($compleveldata['descriptors'] as $descriptorid => $descriptor) {
                        if (isset($descriptor['goal'])) {
                            $evaluation->update_evaluation_item($descriptorid, $descriptor['value'], $descriptor['goal']);
                        }
                        else {
                            $evaluation->update_evaluation_item($descriptorid, $descriptor['value']);
                        }
                    }
                    delete_records('artefact_epos_evaluation_competencelevel', 'evaluation', $evaluation->id, 'competence', $competence, 'level', $level);
                }
            }
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

    private function update_evaluation_item($descriptor, $value, $goal = null) {
        $dataobject = new stdClass();
        $dataobject->value = $value;
        if ($goal !== null) {
            $dataobject->goal = $goal;
        }
        $where = new stdClass();
        $where->evaluation = $this->id;
        $where->descriptor = $descriptor;
        update_record('artefact_epos_evaluation_item', $dataobject, $where);
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
        $sql = "SELECT a.id, a.title, a.description
                FROM artefact a
                JOIN artefact_epos_evaluation e ON a.id = e.artefact
                WHERE a.artefacttype = 'evaluation' AND a.owner = ? AND e.final = 0";

        if (!$data = get_records_sql_array($sql, array($owner))) {
            return array(null, false);
        }
        // sort alphabetically by title
        usort($data, function ($a, $b) { return strcoll($a->title, $b->title); });
        // select first language if no selected is given
        $id = $selected ? $selected : $data[0]->id;

        foreach ($data as $evaluation) {
            $evaluation->title = "$evaluation->title ($evaluation->description)";
        }
        //$selectform = get_string('selfevaluations', 'artefact.epos') . ': ';
        $selectform = html_select($data, get_string('select'), "id", $id);
        return array($selectform, $id);
    }

    public static function get_user_evaluations($user_id) {
        $sql = "SELECT a.*, e.*
                FROM artefact a
                RIGHT JOIN artefact_epos_evaluation e ON e.artefact = a.id
                WHERE a.owner = ? AND e.final = 0";
        if (!$result = get_records_sql_array($sql, array($user_id))) {
            throw new ArtefactNotFoundException();
        }
        return $result;
    }

    public function form_store_evaluation() {
        $elements = array();
        $elements['name'] = array(
                'type' => 'text',
                'title' => get_string('evaluationname', 'artefact.epos'),
                'defaultvalue' => $this->title,
                'rules' => array('required' => true)
        );
        $elements['evaluation'] = array(
                'type' => 'hidden',
                'value' => $this->id
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
        $name = trim($values['name']);
        if ($name == '') {
            $form->set_error('name', get_string('rule.required.required', 'pieforms'));
        }
    }

    public static function form_store_evaluation_submit($form, $values) {
        $evaluation = new ArtefactTypeEvaluation($values['evaluation']);
        $storedevaluation = new ArtefactTypeEvaluation(0, $evaluation->copy_data());
        $storedevaluation->set('title', $values['name']);
        $storedevaluation->set('final', 1);
        $storedevaluation->commit();
        redirect(get_config('wwwroot') . 'artefact/epos/evaluation/stored.php');
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
                'goto' => get_config('wwwroot') . 'artefact/epos/evaluation/stored.php'
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
        redirect(get_config('wwwroot') . 'artefact/epos/evaluation/stored.php');
    }

    /**
     * Get all records (not instances) of evaluations, final and current
     * ordered by mtime
     * @return array The records: id, title, mtime, subject (title), evaluator (id), final, firstname, lastname, descriptorset
     */
    public static function get_all_stored_evaluation_records() {
        global $USER;
        // "AND NOT (a.owner != e.evaluator AND e.final = 0)" makes sure open evaluation requests are not shown
        $sql = "SELECT a.*, e.*, usr.firstname, usr.lastname, d.name AS descriptorset
                FROM artefact a
                INNER JOIN artefact_epos_evaluation e ON a.id = e.artefact
                LEFT JOIN artefact_epos_descriptorset d ON e.descriptorset = d.id
                LEFT JOIN usr ON e.evaluator = usr.id
                WHERE a.artefacttype = 'evaluation' AND a.owner = ? AND NOT (a.owner != e.evaluator AND e.final = 0)
                ORDER BY a.title, d.name, e.final, a.mtime DESC";
        $evaluations = get_records_sql_array($sql, array($USER->get('id')));
        if ($evaluations) {
            foreach ($evaluations as $evaluation) {
                $evaluation->mtime = format_date(strtotime($evaluation->mtime));
                $evaluation->evaluator_display_name = isset($evaluation->evaluator) ? "$evaluation->firstname $evaluation->lastname" : $evaluation->authorname;
            }
            return $evaluations;
        }
        return array();
    }

    public function export_json() {
        $customdescriptors = array();

        $items = $this->itemsbycompetencelevel;
        foreach ($items as $competence) {
            foreach ($competence as $levelid => $level) {
                foreach ($level as $item) {
                    if ($levelid == 0) {
                        $cd = new stdClass();
                        $cd->name = $item->descriptor_name;
                        $cd->competence = $item->competence;
                        $customdescriptors[$item->descriptor] = $cd;
                    }
                    unset($item->descriptor_name);
                    unset($item->link);
                    unset($item->goal_available);
                    unset($item->level);
                    unset($item->level_name);
                    unset($item->competence);
                    unset($item->competence_name);
                }
            }
        }

        $authorname = $this->evaluator != $this->owner ? $this->evaluator_display_name : null;

        $data = array(
            'title' => $this->title,
            'description' => $this->description,
            'authorname' => $authorname,
            'final' => $this->final,
            'customdescriptors' => $customdescriptors,
            'customcompetences' => $this->customcompetences,
            'itemsbycompetencelevel' => $items
        );
        return json_encode($data);
    }
}

class CustomCompetence {

    public $id;

    public $name;

    public $customdescriptorids = array();

    public function __construct($id = 0) {
        if ($id && $customcompetence = get_record('artefact_epos_competence', 'id', $id)) {
            $this->id = $id;
            $this->name = $customcompetence->name;
            if ($records = get_records_array('artefact_epos_descriptor', 'competence', $this->id)) {
                $this->customdescriptors = array_map(function ($item) {
                    return $item->id;
                }, $records);
            }
        }
    }

    public function get_customgoals() {
        if (!isset($this->customdescriptors)) {
            $records = get_records_array('artefact', 'parent', $this->id, 'id');
            $this->customdescriptors = array();
            if ($records !== false) {
                foreach ($records as $record) {
                    $this->customdescriptors []= new CustomDescriptor($record->id, $record);
                }
            }
        }
        return $this->customdescriptors;
    }

}

class CustomDescriptor {

    public $id;

    public $name;

    public $competenceid;

    public $evaluationid;

    public function __construct($id = 0) {
        if ($id && $customdescriptor = get_record('artefact_epos_descriptor', 'id', $id)) {
            $this->id = $id;
            $this->name = $customdescriptor->name;
            $this->competenceid = $customdescriptor->competence;

            if ($item = get_record('artefact_epos_evaluation_item', 'descriptor', $id)) {
                $this->evaluationid = $item->evaluation;
            }
        }
    }

    /**
     * Delete this descriptor and also the competence it's in if it becomes empty.
     */
    public function delete() {
        db_begin();
        delete_records('artefact_epos_evaluation_item', 'descriptor', $this->id);
        delete_records('artefact_epos_descriptor', 'id', $this->id);
        if (!get_records_array('artefact_epos_descriptor', 'competence', $this->competenceid)) {
            delete_records('artefact_epos_competence', 'id', $this->competenceid);
        }
        db_commit();
    }

    public function form_add_customgoal($is_goal = false, $jscallback = 'evaluationSaveCallback') {
        $elements = array();
        $elements['customcompetence'] = array(
                'type' => 'text',
                'title' => get_string('competencearea', 'artefact.epos'),
                'defaultvalue' => '',
                'rules' => array('required' => true)
        );
        $elements['customdescriptor'] = array(
                'type' => 'textarea',
                'cols' => '1',
                'rows' => 3,
                'resizable' => false,
                'title' => get_string('customlearninggoal', 'artefact.epos'),
                'defaultvalue' => '',
                'rules' => array('required' => true)
        );
        $elements['evaluation'] = array(
                'type' => 'hidden',
                'value' => $this->evaluationid
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
                'validatecallback' => array('CustomDescriptor', 'form_addcustomgoal_validate'),
                'successcallback' => array('CustomDescriptor', 'form_addcustomgoal_submit'),
                'jssuccesscallback' => $jscallback
        ));
        return $customdescriptorform;
    }

    public static function form_addcustomgoal_validate(Pieform $form, $values) {
        $competencename = trim($values['customcompetence']);
        $descriptorname = trim($values['customdescriptor']);
        if ($competencename == '') {
            $form->set_error('customcompetence', get_string('rule.required.required', 'pieforms'));
        }
        if ($descriptorname == '') {
            $form->set_error('customdescriptor', get_string('rule.required.required', 'pieforms'));
        }
    }

    public static function form_addcustomgoal_submit(Pieform $form, $values) {
        $evaluation = artefact_instance_from_id($values['evaluation']);
        $competencename = trim($values['customcompetence']);

        // check for existing competence with the same name
        foreach ($evaluation->get('competences') as $id => $name) {
            if ($name == $competencename) {
                $existingcompetence = $id;
                break;
            }
        }

        try {
            db_begin();
            if (isset($existingcompetence)) {
                $competenceid = $existingcompetence;
            }
            else {
                $competence = new CustomCompetence();
                $competence->name = $competencename;
                $competenceid = insert_record('artefact_epos_competence', $competence, 'id', true);
            }

            $customdescriptor = new CustomDescriptor();
            $customdescriptor->name = $values['customdescriptor'];
            $customdescriptor->competence = $competenceid;
            $customdescriptor->goal_available = 1;
            $descriptorid = insert_record('artefact_epos_descriptor', $customdescriptor, 'id', true);

            $evaluation->add_item($descriptorid);
            db_commit();
        }
        catch (Exception $e) {
            db_rollback();
            $form->json_reply(PIEFORM_ERR, $e->getMessage());
        }
        $form->json_reply(PIEFORM_OK, get_string('savedevaluation', 'artefact.epos'));
    }

}

class Descriptorset implements ArrayAccess, Iterator {

    public $id;

    public $name;

    public $file;

    public $visible;

    public $active;

    public $descriptors = array();

    public $ratings = array();

    public $levels = array();

    public $competences = array();

    private $descriptors_by_competence_level = array();

    public function __construct($id = 0) {
        global $USER;
        if (!empty($id)) {
            if (!$data = get_record('artefact_epos_descriptorset', 'id', $id)) {
                throw new Exception(get_string('descriptorsetnotfound', 'artefact.epos'));
            }
            foreach ((array)$data as $field => $value) {
                if (property_exists($this, $field)) {
                    $this->{$field} = $value;
                }
            }
            $this->id = (int)$this->id;
            $sql = "SELECT d.*, c.name as competence_name, l.name as level_name
                    FROM artefact_epos_descriptor d
                    LEFT JOIN artefact_epos_competence c ON d.competence = c.id
                    LEFT JOIN artefact_epos_level l ON d.level = l.id
                    WHERE d.descriptorset = ?";
            if ($descriptors = get_records_sql_array($sql, array($this->id))) {
                foreach ($descriptors as $descriptor) {
                    $fields = array('id', 'competence', 'level', 'goal_available');
                    foreach ($fields as $field) {
                        $descriptor->{$field} = (int)$descriptor->{$field};
                    }
                    $this->descriptors[$descriptor->id] = $descriptor;
                    $this->descriptors_by_competence_level[$descriptor->competence][$descriptor->level] []= $descriptor;
                    if (!array_key_exists($descriptor->competence, $this->competences)) {
                        $competence = new stdClass();
                        $competence->id = $descriptor->competence;
                        $competence->name = $descriptor->competence_name;
                        $this->competences[$descriptor->competence] = $competence;
                    }
                    if (!array_key_exists($descriptor->level, $this->levels)) {
                        $level = new stdClass();
                        $level->id = $descriptor->level;
                        $level->name = $descriptor->level_name;
                        $this->levels[$descriptor->level] = $level;
                    }
                }
            }
            if ($ratings = get_records_array('artefact_epos_rating', 'descriptorset', $id, 'id')) {
                foreach ($ratings as $rating) {
                    $this->ratings[$rating->id] = $rating;
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

    public function delete() {
        if (empty($this->id)) {
            return;
        }
        db_begin();
        // TODO: delete competences, ratings and levels
        delete_records('artefact_epos_descriptorset', 'id', $this->id);
        db_commit();
    }

    public function export_json() {
        foreach ($this->descriptors as $descriptor) {
            unset($descriptor->id);
            unset($descriptor->descriptorset);
            unset($descriptor->competence_name);
            unset($descriptor->level_name);
        }
        foreach ($this->ratings as $rating) {
            unset($rating->id);
            unset($rating->descriptorset);
        }
        foreach ($this->competences as $competence) {
            unset($competence->id);
        }
        foreach ($this->levels as $level) {
            unset($level->id);
        }

        $data = array(
            'name' => $this->name,
            'descriptors' => $this->descriptors,
            'ratings' => $this->ratings,
            'competences' => $this->competences,
            'levels' => $this->levels
        );
        return json_encode($data);
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
function write_descriptor_db($xml, $fileistemporary, $subjectid, $descriptorsetid = null) {
    if (file_exists($xml) && is_readable($xml)) {
        $contents = file_get_contents($xml);
        $xmlarr = xmlize($contents);

        $descriptorsettable = 'artefact_epos_descriptorset';
        $descriptortable = 'artefact_epos_descriptor';

        $descriptorset = $xmlarr['DESCRIPTORSET'];
        $values['name'] = $descriptorsetname = $descriptorset['@']['NAME'];
        if(array_key_exists("DESCRIPTION", $descriptorset['@'])){
            $values['description'] = html_entity_decode($descriptorset['@']['DESCRIPTION']);
        }
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


class HTMLTable_epos {

    public $titles;
    public $cols;
    public $id;
    public $data;
    private $even = true;
    public $table_classes = array();
    public $properties = array();

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
