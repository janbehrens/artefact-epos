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
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2013 TZI / Universität Bremen
 *
 */

var oldText = new Array();
var openToEdit = new Array();

function editCustomGoal(customgoal_id) {
    customGoalNode = document.getElementById('custom_' + customgoal_id);
    customgoal_text = customGoalNode.innerHTML;
    
    //on self-evaluation page: embedded in evaluation pieform
    if (customGoalNode.parentNode.parentNode.parentNode.parentNode.parentNode.nodeName == 'FORM') {
        if (!customGoalNode.parentNode.classList.contains('hidden')) {
            customGoalNode.parentNode.classList.add('hidden');
            customGoalNode.parentNode.parentNode.children[1].classList.remove('hidden');
        }
        else {
            customGoalNode.parentNode.classList.remove('hidden');
            customGoalNode.parentNode.parentNode.children[1].classList.add('hidden');
        }
    }
    //on goals page: extra form for editing
    else {
        if (!openToEdit[customgoal_id]) {
            openToEdit[customgoal_id] = true;
            oldText[customgoal_id] = customgoal_text
            
            if (customgoal_text.substr(0, 5) != "<form") {
                customGoalNode.innerHTML = '<form name="bm" action="javascript: submitEditCustomGoal('+customgoal_id+');">' +
                '<textarea class="customgoalta" id="ta_' + customgoal_id + '">' + customgoal_text + '</textarea>' +
                '<input class="submitcancel submit" type="submit" value="' + strings['save'] + '" />' +
                '<input class="submitcancel cancel" type="reset" value="' + strings['cancel'] + '" onClick="javascript: cancelEditCustomGoalOut('+customgoal_id+');"/>' +
                '</form>';
            }
        }
    }
}

function cancelEditCustomGoalOut(customgoal_id) {
    document.getElementById('custom_' + customgoal_id).innerHTML = oldText[customgoal_id];
    openToEdit[customgoal_id] = false;
    return true;
}

function submitEditCustomGoal(customgoal_id) {
    ta_id = 'ta_' + customgoal_id;
    customgoal_text = document.getElementById(ta_id).value;
    sendjsonrequest(config.wwwroot + 'artefact/epos/customgoalupdate.json.php',
            {'customgoal_id': customgoal_id,
            'customgoal_text': customgoal_text},
            'POST',
            function() {
                window.location.reload();
            },
            function($args) {
                alert("Error saving goal, please contact your system administrator.");
            });
   openToEdit[customgoal_id] = false;
}

function deleteCustomGoal(customgoal_id) {
    if (confirm(strings['customlearninggoalwanttodelete'])) {
        sendjsonrequest(config.wwwroot + 'artefact/epos/customgoaldelete.json.php',
            {'customgoal_id': customgoal_id},
            'GET',
            function(data) {
                window.location.reload();
            },
            function() {
                // @todo error
            }
        );
    }
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
