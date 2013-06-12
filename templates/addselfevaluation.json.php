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
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'epos');

$subject = isset($_GET['subject']) ? $_GET['subject'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$competencyPatternTitle				= json_decode(param_variable('jsonCompetencyPatternTitle'));
$arrCompetencyName 					= json_decode(param_variable('arrCompetencyName'));
$arrCompetencyLevel 				= json_decode(param_variable('arrCompetencyLevel'));
$arrCanDo							= json_decode(param_variable('arrCanDo'));
$arrCanDoTaskLink					= json_decode(param_variable('arrCanDoTaskLink'));
$arrCanDoCanBeGoal					= json_decode(param_variable('arrCanDoCanBeGoal'));
$arrEvaluationLevelGlobal			= json_decode(param_variable('arrEvaluationLevelGlobal'));
$arrEvaluationsString               = "";

//prepare saving as file
$dataroot = realpath(get_config('dataroot'));
$dirpath = $dataroot . '/artefact/epos/descriptorsets';
$dirpath_examples = $dataroot . '/artefact/epos/examples';

if (!is_dir($dirpath)) {
    mkdir($dirpath, 0700, true);
}
if (count($arrCanDoTaskLink) > 0 && !is_dir($dirpath_examples)) {
    mkdir($dirpath_examples, 0700, true);
}

$basename = str_replace('/', '_', $competencyPatternTitle);
$filepath = $dirpath . '/' . $basename . '.xml';
$filepath_examples = $dirpath_examples . '/' . $basename;

//prevent from overwriting
$increment = 1;
while (file_exists($filepath)) {
    $filepath = $dirpath . '/' . $basename . '_' . $increment . '.xml';
    $filepath_examples = $dirpath_examples . '/' . $basename . '_' . $increment;
    $increment++;
}

//make directory for examples/task links
if (count($arrCanDoTaskLink) > 0 && !is_dir($filepath_examples)) {
    mkdir($filepath_examples, 0700, true);
}

//intitialize XMLWriter
$writer = new XMLWriter();

$writer->openURI($filepath);

$writer->startDocument();
$writer->setIndent(4);

// declare it as an rss document
$writer->startElement('DESCRIPTORSET');
$writer->writeAttribute('NAME', $competencyPatternTitle);

$emptyfield = false;

for ($nI = 0; $nI < count($arrCompetencyName); $nI++) {
	//check if any of the fields is empty
	if ($arrCompetencyName[$nI] == "") {
		$emptyfield = true;
		break;
	}
	
	for ($nJ = 0; $nJ < count($arrCompetencyLevel); $nJ++) {
	    //check if any of the fields is empty
		if ($arrCompetencyLevel[$nJ] == "") {
			$emptyfield = true;
			break;
		}
		
		if (array_key_exists($nI, $arrCanDo) && array_key_exists($nJ, $arrCanDo[$nI])) {
    		for ($nK = 0; $nK < count($arrCanDo[$nI][$nJ]); $nK++) {
    			if ($nK > 0 && $arrCanDo[$nI][$nJ][$nK] == "" && $arrCanDoTaskLink[$nI][$nJ][$nK] == "") {
    				continue;
    			}
    			
    			if ($arrCanDoCanBeGoal[$nI][$nJ][$nK] == false ||
        				$arrCanDoCanBeGoal[$nI][$nJ][$nK] == null ||
        				$arrCanDoCanBeGoal[$nI][$nJ][$nK] == "" ||
        				$arrCanDoCanBeGoal[$nI][$nJ][$nK] == 0) {
    				$arrCanDoCanBeGoal[$nI][$nJ][$nK] = "0";
    			}
    
    			$arrEvaluationsString = implode("; ", $arrEvaluationLevelGlobal);
    				
    			$writer->startElement("DESCRIPTOR");
    			$writer->writeAttribute('COMPETENCE', $arrCompetencyName[$nI]);
    			$writer->writeAttribute('LEVEL', $arrCompetencyLevel[$nJ]);
    			$writer->writeAttribute('EVALUATIONS', $arrEvaluationsString);
    			$writer->writeAttribute('GOAL', $arrCanDoCanBeGoal[$nI][$nJ][$nK]);
    			$writer->writeAttribute('NAME', $arrCanDo[$nI][$nJ][$nK]);
    			$writer->writeAttribute('LINK', $arrCanDoTaskLink[$nI][$nJ][$nK]);
    			$writer->endElement();
    		}
		}
	}
}

if (!$emptyfield) {
	// End Descriptorset
	$writer->endElement();
	$writer->endDocument();
	
	$writer->flush();
	
	//write to database and dataroot (create new rows/files if $id is not given, otherwise overwrite)
	if ($id != 0) {
	    write_descriptor_db($filepath, false, $subject, $id);
	}
	else {
	    write_descriptor_db($filepath, false, $subject);
	}
	
	unzipExamplesFiles();

	//reply
	json_reply(null, "OK");
}
else {
	$writer->flush();
	json_reply(true, 'Error: One of the fields is empty');
}

function unzipExamplesFiles() {
    global $dirpath_examples, $filepath_examples;
    
    try {
        system("unzip $dirpath_examples/examples.zip -d \"$filepath_examples\" > /dev/null");
    }
    catch (Exception $e) {
        json_reply(true, $e->getMessage());
    }
}

?>
