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
define('INSTITUTIONALSTAFF', 1);
define('MENUITEM', 'templates/subjects');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
define('TITLE', get_string('subjects', 'artefact.epos'));
require_once('pieforms/pieform.php');
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

$subject = isset($_GET['subject']) ? $_GET['subject'] : '';
$links_inst = '';
$links_subj = '';

// generate institution list
if ($institutions) {
    // select first institution if GET parameter is not set
    if ($institution == '') {
        $institution = $institutions[0]->name;
    }

    $links_inst = '<p>' . get_string('institution', 'mahara') . ': ';

    foreach ($institutions as $field) {
        if ($field->name == $institution) {
            $links_inst .= '<b>';
            $institutionexists = true;
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

$addstr = get_string('add', 'artefact.epos');
$cancelstr = get_string('cancel', 'artefact.epos');
$activatestr = get_string('activate', 'artefact.epos');
$deactivatestr = get_string('deactivate', 'artefact.epos');
$editstr = get_string('edit', 'artefact.epos');
$savestr =get_string('save');
$selfevaluationstr = get_string('selfevaluation', 'artefact.epos');
$deletestr = get_string('delete', 'mahara');
$confirmdelstr = get_string('confirmdeletesubject', 'artefact.epos', "' + name + '");

$inlinejs = <<<EOF

function toggleForm() {
    var elemName = 'subjectform';
    if (hasElementClass(elemName, 'hidden')) {
        removeElementClass(elemName, 'hidden');
        $('addbutton').innerHTML = '{$cancelstr}';
    }
    else {
        $('addbutton').innerHTML = '{$addstr}';
        addElementClass(elemName, 'hidden');
    }
}

function saveCallback(form, data) {
    tableRenderer.doupdate();
    toggleForm();
    // Can't reset() the form here, because its values are what were just submitted,
    // thanks to pieforms
    forEach(form.elements, function(element) {
        if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) {
            element.value = '';
        }
    });
}

function activateSubject(id) {
    sendjsonrequest('activatesubject.json.php?activate=1',
            {'id': id},
            'POST',
            function() {
                tableRenderer.doupdate();
            });
}

function deactivateSubject(id) {
    sendjsonrequest('activatesubject.json.php?activate=0',
            {'id': id},
            'POST',
            function() {
                tableRenderer.doupdate();
            });
}

function deleteSubject(id, name) {
    if (confirm('{$confirmdelstr}')) {
        sendjsonrequest('deletesubject.json.php',
                {'id': id},
                'POST',
                function() {
                    tableRenderer.doupdate();
                });
    }
}

var oldText;
var openToEdit = false;

function editSubject(id) {
    if(!openToEdit) {
        openToEdit = true;
        oldText = document.getElementById("subject" + id).innerHTML;
        if(oldText.substr(0, 5) != "<form") {
            document.getElementById("subject" + id).innerHTML = '<form action="javascript: submitEdit('+id+');">' +
            '<input id="input_'+ id+'" value="' + oldText + '"/>' +
            '<input class="submitcancel submit" type="submit" value="$savestr" />' +
            '<input class="submitcancel cancel" type="reset" value="$cancelstr" onClick="javascript: cancelEditing('+id+');"/>' +
            '</form>';
        }
    }
}

function cancelEditing(id) {
    document.getElementById("subject" + id).innerHTML = oldText;
    openToEdit = false;
    return true;
}

function submitEdit(id) {
    text = document.getElementById('input_'+id).value;
    sendjsonrequest('updatesubject.json.php',
            {'id': id,
            'text': text},
            'POST',
            function() {
                tableRenderer.doupdate();
            },
            function() {
                // @todo error
            });
   openToEdit = false;
}

tableRenderer = new TableRenderer(
    'subjectslist',
    'subjects.json.php?institution={$institution}',
    [
        function (r, d) {
            var data =  TD(null);
            data.innerHTML = '<div id="subject' + r.id + '">' + r.name + '</div>';
            return data;
        },
        function (r, d) {
            if (r.active == 1) {
                return TD(null, A({'class': '', 'href': 'javascript: onClick=deactivateSubject(' + r.id + ');'}, '{$deactivatestr}'));
            }
            else {
                return TD(null, A({'class': '', 'href': 'javascript: onClick=activateSubject(' + r.id + ');'}, '{$activatestr}'));
            }
        },
        function (r, d) {
            return TD(null, A({'class': 'icon btn-edit s', 'href': 'javascript: onClick=editSubject('+r.id+')'}, '{$editstr}'));
        },
        function (r, d) {
            return TD(null, A({'class': 'icon btn-del s', 'href': 'javascript: onClick=deleteSubject(' + r.id + ', "' + r.name + '");'}, '{$deletestr}'));
        },
        function (r, d) {
            if (r.active == 1) {
                link1 = A({'class': 'icon btn-edit s', 'href': '../templates/selfevaluation.php?institution=' + '{$institution}' + '&subject=' + r.id}, '{$selfevaluationstr}');
                return TD(null, link1);
            }
        },
    ]
);

tableRenderer.emptycontent = '';
tableRenderer.updateOnLoad();
EOF;

//pieform
$elements = array(
    'name' => array(
        'type' => 'text',
        'title' => get_string('name', 'mahara'),
        'defaultvalue' => '',
        'rules' => array('required' => true),
    ),
    'institution' => array(
        'type' => 'hidden',
        'value' => $institution,
    )
);
$elements['submit'] = array(
    'type' => 'submit',
    'value' => get_string('save', 'artefact.epos'),
);

$subjectform = pieform(array(
    'name' => 'addsubjectform',
    'plugintype' => 'artefact',
    'pluginname' => 'epos',
    'elements' => $elements,
    'jsform' => true,
    'successcallback' => 'form_submit',
    'jssuccesscallback' => 'saveCallback',
));

$smarty = smarty(array('tablerenderer'));
$smarty->assign('accessdenied', $accessdenied);
$smarty->assign_by_ref('links_institution', $links_inst);
$smarty->assign_by_ref('subjectform', $subjectform);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:subjects.tpl');


/**
 * form submit function
 */
function form_submit(Pieform $form, $values) {
    try {
        process_form($form, $values);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('addedsubject', 'artefact.epos'));
}

function process_form(Pieform $form, $values) {
    $values['active'] = 1;
    if ($values['name'] != '') {
        $sql = "SELECT name FROM artefact_epos_subject WHERE name = ? AND institution = ?";

        if (!get_records_sql_array($sql, array($values['name'], $values['institution']))) {
            insert_record('artefact_epos_subject', (object)$values);
        }
    }
}
