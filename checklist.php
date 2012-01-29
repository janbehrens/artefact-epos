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

$haslanguages = true;
$id = 0;

$owner = $USER->get('id');

//get user's checklists
$sql = "SELECT a.id, a.parent, a.title as descriptorset, b.title
	FROM artefact a, artefact b
	WHERE a.parent = b.id AND a.owner = ? AND a.artefacttype = ?";

if (!$data = get_records_sql_array($sql, array($owner, 'checklist'))) {
    $data = array();
}

// generate language links
if ($data) {
    usort($data, 'cmpByTitle');
    
    // select first language if GET parameter is not set
    if (!isset($_GET['id'])) {
        $id = $data[0]->id;
    }

    $languagelinks = '<p>' . get_string('subjects', 'artefact.epos') . ': ';
    
    foreach ($data as $field) {
        if ($field->id == $id) {
            $languagelinks .= '<b>';
        }
        else {
            $languagelinks .= '<a href="checklist.php?id=' . $field->id . '">';
        }
        $languagelinks .= $field->title . ' (' . get_string('descriptorset.' . $field->descriptorset, 'artefact.epos') . ')';
        if ($field->id == $id) {
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
    $languagelinks = get_string('nolanguageselected1', 'artefact.epos') . '<a href=".">' . get_string('mylanguages', 'artefact.epos') . '</a>' . get_string('nolanguageselected2', 'artefact.epos');
}

$checklistforms = array();
$checklistformsid = array();
$inlinejs = '';

if ($haslanguages) {
    $a = artefact_instance_from_id($id);
    $set = $a->set;
    $checklistitems = $a->load_checklist();
    
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

EOF;
    
    $inlinejs .= $a->returnJS(true);
}

$smarty = smarty(array('tablerenderer',
    				   'jquery',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.core.min.js',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.widget.min.js',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.progressbar.min.js')
);

$smarty->assign('id', $id);
$smarty->assign('languagelinks', $languagelinks);
$smarty->assign('haslanguages', $haslanguages);
$smarty->assign('checklistforms', $checklistforms);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('selfevaluation', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:checklist.tpl');


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
