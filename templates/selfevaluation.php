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
define('INSTITUTIONALSTAFF', 1);
define('MENUITEM', 'templates/selfevaluation');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
define('TITLE', get_string('create_selfevaluation_template', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'epos');

//get institutions
$institutions = get_manageable_institutions($USER);
$institutionexists = false;
$accessdenied = true;

if (isset($_GET['institution'])) {
    $institution = $_GET['institution'];
    
    //check if user is allowed to administer the institution indicated by GET parameter
    foreach ($institutions as $inst) {
        if ($institution == $inst->name) {
            $accessdenied = false;
        }
    }
}
else {
    $institution = $institutions[0];
    $institution = $institution->name;
    $accessdenied = false;
}

$subject = isset($_GET['subject']) ? $_GET['subject'] : 0;
$edit = isset($_GET['edit']) ? $_GET['edit'] : 0;
$links_inst = '';
$links_subj = '';
$institution_displayname = '';

// generate institution list
if ($institutions) {
    // select first institution if GET parameter is not set
    if ($institution == '') {
        $institution = $institutions[0]->name;
    }

    $links_inst = '<p>' . get_string('institution', 'artefact.epos') . ': ';

    foreach ($institutions as $field) {
        if ($field->name == $institution) {
            $links_inst .= '<b>';
            $institutionexists = true;
            $institution_displayname = $field->displayname;
        }
        else {
            $links_inst .= '<a href="?institution=' . $field->name . '">';
        }
        $links_inst .= $field->displayname;
        if ($field->name == $institution) {
            $links_inst .= '</b> | ';
        }
        else {
            $links_inst .= '</a> | ';
        }
    }
}

if (!$institutionexists) {
    //TODO: error
}

//get subjects
$subjects = true;

$sql = "SELECT id, name FROM artefact_epos_subject
        WHERE institution = ? AND active = 1
        ORDER BY name";

if (!$data = get_records_sql_array($sql, array($institution))) {
    $data = array();
    $subjects = false;
}

// generate subject list
if ($data) {
    // select first subject if GET parameter is not set
    if ($subject == '') {
        $subject = $data[0]->id;
    }

    $links_subj = '<p>' . get_string('subject', 'artefact.epos') . ': ';

    foreach ($data as $field) {
        if ($field->id == $subject) {
            $links_subj .= '<b>';
        }
        else {
            $links_subj .= '<a href="?institution=' . $institution . '&subject=' . $field->id . '">';
        }
        $links_subj .= $field->name;
        if ($field->id == $subject) {
            $links_subj .= '</b> | ';
        }
        else {
            $links_subj .= '</a> | ';
        }
    }
}

$text_evaluationlevel	           = get_string('evaluationlevel', 'artefact.epos');
$text_competencyname	           = get_string('competency_name', 'artefact.epos');
$text_competencylevel	           = get_string('competency_level', 'artefact.epos');
$text_cando_statement	           = get_string('cando_statement', 'artefact.epos');
$text_cando_statements	           = get_string('cando_statements', 'artefact.epos');
$text_tasklink			           = get_string('tasklink', 'artefact.epos');
$text_learningobjectivecheckbox    = get_string('learningobjective_checkbox', 'artefact.epos');
$text_fill_in_learning_objectives  = get_string('fill_in_learning_objectives', 'artefact.epos');
$text_combination_of			   = get_string('combination_of', 'artefact.epos');
$text_and			               = get_string('and', 'artefact.epos');

$activatestr = get_string('activate', 'artefact.epos');
$deactivatestr = get_string('deactivate', 'artefact.epos');
$deletestr = get_string('delete', 'mahara');
$editstr = get_string('edit', 'mahara');
$exportstr = get_string('export', 'artefact.epos');
$confirmdelstr1 = get_string('confirmdeletedescriptorset1', 'artefact.epos');
$confirmdelstr2 = get_string('confirmdeletedescriptorset2', 'artefact.epos');


//JS stuff
$inlinejs = <<<EOF

function cancelEditing() {
    window.location.href = '?institution={$institution}&subject={$subject}';
}

function getJsonData() {
    jsonData = { 
		'jsonCompetencyPatternTitle' : JSON.stringify(document.getElementById('competencyPatternTitle').value),
        'arrCompetencyNames'         : JSON.stringify(arrCompetencyName),
		'arrCompetencyLevel'         : JSON.stringify(arrCompetencyLevel),
		'arrCanDo'                   : JSON.stringify(arrCanDo),
		'arrCanDoTaskLink'           : JSON.stringify(arrCanDoTaskLinks),
		'arrCanDoCanBeGoal'          : JSON.stringify(arrCanDoCanBeGoal),
		'arrEvaluationLevelGlobal'   : JSON.stringify(arrEvaluationLevelGlobal),
		'jsonTypeOfEvaluation'       : JSON.stringify(nActEvaluationDegreeId),
    };
    return jsonData;
}

function submitTemplate(id) {
	sendjsonrequest(
	        'addselfevaluation.json.php?subject={$subject}&id=' + id,
            getJsonData(),
            'POST', 
            function() {
                cancelEditing();
            },
            function() {
            	// @todo error
            });
}

var text_evaluationlevel 				= "$text_evaluationlevel";
var text_competencyname 				= "$text_competencyname";
var text_competencylevel 				= "$text_competencylevel";
var text_cando_statement				= "$text_cando_statement";
var text_cando_statements				= "$text_cando_statements";
var text_tasklink						= "$text_tasklink";
var text_canBeGoal						= "$text_learningobjectivecheckbox";
var text_fill_in_learning_objectives	= "$text_fill_in_learning_objectives";
var text_combination_of					= "$text_combination_of";
var text_and							= "$text_and";

EOF;

if (!$edit) {
    $inlinejs .= <<<EOF

function activateDescriptorset(id) {
	sendjsonrequest('activatedescriptorset.json.php?activate=1',
            {'id': id},
            'POST', 
            function() {
            	tableRenderer.doupdate();
            });
}

function deactivateDescriptorset(id) {
	sendjsonrequest('activatedescriptorset.json.php?activate=0',
            {'id': id},
            'POST', 
            function() {
            	tableRenderer.doupdate();
            });
}

function editDescriptorset(id, name) {
    window.location.href = '?institution={$institution}&subject={$subject}&edit=' + id;
    return false;
}

function deleteDescriptorset(id, name) {
    if (confirm('{$confirmdelstr1}"' + name + '"{$confirmdelstr2}?')) {
        sendjsonrequest('deletedescriptorset.json.php',
                {'id': id},
                'POST', 
                function() {
                	tableRenderer.doupdate();
                });
    }
    return false;
}

tableRenderer = new TableRenderer(
    'descriptorsets',
    'selfevaluation.json.php?institution={$institution}&subject={$subject}',
    [
        function (r, d) {
            return TD(null, r.name);
        },
        function (r, d) {
            if (r.active == 1) {
                return TD(null, A({'class': '', 'href': 'javascript: onClick=deactivateDescriptorset(' + r.id + ');'}, '{$deactivatestr}'));
            }
            else {
                return TD(null, A({'class': '', 'href': 'javascript: onClick=activateDescriptorset(' + r.id + ');'}, '{$activatestr}'));
            }
        },
        function (r, d) {
            return TD(null, A({'class': 'icon btn-edit s', 'href': 'javascript: onClick=editDescriptorset(' + r.id + ', "' + r.name + '");'}, '{$editstr}'));
        },
        function (r, d) {
            return TD(null, A({'class': 'icon btn-del s', 'href': 'javascript: onClick=deleteDescriptorset(' + r.id + ', "' + r.name + '");'}, '{$deletestr}'));
        },
        function (r, d) {
            return TD(null, A({'class': '', 'href': 'exportdescriptorset.php?file=' + r.file}, '{$exportstr}'));
        },
    ]
);

tableRenderer.emptycontent = '';
tableRenderer.paginate = false;
tableRenderer.updateOnLoad();

function importformCallback() {
    tableRenderer.doupdate();
}
EOF;
}

$importformxml = pieform(array(
        'name' => 'importxml',
        'plugintype' => 'artefact',
        'pluginname' => 'epos',
        'elements' => array(
                'file' => array(
                        'type' => 'file',
                        'title' => get_string('xmlfile', 'artefact.epos'),
                        'rules' => array('required' => true),
                        'maxfilesize' => 250000,
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => get_string('upload', 'mahara'),
                ),
        ),
        'jsform' => true,
        'jssuccesscallback' => 'importformCallback'
));

$importformcsv = pieform(array(
        'name' => 'importcsv',
        'plugintype' => 'artefact',
        'pluginname' => 'epos',
        'elements' => array(
                'name' => array(
                        'type' => 'text',
                        'title' => get_string('nameofdescriptorset', 'artefact.epos'),
                        'rules' => array('required' => true),
                ),
                'file' => array(
                        'type' => 'file',
                        'title' => get_string('csvfile', 'artefact.epos'),
                        'rules' => array('required' => true),
                        'maxfilesize' => 250000,
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => get_string('upload', 'mahara'),
                ),
        ),
        'jsform' => true,
        'jssuccesscallback' => 'importformCallback'
));

$smarty = smarty(array('tablerenderer',
    				   'jquery',
					   'artefact/epos/js/create_selfevaluation.js')
);

//localization assignment to smarty
$smarty->assign('text_num_evaluation_levels', get_string('num_evaluation_levels', 'artefact.epos'));
$smarty->assign('text_name_evaluation_grid', get_string('name_evaluation_grid', 'artefact.epos'));
$smarty->assign('text_num_rows', get_string('num_rows', 'artefact.epos'));
$smarty->assign('text_num_cols', get_string('num_cols', 'artefact.epos'));

$smarty->assign('accessdenied', $accessdenied);
$smarty->assign('institution', $institution);
$smarty->assign('institution_displayname', $institution_displayname);
$smarty->assign('subjects', $subjects);
$smarty->assign('links_institution', $links_inst);
$smarty->assign('links_subject', $links_subj);
$smarty->assign('importformxml', $importformxml);
$smarty->assign('importformcsv', $importformcsv);
$smarty->assign('edit', $edit);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('create_selfevaluation_template', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:create_selfevaluation.tpl');

function importxml_submit(Pieform $form, $values) {
    global $subject;
    safe_require('artefact', 'file');
    
    try {
        //import to database
        $new_descriptorset = write_descriptor_db($values['file']['tmp_name'], true, $subject);
        
        //save file
        $dataroot = realpath(get_config('dataroot'));
        $dirpath = "$dataroot/artefact/epos/descriptorsets";
        $basename = str_replace('/', '_', $new_descriptorset['name']);
        $basefilepath = $dirpath . '/' . $basename;
        
        while (file_exists($basefilepath . '.xml')) {
            $basename .= '_1';
            $basefilepath .= '_1';
        }
        
        move_uploaded_file($values['file']['tmp_name'], $basefilepath . '.xml');
        
        //fix file name in database entry
        update_record(
                'artefact_epos_descriptor_set',
                array('file' => $basename . '.xml'),
                array('id' => $new_descriptorset['id'])
        );
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('importeddescriptorset', 'artefact.epos'));
}

function importcsv_submit(Pieform $form, $values) {
    global $subject;
    
    //prepare saving as file
    $dataroot = realpath(get_config('dataroot'));
    $dirpath = $dataroot . '/artefact/epos/descriptorsets';
    
    if (!is_dir($dirpath)) {
        mkdir($dirpath, 0700, true);
    }
    
    $descriptorsetfilename = $values['name'];
    $descriptorsetfilename = str_replace('/', '_', $descriptorsetfilename);
    $basename = $dirpath . '/' . $descriptorsetfilename;
    
    while (file_exists($basename . '.xml')) {
        $basename .= '_1';
    }
    
    $path = $basename . '.xml';
    
    //intitialize XMLWriter
    $writer = new XMLWriter();
    
    $writer->openURI($path);
    
    $writer->startDocument();
    $writer->setIndent(4);
    
    $writer->startElement('DESCRIPTORSET');
    $writer->writeAttribute('NAME', $values['name']);
    
    try {
        //set error handler in order to catch warnings from XMLWriter
        set_error_handler('errorHandler');
        
        //parse CSV
        $lines = file($values['file']['tmp_name']);
        $line_no = 1;
        
        $values = str_getcsv_utf8($lines[0]);
        
        for ($i = 0; $i < count($values); $i++) {
            $values[$i] = strtolower($values[$i]);
        }
        if ($values !== array("competence", "level", "evaluations", "goal", "name", "link")) {
            throw new Exception(get_string('csvinvalid', 'artefact.epos') . ": line 1");
        }
        unset($lines[0]);
        
        foreach ($lines as $line)
        {
            $values = str_getcsv_utf8($line);
            $line_no++;
            
			$writer->startElement("DESCRIPTOR");
			$writer->writeAttribute('COMPETENCE', $values[0]);
			$writer->writeAttribute('LEVEL', $values[1]);
			$writer->writeAttribute('EVALUATIONS', $values[2]);
			$writer->writeAttribute('GOAL', $values[3]);
			$writer->writeAttribute('NAME', $values[4]);
			$writer->writeAttribute('LINK', $values[5]);
			$writer->endElement();
        }
        $writer->endElement();
        $writer->endDocument();
        $writer->flush();
        
        //import to database
        $new_descriptorset = write_descriptor_db($path, false, $subject);
        
        restore_error_handler();
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, get_string('csvinvalid', 'artefact.epos') . ": line $line_no");
    }
    $form->json_reply(PIEFORM_OK, get_string('importeddescriptorset', 'artefact.epos'));
}

function str_getcsv_utf8($str) {
    //remove BOM
    if (substr($str, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
        $str = substr($str, 3);
    }
    //convert to UTF-8 if necessary
    if (mb_detect_encoding($str, 'UTF-8', true) === FALSE) {
        $str = utf8_encode($str);
    }
    return str_getcsv($str);
}

function errorHandler($errno, $errstr, $errfile, $errline) {
    throw new Exception($errstr, $errno);
}

?>
