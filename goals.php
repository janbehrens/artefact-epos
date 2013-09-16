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

define('INTERNAL', true);
define('MENUITEM', 'goals/goals');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'goals');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('goals', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');
safe_require('artefact', 'epos');

$haslanguages = true;

$evaluation_selector = ArtefactTypeChecklist::form_user_evaluation_selector();
if (!$evaluation_selector) {
    $haslanguages = false;
    $languagelinks = get_string('nolanguageselected1', 'artefact.epos') . '<a href=".">' . get_string('mylanguages', 'artefact.epos') . '</a>' . get_string('nolanguageselected2', 'artefact.epos');
}
$id = $evaluation_selector['selected'];
$evaluation = new ArtefactTypeChecklist($id);
$evaluation->check_permission();

$addcustomgoalform = ArtefactTypeCustomGoal::form_add_customgoal($is_goal=true, 'customgoalSaveCallback');

$textSaveCustomgoalchanges = get_string('save', 'artefact.epos');
$textCancelCustomgoalchanges = get_string('cancel', 'artefact.epos');
$reallyDeleteCustomGoal = get_string('customlearninggoalwanttodelete', 'artefact.epos');

$editCustomgoal = get_string('edit', 'mahara');
$deleteCustomgoal = get_string('delete', 'mahara');

$inlinejs = <<<EOF

var oldTA = new Array();
var openToEdit = new Array();

function editCustomGoalOut(customgoal_id) {
	if(!openToEdit[customgoal_id]) {
		openToEdit[customgoal_id] = true;
		oldTA[customgoal_id] = customgoal_text = document.getElementById(customgoal_id).innerHTML;
		if(customgoal_text.substr(0, 5) != "<form") {
			document.getElementById(customgoal_id).innerHTML = '<form name="bm" action="javascript: submitEditCustomGoal('+customgoal_id+');">' +
			'<textarea class="customgoalta" id="ta_'+ customgoal_id+'">' + customgoal_text + '</textarea>' +
			'<input class="submitcancel submit" type="submit" value="$textSaveCustomgoalchanges" />' +
			'<input class="submitcancel cancel" type="reset" value="$textCancelCustomgoalchanges" onClick="javascript: cancleEditCustomGoalOut('+customgoal_id+');"/>' +
			'</form>';
		}
	}
}

function cancleEditCustomGoalOut(customgoal_id) {
	document.getElementById(customgoal_id).innerHTML = oldTA[customgoal_id];
	openToEdit[customgoal_id] = false;
	return true;
}

function submitEditCustomGoal(customgoal_id) {
	ta_id = 'ta_'+customgoal_id;
	customgoal_text = document.getElementById(ta_id).value;
	sendjsonrequest('customgoalupdate.json.php',
            {'customgoal_id': customgoal_id,
            'customgoal_text': customgoal_text},
            'POST',
            function() {
            	tableRenderer.doupdate();
            },
            function() {
            	// @todo error
            });
   openToEdit[customgoal_id] = false;
}

function customgoalSaveCallback(form, data) {
    tableRenderer.doupdate();
    // Can't reset() the form here, because its values are what were just submitted,
    // thanks to pieforms
    forEach(form.elements, function(element) {
        if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) {
            element.value = '';
        }
    });
}

function deleteCustomGoal(customgoal_id) {
    if (confirm('$reallyDeleteCustomGoal')) {
        sendjsonrequest('customgoaldelete.json.php',
            {'customgoal_id': customgoal_id},
            'GET',
            function(data) {
                tableRenderer.doupdate();
            },
            function() {
                // @todo error
            }
        );
    }
}

tableRenderer = new TableRenderer(
    'goals_table',
    'goals.json.php?id={$id}',
    [
        function (r, d) {
        	var data = TD(null);
        	if(r.descriptor == null && r.description != null) {
            	data.innerHTML = '<div class="customgoalText" id="' + r.id + '">' + r.description + '</div>';
            	return data;
			}
            return TD(null, r.descriptor);
        },
        function (r, d) {
            var level = "";
            var competence = "";
        	if(r.competence != null) {
        		competence = r.competence;
        	}
        	if (typeof r.level !== "undefined") {
        	    level = r.level;
        	}
            return TD(null, competence + ' ' + level);
        },
        function (r, d) {
        	var data = TD(null);
        	if(r.description != null) {
        		data.innerHTML = '<div style="width:32px;"><a href="javascript: onClick=editCustomGoalOut('+r.id+');" title="$editCustomgoal"><img src="../../theme/raw/static/images/edit.gif" alt="$editCustomgoal"></a><a href="javascript: deleteCustomGoal('+r.id+');" title="$deleteCustomgoal"><img src="../../theme/raw/static/images/icon_close.gif" alt="$deleteCustomgoal"></a></div>';
                return data;
			}

			return TD(null);
		},
    ]
);

tableRenderer.type = 'goals';
tableRenderer.statevars.push('type');
tableRenderer.emptycontent = '';
tableRenderer.paginate = false;
tableRenderer.updateOnLoad();
EOF;

$smarty = smarty(array('tablerenderer'));

$smarty->assign('haslanguages', $haslanguages);
$smarty->assign('languagelinks', $evaluation_selector['html']);
if ($haslanguages) $smarty->assign("custom_goal_form", $addcustomgoalform);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('goals', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:goals.tpl');
