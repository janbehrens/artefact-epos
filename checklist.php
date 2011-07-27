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
 * @author     Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 Jan Behrens, jb3@informatik.uni-bremen.de
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'selfevaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'selfevaluation');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');
safe_require('artefact', 'epos');

// load language data
$haslanguages = true;

$owner = $USER->get('id');

//get user's checklists
$sql = 'SELECT c.*, a.title
    FROM {artefact} a 
    JOIN {artefact_epos_checklist} c ON c.learnedlanguage = a.id
    WHERE a.owner = ?';

if (!$data = get_records_sql_array($sql, array($owner))) {
    $data = array();
}

// generate language links
if ($data) {
    usort($data, 'cmp');
    
    // select first language if GET parameter is not set
    if (!isset($_GET['id'])) {
        $_GET['id'] = $data[0]->id;
    }

    $languagelinks = '<p>' . get_string('subjects', 'artefact.epos') . ': ';
    
    foreach ($data as $field) {
        if ($field->id == $_GET['id']) {
            $languagelinks .= '<b>';
        }
        else {
            $languagelinks .= '<a href="checklist.php?id=' . $field->id . '">';
        }
        $languagelinks .= get_string('language.' . $field->title, 'artefact.epos') . ' (' . get_string('descriptorset.' . $field->descriptorset, 'artefact.epos') . ')';
        if ($field->id == $_GET['id']) {
            $languagelinks .= '</b> | ';
        }
        else {
            $languagelinks .= '</a> | ';
        }
    }
    $languagelinks .= '<a href="index.php">' . get_string('edit', 'artefact.epos') . '</a></p>';
}
else {
    $haslanguages = false;
    $languagelinks = get_string('nolanguageselected1', 'artefact.epos') . '<a href="index.php">' . get_string('epossettings', 'artefact.epos') . ' </a>' . get_string('nolanguageselected2', 'artefact.epos');
}


$id = $_GET['id'];

$set = load_descriptorset();
//print_r($set);
//echo '<br/>';
$checklistitems = load_checklist();
//print_r($checklistitems);

$addstr = get_string('add', 'artefact.epos');
$cancelstr = get_string('cancel', 'artefact.epos');
$delstr = get_string('del', 'artefact.epos');
$editstr = get_string('edit', 'artefact.epos');
$confirmdelstr = get_string('confirmdel', 'artefact.epos');

$checklistforms = array();
$checklistformsid = array();

/*
 * build form elements
 * 
 * for each competence/level combination there will be a form with
 * $elements:
 * 	array(
 * 		'header',
 * 		'header_goal',
 * 		'cercles_li_a1_1',
 * 		'cercles_li_a1_2',
 * 		etc.,
 * 		'competence',
 * 		'level',
 * 		'submit'
 * 	)
 */
foreach (array_keys($set) as $competence) {
    foreach (array_keys($set[$competence]) as $level) {
        $elements = array();
        //headings
        $title = get_string($competence, 'artefact.epos') . ' ' . get_string($level, 'artefact.epos');
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
        foreach ($set[$competence][$level] as $name) {
            //evaluation
            $elements[$name] = array(
                'type' => 'radio',
                'title' => get_string($name, 'artefact.epos'),
                'options' => array(
                    0 => get_string('eval0', 'artefact.epos'),
                    1 => get_string('eval1', 'artefact.epos'),
                    2 => get_string('eval2', 'artefact.epos'),
                ),
                'defaultvalue' => $checklistitems['evaluation'][$name],
            );
            //goal
            $elements[$name . '_goal'] = array(
                'type' => 'checkbox',
                'title' => get_string($name, 'artefact.epos'),
                'defaultvalue' => $checklistitems['goal'][$name],
            );
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
    
        $checklistform = pieform(array(
            'name'            => 'checklistform_' . $competence . '_' . $level,
            'plugintype'      => 'artefact',
            'pluginname'      => 'epos',
            'jsform'          => true,
            'renderer'        => 'multicolumntable',
            'elements'        => $elements,
            'elementclasses'  => true,
            'successcallback' => 'form_submit',
            'jssuccesscallback' => 'checklistSaveCallback',
        ));
        
        // $checklistforms is an associative array that contains all forms
        // $checklistformsid contains their codes (like 'cercles_li_a1_1')
        $checklistforms[$competence][$level]['competence'] = $competence;
        $checklistforms[$competence][$level]['form'] = $checklistform;
        $checklistforms[$competence][$level]['name'] = 'checklistform_' . $competence . '_' . $level;
        $checklistformsid[] = $checklistforms[$competence][$level]['name'];
    }
}

//JS stuff
$inlinejs = <<<EOF

jQuery.noConflict();

var divs = ["
EOF;

$inlinejs .= implode('_div", "', $checklistformsid);

$inlinejs .= <<<EOF
_div"];

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
    tableRenderer.doupdate();
}

var prevValue = {};

tableRenderer = new TableRenderer(
    'checklist',
    'checklist.json.php?id={$id}',
    [
        function (r, d) {
            return TD(null, r.competencestr);
        },
EOF;

foreach (array_keys($set) as $competence) {
    foreach (array_keys($set[$competence]) as $level) {
        $inlinejs .= <<<EOF

        function (r) {
            var str1 = 'toggleLanguageForm("' + r.competence + '", "$level")';
            var str2 = 'progressbar_' + r.competence + "_$level";
            var str3 = '#progressbar_' + r.previous + "_$level";
            var data = TD({'onclick': str1});
            data.innerHTML = '<div id="' + str2 + '"></div>';
        	if (prevValue.hasOwnProperty("$level")) {
                jQuery(str3).progressbar({ value: prevValue["$level"] });
            }
            prevValue["$level"] = r.$level;
            
//            if (typeof(r.competence) == 'string') {
                return data;
//            }
    },
EOF;

    }
    break;  //we need the column definitions only once
}

$inlinejs .= <<<EOF

    ]
);

tableRenderer.type = 'checklist';
tableRenderer.statevars.push('type');
tableRenderer.emptycontent = '';
tableRenderer.updateOnLoad();

EOF;


$smarty = smarty(array('tablerenderer', 
					   'artefact/epos/js/jquery/jquery-1.4.4.js',
                       'artefact/epos/js/jquery/ui/jquery.ui.core.js',
                       'artefact/epos/js/jquery/ui/jquery.ui.widget.js',
                       'artefact/epos/js/jquery/ui/jquery.ui.progressbar.js'),
                 //this is bad
                 array('<link rel="stylesheet" href="js/jquery/themes/base/jquery.ui.all.css">')
);

$smarty->assign('languagelinks', $languagelinks);
$smarty->assign('haslanguages', $haslanguages);
$smarty->assign('checklistforms', $checklistforms);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('selfevaluation', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:checklist.tpl');


/**
 * load_descriptorset()
 * 
 * will return something like
 * 	array(
 * 		'listening' => array(
 * 			'a1' => array(
 * 				0 => 'cercles_li_a1_1',
 * 				1 => 'cercles_li_a1_2',
 * 				etc.
 * 			),
 * 			'a2' => array(
 * 				...
 * 			),
 * 			etc.
 * 		),
 * 		'reading' => array(
 * 			...
 * 		),
 * 		etc.
 * 	)
 */
function load_descriptorset() {
    global $id;
    
    $sql = 'SELECT d.*
        FROM {artefact_epos_descriptor} d
        JOIN {artefact_epos_checklist} c ON c.descriptorset = d.descriptorset
        WHERE c.id = ?';
    
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
        $competences[$desc->competence][$desc->level][] = $desc->name;
    }
    return $competences;
}

/**
 * load_checklist()
 * 
 * will return something like
 * 	array(
 * 		'evaluation' => array(
 * 			'cercles_li_a1_1' => 0,
 * 			'cercles_li_a1_2' => 2,
 * 			etc.
 * 		),
 * 		'goal' => array(
 * 			'cercles_li_a1_1' => 0,
 * 			'cercles_li_a1_2' => 1,
 * 			etc.
 * 		)
 * 	)
 */
function load_checklist() {
    global $id;
    
    $sql = 'SELECT ci.*
        FROM {artefact_epos_checklist} c
        JOIN {artefact_epos_checklist_item} ci ON ci.checklist = c.id
        WHERE c.id = ?';
    
    if (!$data = get_records_sql_array($sql, array($id))) {
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
 * form submit function
 */
function form_submit(Pieform $form, $values) {
    try {
        process_checklistform($form, $values);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('savedchecklist', 'artefact.epos'));
}

/**
 * This writes changed checklist items to the database.
 */
function process_checklistform(Pieform $form, $values) {
    global $id, $set, $checklistforms;

    $table = 'artefact_epos_checklist_item';
    
    $values['checklist'] = $id;
    
    //hidden fields
    $competence = $values['competence'];
    $level = $values['level'];
    
    $elements = $form->get_elements();
    
    //identify changed fields and write them to database
    foreach ($set[$competence][$level] as $desc) {
        foreach ($elements as $element) {
            if ($element['name'] == $desc) {
                foreach ($elements as $elementgoal) {
                    if ($elementgoal['name'] == $desc . '_goal') {
                        $values['descriptor'] = $desc;
                        $values['evaluation'] = $values[$desc];
                        $values['goal'] = $values[$desc . '_goal'] == 1 ? 1 : 0;
                        
                        if ($values['evaluation'] != $element['defaultvalue']
                            || $values['goal'] != $elementgoal['defaultvalue']) {
                            update_record($table, (object)$values, array('checklist', 'descriptor'));
                        }
                    }
                }
            }
        }
    }
}

?>
