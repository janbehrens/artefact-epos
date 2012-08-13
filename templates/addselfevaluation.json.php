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

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'epos');

$subject = $_GET['subject'];

$arrCompetencyName 					= param_variable('arrCompetencyNames');
$arrCompetencyLevel 				= param_variable('arrCompetencyLevel');
$arrCanDo							= param_variable('arrCanDo');
$arrCanDoTaskLink					= param_variable('arrCanDoTaskLink');
$arrCanDoCanBeGoal					= param_variable('arrCanDoCanBeGoal');
$arrEvaluationLevelGlobal			= param_variable('arrEvaluationLevelGlobal');
$competencyPatternTitle				= param_variable('jsonCompetencyPatternTitle');
$typeOfEvaluation					= param_variable('jsonTypeOfEvaluation');

$arrCompetencyName 					= json_decode($arrCompetencyName);
$arrCompetencyLevel 				= json_decode($arrCompetencyLevel);
$arrCanDo 							= json_decode($arrCanDo);
$arrCanDoTaskLink					= json_decode($arrCanDoTaskLink);
$arrCanDoCanBeGoal					= json_decode($arrCanDoCanBeGoal);
$arrEvaluationLevelGlobal			= json_decode($arrEvaluationLevelGlobal);
$competencyPatternTitle				= json_decode($competencyPatternTitle);
$typeOfEvaluation					= json_decode($typeOfEvaluation);

$arrEvaluationsString = "";

//WRITE DATA to XML
$descriptorsetName = $competencyPatternTitle;
@date_default_timezone_set("UTC+1");

//prepare saving as file
$dataroot = realpath(get_config('dataroot'));
$dirpath = $dataroot . '/artefact/epos/descriptorsets';

if (!is_dir($dirpath)) {
    mkdir($dirpath, 0700, true);
}

$descriptorsetFileName = $descriptorsetName;
$descriptorsetFileName = str_replace('/', '_', $descriptorsetFileName);
$basename = $dirpath . '/' . $descriptorsetFileName;

while (file_exists($basename . '.xml')) {
    $basename .= '_1';
}

$path = $basename . '.xml';

//intitialize XMLWriter
$writer = new XMLWriter();

$writer->openURI($path);

$writer->startDocument();
$writer->setIndent(4);

// declare it as an rss document
$writer->startElement('DESCRIPTORSET');
$writer->writeAttribute('NAME', $descriptorsetName);

for($nI = 0; $nI < count($arrCompetencyName); $nI++) {
	for($nJ = 0; $nJ < count($arrCompetencyLevel); $nJ++) {
		//if somebody didn't set any CanDos give an empty set
		if(count($arrCanDo[$nI][$nJ]) <= 0)
			$arrCanDo[$nI][$nJ] = Array("");
		
		for($nK = 0; $nK < count($arrCanDo[$nI][$nJ]); $nK++) {
			if($nK > 0 && $arrCanDo[$nI][$nJ][$nK] == "" && $arrCanDoTaskLink[$nI][$nJ][$nK] == "")
				continue;
			
			if($arrCanDoCanBeGoal[$nI][$nJ][$nK] == false ||
				$arrCanDoCanBeGoal[$nI][$nJ][$nK] == null ||
				$arrCanDoCanBeGoal[$nI][$nJ][$nK] == "" ||
				$arrCanDoCanBeGoal[$nI][$nJ][$nK] == 0) {
					
				$arrCanDoCanBeGoal[$nI][$nJ][$nK] = "0";
			}

			$arrEvaluationsString = implode("; ", $arrEvaluationLevelGlobal);			
				
			$writer->startElement("DESCRIPTOR");
			//----------------------------------------------------
			$writer->writeAttribute('COMPETENCE', $arrCompetencyName[$nI]);
			$writer->writeAttribute('LEVEL', $arrCompetencyLevel[$nJ]);
			$writer->writeAttribute('EVALUATIONS', $arrEvaluationsString);
			$writer->writeAttribute('GOAL', $arrCanDoCanBeGoal[$nI][$nJ][$nK]);
			$writer->writeAttribute('NAME', $arrCanDo[$nI][$nJ][$nK]);
			$writer->writeAttribute('LINK', $arrCanDoTaskLink[$nI][$nJ][$nK]);
			//----------------------------------------------------
			$writer->endElement();
				
		}
	}
}

// End Descriptoset
$writer->endElement();
$writer->endDocument();

$writer->flush();

write_descriptor_db($path, $subject);

//reply
json_reply(null, $arrCompetencyName[0]);

?>
