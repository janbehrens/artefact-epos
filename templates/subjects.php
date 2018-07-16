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
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012 TZI / Universität Bremen
 *
 */

define('INTERNAL', true);
define('INSTITUTIONALSTAFF', 1);
define('MENUITEM', 'templates/subjects');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
define('TITLE', get_string('subjects', 'artefact.epos'));
require_once('pieforms/pieform.php');
safe_require('artefact', 'epos');

$institutionselector = get_institution_selector(true, false, true, true);

try {
    $institution = $institutionselector['defaultvalue'] = param_alpha('institution');
}
catch (Exception $e) {
    $institution = $institutionselector['defaultvalue'];
}

$selector = pieform(array(
    'name' => 'selector',
    'checkdirtychange' => false,
    'elements' => array(
        'institution' => $institutionselector
    ),
    'jsform' => true
));

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

function onInstitutionSelect() {
    // If there are at least two options, pieforms builds a select, otherwise a hidden input
    var institutionSelect = jQuery('select#selector_institution');
    var institutionInput = jQuery('input#selector_institution');
    if (institutionSelect.length > 0) {
        var selectedInstitution = institutionSelect.children(':selected').attr('value');
    }
    else {
        var selectedInstitution = institutionInput.attr('value');
    }
    window.location = '?institution=' + selectedInstitution;
}

jQuery(window).load(function () {
    jQuery('select#selector_institution').change(onInstitutionSelect);
})

function toggleForm() {
    var elem = $('#subjectform');
    var btn = $('#addbutton');
    if (elem.hasClass('hidden')) {
        elem.removeClass('hidden');
        btn.text('{$cancelstr}');
    } else {
        elem.addClass('hidden');        
        btn.text('{$addstr}');
    }
}

function saveCallback(form, data) {
    tableRenderer.doupdate();
    toggleForm();
    // clear form input fields
    $(form).find('.text,.textarea').val('');
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
            return $('<td />').append($('<div />', {
                id: 'subject' + r.id,
                text: r.name
            }));
        },
        function (r, d) {
            if (r.active == 1) {
                return $('<td />').append($('<a />', {
                    class: '',
                    href: 'javascript: onClick=deactivateSubject(' + r.id + ');',
                    text: '{$deactivatestr}'
                }));
            } else {
                return $('<td />').append($('<a />', {
                    class: '',
                    href: 'javascript: onClick=activateSubject(' + r.id + ');',
                    text: '{$activatestr}'
                }));
            }
        },
        function (r, d) {
            return $('<td />').append($('<a />', {
                class: 'icon btn-edit s',
                href: 'javascript: onClick=editSubject(' + r.id + ');',
                text: '{$editstr}'
            }));
        },
        function (r, d) {
            return $('<td />').append($('<a />', {
                class: 'icon btn-del s',
                href: 'javascript: onClick=deleteSubject(' + r.id + ', "' + r.name + '");',
                text: '{$deletestr}'
            }));
        },
        function (r, d) {
            if (r.active == 1) {
                return $('<td />').append($('<a />', {
                    class: 'icon btn-edit s',
                    href: '../templates/selfevaluation.php?institution=' + '{$institution}' + '&subject=' + r.id,
                    text: '{$selfevaluationstr}'
                }));
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
$smarty->assign_by_ref('selector', $selector);
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
