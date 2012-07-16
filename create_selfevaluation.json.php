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

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'epos');

$arrCompetencyName 					= param_variable('arrCompetencyNames');
$arrCompetencyLevel 				= param_variable('arrCompetencyLevel');
$arrCanDo							= param_variable('arrCanDo');
$arrCanDoTaskLink					= param_variable('arrCanDoTaskLink');
$arrValuationLevelCompetencyName	= param_variable('arrValuationLevelCompetencyName');
$arrValuationLevelCompetencyLevel	= param_variable('arrValuationLevelCompetencyLevel');
$arrValuationLevelGlobal			= param_variable('arrValuationLevelGlobal');
$competencyPatternTitle				= param_variable('jsonCompetencyPatternTitle');
$typeOfValuation					= param_variable('jsonTypeOfValuation');

$arrCompetencyName 					= json_decode($arrCompetencyName);
$arrCompetencyLevel 				= json_decode($arrCompetencyLevel);
$arrCanDo 							= json_decode($arrCanDo);
$arrCanDoTaskLink					= json_decode($arrCanDoTaskLink);
$arrValuationLevelCompetencyName	= json_decode($arrValuationLevelCompetencyName);
$arrValuationLevelCompetencyLevel	= json_decode($arrValuationLevelCompetencyLevel);
$arrValuationLevelGlobal			= json_decode($arrValuationLevelGlobal);
$competencyPatternTitle				= json_decode($competencyPatternTitle);
$typeOfValuation					= json_decode($typeOfValuation);

$arrEvaluationsString = "";

//WRITE DATA to XML
$descriptorsetName = $competencyPatternTitle;
@date_default_timezone_set("UTC+1");

$writer = new XMLWriter();
// Output directly to the user

$writer->openURI('my.xml');
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
			
			switch($typeOfValuation) {
				case 1:
					$arrEvaluationsString = implode("; ", $arrValuationLevelGlobal);
					break;
						
				case 2:
					$arrEvaluationsString = implode("; ", $arrValuationLevelCompetencyName[$nI]);
					break;
						
				case 3:
					$arrEvaluationsString = implode("; ", $arrValuationLevelCompetencyLevel[$nJ]);
					break;
						
				default:
					$arrEvaluationsString = "";
				break;
			}	
			
				
			$writer->startElement("DESCRIPTOR");
			//----------------------------------------------------
			$writer->writeAttribute('COMPETENCE', $arrCompetencyName[$nI]);
			$writer->writeAttribute('LEVEL', $arrCompetencyLevel[$nJ]);
			$writer->writeAttribute('EVALUATIONS', $arrEvaluationsString);
			$writer->writeAttribute('GOAL', "1");
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

write_descriptor_db('my.xml');

//reply
json_reply(null, $arrCompetencyName[0]);

?>
