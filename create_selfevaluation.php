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
define('SECTION_PAGE', 'create_selfevaluation');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('create_selfevaluation', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');
safe_require('artefact', 'epos');

$haslanguages = true;



$my = json_encode();

//JS stuff
$inlinejs .= <<<EOF
function submitTemplate() {
	/*
	alert(arrCompetencyName);
	alert(arrCompetencyLevel);	
	
	alert(arrCanDoTaskLinks["0_0"]);	
	alert(arrCompetencyNameComment);	
	alert(arrValuationLevelCompetencyName[0][0]);
	alert(arrValuationLevelCompetencyLevel[0][0]);	
	alert(arrValuationLevelGlobal[0]);
	*/
	
	
	var jsonCompetencyPatternTitle			= JSON.stringify(document.getElementById('competencyPatternTitle').value);
	var jsonCompetencyName 					= JSON.stringify(arrCompetencyName);
	var jsonCompetencyLevel 				= JSON.stringify(arrCompetencyLevel);
	var jsonCanDo 							= JSON.stringify(arrCanDo);
	var jsonCanDoTaskLink					= JSON.stringify(arrCanDoTaskLinks);
	var jsonValuationLevelCompetencyName	= JSON.stringify(arrValuationLevelCompetencyName);
	var jsonValuationLevelCompetencyLevel	= JSON.stringify(arrValuationLevelCompetencyLevel);
	var jsonValuationLevelGlobal			= JSON.stringify(arrValuationLevelGlobal);
	var jsonTypeOfValuation					= JSON.stringify(nActValuationDegreeId);
	
	
	sendjsonrequest('create_selfevaluation.json.php',
            {'arrCompetencyNames': jsonCompetencyName,
				'arrCompetencyLevel': jsonCompetencyLevel,
				'arrCanDo': jsonCanDo,
				'arrCanDoTaskLink': jsonCanDoTaskLink,
				'arrValuationLevelCompetencyName': jsonValuationLevelCompetencyName,
				'arrValuationLevelCompetencyLevel': jsonValuationLevelCompetencyLevel,
				'arrValuationLevelGlobal': jsonValuationLevelGlobal,
				'jsonTypeOfValuation': jsonTypeOfValuation,
				'jsonCompetencyPatternTitle': jsonCompetencyPatternTitle
			
			},
            'POST', 
            function() {
            	alert("send");
            },
            function() {
            	// @todo error
            });
}
EOF;

$smarty = smarty(array('tablerenderer',
    				   'jquery',
					   'artefact/epos/js/create_selfevaluation.js')
);

$smarty->assign('id', $id);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('create_selfevaluation', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:create_selfevaluation.tpl');



?>
