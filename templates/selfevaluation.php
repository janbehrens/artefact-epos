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


$text_valuationlevel	= get_string('valuationlevel', 'artefact.epos');
$text_competencyname	= get_string('competency_name', 'artefact.epos');
$text_competencylevel	= get_string('competency_level', 'artefact.epos');
$text_cando_statement	= get_string('cando_statement', 'artefact.epos');
$text_tasklink			= get_string('tasklink', 'artefact.epos');

$addstr = get_string('add', 'artefact.epos');
$cancelstr = get_string('cancel', 'artefact.epos');
$delstr = get_string('del', 'artefact.epos');
$installstr = 'Install';//get_string('install', 'artefact.epos');
$uninstallstr = 'Uninstall';//get_string('install', 'artefact.epos');
$confirmdelstr = get_string('confirmdel', 'artefact.epos');

//JS stuff
$inlinejs = <<<EOF

function submitLoadDescriptorset(file) {
	sendjsonrequest('loaddescriptorset.json.php',
            {'file': file},
            'POST', 
            function() {
            	tableRenderer.doupdate();
            },
            function() {
            	// @todo error
            });
}

function submitUnloadDescriptorset(file) {
}

tableRenderer = new TableRenderer(
    'descriptorsets',
    'selfevaluation.json.php',
    [
        function (r, d) {
            return TD(null, r.name);
        },
        function (r, d) {
            return TD(null, SPAN({'style': 'font-style:italic'}, r.installed));
        },
        function (r, d) {
            if (r.installed == 'not installed') {
                return TD(null, A({'class': '', 'href': 'javascript: onClick=submitLoadDescriptorset("'+r.file+'");'}, '{$installstr}'));
            }
            else {
                return TD(null, A({'class': '', 'href': 'javascript: onClick=submitUnloadDescriptorset("'+r.file+'");'}, '{$uninstallstr}'));
            }
        },
    ]
);

tableRenderer.emptycontent = '';
tableRenderer.updateOnLoad();


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
	var jsonCanDoCanBeGoal					= JSON.stringify(arrCanDoCanBeGoal);
	var jsonValuationLevelGlobal			= JSON.stringify(arrValuationLevelGlobal);
	var jsonTypeOfValuation					= JSON.stringify(nActValuationDegreeId);
	
	
	sendjsonrequest('addselfevaluation.json.php',
            {'arrCompetencyNames': jsonCompetencyName,
				'arrCompetencyLevel': jsonCompetencyLevel,
				'arrCanDo': jsonCanDo,
				'arrCanDoTaskLink': jsonCanDoTaskLink,
				'arrCanDoCanBeGoal': jsonCanDoCanBeGoal,
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

var text_valuationlevel 	= "$text_valuationlevel";
var text_competencyname 	= "$text_competencyname";
var text_competencylevel 	= "$text_competencylevel";
var text_cando_statement	= "$text_cando_statement";
var text_tasklink			= "$text_tasklink";
var text_canBeGoal			= "Lernziel?";
EOF;

$smarty = smarty(array('tablerenderer',
    				   'jquery',
					   'artefact/epos/js/create_selfevaluation.js')
);

//localization assignment to smarty
$smarty->assign('text_num_valuation_levels', get_string('num_valuation_levels', 'artefact.epos'));
$smarty->assign('text_name_valuation_grid', get_string('name_valuation_grid', 'artefact.epos'));
$smarty->assign('text_num_rows', get_string('num_rows', 'artefact.epos'));
$smarty->assign('text_num_cols', get_string('num_cols', 'artefact.epos'));

//$smarty->assign('id', $id);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('create_selfevaluation_template', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:create_selfevaluation.tpl');



?>
