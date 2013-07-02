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

/**
 * PluginArtefactEpos implementing PluginArtefact
 */
class PluginArtefactEpos extends PluginArtefact {

    public static function get_artefact_types() {
        return array('subject', 'checklist', 'customgoal');
    }

    public static function get_block_types() {
        return array('checklist', 'goals');
    }

    public static function get_plugin_name() {
        return 'epos';
    }

    public static function menu_items() {
        return array(
            array(
                'path' => 'subjects',
                'title' => get_string('languages', 'artefact.epos'),
                'url' => 'artefact/epos/',
                'weight' => 30,
            ),
            array(
                'path' => 'selfevaluation',
                'title' => get_string('selfevaluation', 'artefact.epos'),
                'url' => 'artefact/epos/checklist.php',
                'weight' => 31,
            ),
            array(
                'path' => 'goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 32,
            ),
            array(
                'path' => 'goals/goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 28,
            ),
        );
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
        delete_records('artefact_epos_artefact_subject', 'artefact', $this->id);

        parent::delete();
    }
}

/**
 * ArtefactTypeChecklist implementing ArtefactType
 */
class ArtefactTypeChecklist extends ArtefactType {

    public $set;

    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);
    }

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    public function check_permission() {
        global $USER;
        if ($USER->get('id') != $this->owner) {
            throw new AccessDeniedException(get_string('youarenottheownerofthischecklist', 'artefact.epos'));
        }
    }

    public function render_self($options, $blockid = 0) {
        $this->add_to_render_path($options);
        $this->set = $this->load_descriptorset();

        $inlinejs = $this->returnJS(false, $blockid);

        //if this is used in a block, we use the block instance id, artefact id otherwise
        if($blockid == 0) $blockid = $this->id;

        $smarty = smarty_core();

        $smarty->assign('id', $blockid);
        $smarty->assign('levels', $this->set);
        $smarty->assign('JAVASCRIPT', $inlinejs);

        return array('html' => $smarty->fetch('artefact:epos:viewchecklist.tpl'), 'javascript' => '');
    }

    /**
     * This function builds the artefact title from language and checklist information
     * @see ArtefactType::display_title()
     */
    public function display_title() {
        $language = get_field('artefact', 'title', 'id', $this->parent);
        return $language . ' (' . $this->title . ')';
    }

    /**
     * Returns the JS used to build the checklist table
     * @param unknown_type $editable	whether this is used in the checklist page (editing support) or in a view
     * @param unknown_type $blockid
     * @return string
     */
    public function returnJS($editable, $blockid = 0) {
        $jsonpath = get_config('wwwroot') . 'artefact/epos/checklist.json.php?id=' . $this->id;

        //if this is used in a block, we use the block instance id, artefact id otherwise
        if($blockid == 0) $blockid = $this->id;

        $inlinejs = '
(function($){$.fn.checklist=function(){

var prevValue = {};';

        if(isset($blockid)) {
            $inlinejs .= <<<EOF

tableRenderer{$blockid} = new TableRenderer(
    'checklist{$blockid}',
EOF;
        }
        else {
            $inlinejs .= <<<EOF

tableRenderer{$this->id} = new TableRenderer(
    'checklist{$this->id}',
EOF;
        }

        $inlinejs .= <<<EOF

    '{$jsonpath}',
    [
        function (r, d) {
            return TD(null, r.competence);
        },
EOF;

        foreach (array_keys($this->set) as $competence) {
            $count = 0;
            foreach (array_keys($this->set[$competence]) as $level) {
            //for ($level = 0; $level < count($this->set[$competence]); $level++) {
                $inlinejs .= <<<EOF

        function (r) {
EOF;
                if ($editable) {
                    $inlinejs .= <<<EOF

            var str1 = 'toggleLanguageForm("' + r.index + '", "$count")';
EOF;
                }
                else {
                    $inlinejs .= <<<EOF

            var str1 = '';
EOF;
                }

                $inlinejs .= <<<EOF

            var str2 = 'progressbar_$blockid' + '_' + r.index + "_$count";
            var str3 = '#progressbar_$blockid' + '_' + r.previous + "_$count";
            var data = TD({'onclick': str1});
            data.innerHTML = '<div id="' + str2 + '"></div>';
            if (prevValue.hasOwnProperty('$level')) {
                $(str3).progressbar({ value: prevValue['$level'] });
            }
            if ('$level' in r) {
                prevValue['$level'] = r['$level']['val'];
            }
            return data;
        },
EOF;
                $count++;
            }
            break;  //we need the column definitions only once
        }

        $inlinejs .= <<<EOF
    ]
);

tableRenderer{$blockid}.emptycontent = '';
tableRenderer{$blockid}.updateOnLoad();

$('#checklistnotvisible{$blockid}').addClass('hidden');};

$().checklist();})(jQuery);

EOF;
        return $inlinejs;
    }


    /**
     * Get the forms and JS necessary to display the self-evaluation.
     * @param array $alterform An array containing elements that should override
     * the values of the generated forms.
     * @return array ($forms, $inlinejs)
     */
    public function get_evaluation($alterform = array()) {
        $checklistforms = array();
        $checklistformsid = array();
        $inlinejs = '';
        $set = $this->load_descriptorset();
        $descriptorsetfile = substr($set['file'], 0, count($set['file']) - 5);
        $set = $this->set = $set['competences'];
        $checklistitems = $this->load_checklist();
        $id = $this->id;

        $addstr = get_string('add', 'artefact.epos');
        $cancelstr = get_string('cancel', 'artefact.epos');
        $delstr = get_string('del', 'artefact.epos');
        $editstr = get_string('edit', 'artefact.epos');
        $confirmdelstr = get_string('confirmdel', 'artefact.epos');

        /*
         * build form elements
         *
         * for each competence/level combination there will be a form with
         * $elements:
         *  array(
         *      'header',
         *      'header_goal',
         *      'item33',
         *      'item33_goal',
         *      'item34',
         *      'item34_goal',
         *      etc.,
         *      'competence',
         *      'level',
         *      'submit'
         *  )
         */
        $ccount = 0;
        $lcount = 0;
        foreach (array_keys($set) as $competence) {
            foreach (array_keys($set[$competence]) as $level) {
                $elements = array();
                //headings
                $title = $competence . ' ' . $level;
                $elements['header'] = array(
                    'type' => 'html',
                    'title' => ' ',
                    'value' => '',
                );
                $elements['header_goal'] = array(
                    'type' => 'html',
                    'title' => ' ',
                    'value' => get_string('goal', 'artefact.epos') . '?',
                );
                foreach (array_keys($set[$competence][$level]) as $k) {
                    //evaluation
                    $optionsarray = array();
                    $evals = explode(';', $set[$competence][$level][$k]['evaluations']);
                    for ($j = 0; $j < count($evals); $j++) {
                        $optionsarray[$j] = $evals[$j];
                    }
                    $elements['item' . $k] = array(
                        'type' => 'radio',
                        'title' => $set[$competence][$level][$k]['name'],
                        'options' => $optionsarray,
                        'defaultvalue' => $checklistitems['evaluation'][$k],
                    );
                    //goal checkbox
                    $goal_count = 0;
                    if ($set[$competence][$level][$k]['goal'] == 1) {
                        $elements['item' . $k . '_goal'] = array(
                            'type' => 'checkbox',
                            'title' => $set[$competence][$level][$k]['name'],
                            'defaultvalue' => $checklistitems['goal'][$k],
                        );
                        $goal_count++;
                    }
                    //link
                    if ($set[$competence][$level][$k]['link'] != '') {
                        //check if http(s):// is present in link
                        if (substr($set[$competence][$level][$k]['link'], 0, 7) != "http://" && substr($set[$competence][$level][$k]['link'], 0, 8) != "https://") {
                            $set[$competence][$level][$k]['link'] = "example.php?d=" . $descriptorsetfile . "&l=" . $set[$competence][$level][$k]['link'];
                        }
                        $elements['item' . $k]['title'] .= ' <a href="' . $set[$competence][$level][$k]['link'] . '"  onclick="openPopup(\'' . $set[$competence][$level][$k]['link'] . '\'); return false;">(' . get_string('exampletask', 'artefact.epos') . ')</a>';
                        if ($set[$competence][$level][$k]['goal'] == 1) {
                            $elements['item' . $k . '_goal']['title'] = $elements['item' . $k]['title'];
                        }
                    }
                }
                if ($goal_count == 0) {
                    unset($elements['header_goal']);
                }
                $elements['competence'] = array(
                    'type'  => 'hidden',
                    'value' => $competence,
                );
                $elements['level'] = array(
                    'type'  => 'hidden',
                    'value' => $level,
                );
                $elements['submit'] = array(
                    'type'  => 'submit',
                    'title' => '',
                    'value' => get_string('save', 'artefact.epos'),
                );

                $checklistform = array(
                    'name'            => 'checklistform_' . $ccount . '_' . $lcount,
                    'plugintype'      => 'artefact',
                    'pluginname'      => 'epos',
                    'jsform'          => true,
                    'renderer'        => 'multicolumntable',
                    'elements'        => $elements,
                    'elementclasses'  => true,
                    'successcallback' => array('ArtefactTypeChecklist','submit_checklistform'),
                    'jssuccesscallback' => 'checklistSaveCallback',
                );
                foreach ($alterform as $key => $value) {
                    $checklistform[$key] = $value;
                }
                $checklistform = pieform($checklistform);

                // $checklistforms is an associative array that contains all forms
                // $checklistformsid contains their codes (like 'cercles_li_a1_1')
                $checklistforms[$competence][$level]['competence'] = $competence;
                $checklistforms[$competence][$level]['form'] = $checklistform;
                $checklistforms[$competence][$level]['name'] = 'checklistform_' . $ccount . '_' . $lcount;
                $checklistformsid[] = $checklistforms[$competence][$level]['name'];

                $lcount++;
            }
            $lcount = 0;
            $ccount++;
        }

        //JS stuff
        $inlinejs .= <<<EOF
    divs = ["
EOF;

        $inlinejs .= implode('_div", "', $checklistformsid);
        $inlinejs .= '_div"];';
        $inlinejs .= <<<EOF

    function toggleLanguageForm(comp, level) {
        var elemName = 'checklistform_' + comp + '_' + level + '_div';
        for(var i = 0; i < divs.length; i++) {
            addElementClass(divs[i], 'hidden');
        }
        if (hasElementClass(elemName, 'hidden')) {
            removeElementClass(elemName, 'hidden');
        }
    }

    function checklistSaveCallback(form, data) {
        tableRenderer{$id}.doupdate();
    }

    function openPopup(url) {
        jQuery('<div id="example_popup"></div>').modal({overlayClose:true, closeHTML:''});
        jQuery('<iframe src="' + url + '">').appendTo('#example_popup');
    }

EOF;

        $inlinejs .= $this->returnJS(true);
        return array($checklistforms, $inlinejs);
    }


    /**
     * Get the forms and JS necessary to display the self-evaluation.
     * @param array $alterform An array containing elements that should override
     * the values of the generated forms.
     * @return array ($forms, $inlinejs)
     */
    public function render_evaluation($alterform = array()) {
        list($checklistforms, $inlinejs) = $this->get_evaluation($alterform);
        $smarty = smarty();
        $smarty->assign('id', $this->get('id'));
        $smarty->assign('checklistforms', $checklistforms);
        $includejs = array('tablerenderer',
                       'jquery',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.core.min.js',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.widget.min.js',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.progressbar.min.js',
                       'artefact/epos/js/jquery/jquery.simplemodal.1.4.4.min.js'
        );
        return array(
            'html' => $smarty->fetch('artefact:epos:evaluation.tpl'),
            'inlinejs' => $inlinejs,
            'includejs' => $includejs
        );
    }

    /**
     * This writes changed checklist items to the database.
     */
    public function submit_checklistform(Pieform $form, $values) {
        try {
            global $id, $set, $checklistforms;
            $table = 'artefact_epos_checklist_item';
            $values['checklist'] = $id;

            //hidden fields
            $competence = $values['competence'];
            $level = $values['level'];
            $elements = $form->get_elements();

            //write fields to database
            foreach ($elements as $element) {
                if (substr($element['name'], 0, 4) == 'item') {
                    $k = explode('_', $element['name']);
                    $k = $k[0];
                    $k = substr($k, 4);
                    $values['descriptor'] = $k;

                    if ($element['name'] == 'item' . $k . '_goal') {
                        $values['goal'] = $values['item' . $k . '_goal'] == 1 ? 1 : 0;
                    }
                    else {
                        unset($values['goal']);
                        $values['evaluation'] = $values['item' . $k];
                    }
                    update_record($table, (object)$values, array('checklist', 'descriptor'));
                }
            }
        }
        catch (Exception $e) {
            $form->json_reply(PIEFORM_ERR, $e->getMessage());
        }
        $form->json_reply(PIEFORM_OK, get_string('savedchecklist', 'artefact.epos'));
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
    function load_descriptorset() {
        $sql = 'SELECT DISTINCT d.*, s.file
            FROM artefact_epos_descriptor_set s
            JOIN artefact_epos_descriptor d ON s.id = d.descriptorset
            JOIN artefact_epos_checklist_item i ON d.id = i.descriptor
            JOIN artefact a ON a.id = i.checklist
            WHERE a.id = ?
            ORDER BY d.level, d.competence';

        if (!$descriptors = get_records_sql_array($sql, array($this->id))) {
            $descriptors = array();
        }

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
                    'evaluations' => $desc->evaluations,
                    'goal' => $desc->goal_available,
                    'link' => $desc->link
            );
        }
        return array(
                'competences' => $competences,
                'file' => $descriptors[0]->file
                );
    }

    /**
     * load_checklist()
     *
     * will return something like
     *     array(
     *         'evaluation' => array(
     *             33 => 0,
     *             34 => 2,
     *             etc.
     *         ),
     *         'goal' => array(
     *             33 => 0,
     *             34 => 1,
     *             etc.
     *         )
     *     )
     */
    function load_checklist() {
        $sql = 'SELECT *
            FROM artefact_epos_checklist_item
            WHERE checklist = ?';

        if (!$data = get_records_sql_array($sql, array($this->id))) {
            $data = array();
        }

        $evaluation = array();
        $goal = array();

        foreach ($data as $field) {
            $evaluation[$field->descriptor] = $field->evaluation;
            $goal[$field->descriptor] = $field->goal;
        }

        return array('evaluation' => $evaluation, 'goal' => $goal);
    }

    /**
     * Overriding the delete() function to clear the checklist table
     */
    public function delete() {
        delete_records('artefact_epos_checklist_item', 'checklist', $this->id);

        parent::delete();
    }
}

/**
* ArtefactTypeCustomGoal implementing ArtefactType
*/
class ArtefactTypeCustomGoal extends ArtefactType {

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}
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
    $sql = 'SELECT * FROM artefact_epos_descriptor
        WHERE descriptorset = ?
        ORDER BY level, competence, id';

    if (!$descriptors = get_records_sql_array($sql, array($id))) {
        $descriptors = array();
    }

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
                'evaluations' => $desc->evaluations,
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

        $descriptorsettable = 'artefact_epos_descriptor_set';
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

        foreach ($xmlarr['DESCRIPTORSET']['#']['DESCRIPTOR'] as $x) {
            $values['competence'] = $x['@']['COMPETENCE'];
            $values['level']      = $x['@']['LEVEL'];
            $values['name']       = $x['@']['NAME'];
            $values['link']       = $x['@']['LINK'];
            $values['evaluations'] = $x['@']['EVALUATIONS'];
            $values['goal_available'] = $x['@']['GOAL'];

            insert_record($descriptortable, (object)$values);
        }
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
 * Create a subject artefact for a user with a checklist assigned
 * @param $subject_id The subject the user chooses to partake in
 * @param $subject_title The title the user assigns to that subject's instance
 * @param $descriptorset_id The descriptorset to use as checklist in this instance
 * @param $checklist_title The title of the checklist created for this subject
 * @param $user_id The user to create the subject artefact for, defaults to the current user
 */
function create_subject_for_user($subject_id, $subject_title, $descriptorset_id, $checklist_title, $user_id=null) {
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
        //insert: artefact_epos_artefact_subject
        $values_artefact_subject = array('artefact' => $id, 'subject' => $subject_id);
        insert_record('artefact_epos_artefact_subject', (object)$values_artefact_subject);
    }

    /*
    // if there is already a checklist with the given title, don't create another one
    $sql = 'SELECT * FROM artefact WHERE parent = ? AND title = ?';
    if (get_records_sql_array($sql, array($id, $checklist_title))) {
        return;
    }
    */
    create_checklist_for_user($descriptorset_id, $checklist_title, $id, $user_id);
}


/**
 * Create a checlist artefact for a user
 * @param $descriptorset_id The descriptorset to use as checklist in this instance
 * @param $checklist_title The title of the checklist created for this subject
 * @param $parent The parent item (e.g. subject)
 * @param $user_id The user to create the subject artefact for, defaults to the current user
 */
function create_checklist_for_user($descriptorset_id, $checklist_title, $parent, $user_id=null) {
    if (!isset($user_id)) {
        global $USER;
        $user_id = $USER->get('id');
    }

    // create checklist artefact
    $checklist = new ArtefactTypeChecklist(0, array(
        'owner' => $user_id,
        'title' => $checklist_title,
        'parent' => $parent
    ));
    $checklist->commit();

    // load descriptors
    $descriptors = array();
    $sql = 'SELECT d.id, d.goal_available FROM artefact_epos_descriptor d
            JOIN artefact_epos_descriptor_set s ON s.id = d.descriptorset
            WHERE s.id = ?';
    if (!$descriptors = get_records_sql_array($sql, array($descriptorset_id))) {
        $descriptors = array();
    }

    // update artefact_epos_checklist_item
    $checklist_item = array('checklist' => $checklist->get('id'), 'evaluation' => 0);
    foreach ($descriptors as $descriptor) {
        $checklist_item['descriptor'] = $descriptor->id;
        if ($descriptor->goal_available == 1) {
            $checklist_item['goal'] = 0;
        }
        else {
            unset($checklist_item['goal']);
        }
        insert_record('artefact_epos_checklist_item', (object)$checklist_item);
    }
}

// comparison functions for sql records
function cmpByTitle($a, $b) {
    return strcoll($a->title, $b->title);
}

function cmpByCompetenceAndLevel($a, $b) {
    $cmp = strcoll($a->competence, $b->competence);
    return $cmp == 0 ? strcoll($a->level, $b->level) : $cmp;
}

function cmpByLevel($a, $b) {
    return ;
}
