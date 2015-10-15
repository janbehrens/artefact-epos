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
define('MENUITEM', 'evaluation/addremove');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'addremove');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('myselfevaluations', 'artefact.epos'));
require_once('pieforms/pieform.php');
safe_require('artefact', 'epos');

$optionssubject = get_subjects();
$optionsdescriptors = get_descriptorsets(array_keys($optionssubject));

$addstr = get_string('add', 'artefact.epos');
$cancelstr = get_string('cancel', 'artefact.epos');
$delstr = get_string('del', 'artefact.epos');
$selfevalstr = get_string('selfevaluation', 'artefact.epos');
$confirmdelstr = get_string('confirmdel', 'artefact.epos');
$nodescriptorsetstr = get_string('nodescriptorsetavailable', 'artefact.epos');

$inlinejs = <<<EOF

function toggleLanguageForm() {
    var elemName = 'learnedlanguageform';
    if (hasElementClass(elemName, 'hidden')) {
        removeElementClass(elemName, 'hidden');
        addElementClass('addlearnedlanguagebutton', 'hidden');
    }
    else {
        removeElementClass('addlearnedlanguagebutton', 'hidden');
        addElementClass(elemName, 'hidden');
    }
    loadDescriptorsets();
    jQuery('select#createselfevaluation_subject').change(loadDescriptorsets);
}

function saveCallback(form, data) {
    tableRenderer.doupdate();
    toggleLanguageForm();
    forEach(form.elements, function(element) {
        if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) {
            element.value = '';
        }
    });
}

function deleteLanguage(evaluation_id) {
    if (confirm('{$confirmdelstr}')) {
        sendjsonrequest('evaluationdelete.json.php',
            {evaluation_id: evaluation_id},
            'GET',
            function(data) {
                tableRenderer.doupdate();
            },
            function() {
                // @todo error
            }
        );
    }
    return false;
}

function loadDescriptorsets() {
    // If there are at least two options, pieforms builds a select, otherwise a hidden input
    var subjectSelect = jQuery('select#createselfevaluation_subject');
    var subjectInput = jQuery('input#createselfevaluation_subject');
    if (subjectSelect.length > 0) {
        var selectedSubject = subjectSelect.children(':selected').attr('value');
    }
    else {
        var selectedSubject = subjectInput.attr('value');
    }

    var descriptorsetContainer = jQuery('#createselfevaluation_descriptorset_container td');
    var descriptorsetSelect = jQuery('select#createselfevaluation_descriptorset');
    var descriptorsetOptions = descriptorsetSelect.children();
    var descriptorsetInput = jQuery('input#createselfevaluation_descriptorset');

    sendjsonrequest('evaluationform.json.php',
        {subject_id: selectedSubject},
        'GET',
        function (data) {
            descriptorsetContainer.children().remove();

            if (data instanceof Array) {
                jQuery('#createselfevaluation_descriptorset_container td')
                    .append('<span>{$nodescriptorsetstr}</span>');
            }
            else {
                descriptorsetContainer.append('<select class="select" id="createselfevaluation_descriptorset" name="descriptorset"></select>');
                descriptorsetSelect = jQuery('select#createselfevaluation_descriptorset');
                for (var id in data) {
                    descriptorsetSelect.append(new Option(data[id], id));
                }
            }
        }
    );
}

tableRenderer = new TableRenderer(
    'evaluationslist',
    'evaluations.json.php',
    [
        function (r, d) {
            var link = A({'href': './evaluation/self-eval.php?id=' + r.id}, r.title);
            return TD(null, link);
        },
        function (r, d) {
            return TD(null, r.descriptorset);
        },
        function (r, d) {
            var del = A({'class': 'icon btn-del s', 'href': ''}, '{$delstr}');
            connect(del, 'onclick', function (e) {
                e.stop();
                return deleteLanguage(r.id);
            });
            return TD(null, del);
        },
    ]
);

tableRenderer.emptycontent = '';
tableRenderer.updateOnLoad();
EOF;

//pieform
if (count($optionssubject) > 0) {
    $evaluationsform = pieform(array(
        'name' => 'createselfevaluation',
        'jsform' => true,
        'jssuccesscallback' => 'saveCallback',
        'elements' => array(
            'subject' => array(
                'type' => 'select',
                'title' => get_string('subject', 'artefact.epos'),
                'options' => $optionssubject,
            ),
            'descriptorset' => array(
                'type' => 'select',
                'title' => get_string('descriptorset', 'artefact.epos'),
                'options' => $optionsdescriptors,
            ),
            'label' => array(
                'type' => 'text',
                'size' => 50,
                'title' => get_string('label', 'artefact.epos'),
                'defaultvalue' => '',
            ),
            'submit' => array(
                'type' => 'submitcancel',
                'value' => array(get_string('save', 'artefact.epos'), get_string('cancel')),
                'goto' => '.'
            )
        )));
}

$smarty = smarty(array('tablerenderer', 'jquery'));
$smarty->assign_by_ref('evaluationsform', $evaluationsform);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:index.tpl');

/**
 * Get options for subject select
 */
function get_subjects() {
    global $USER;
    $subjects = array();

    // subjects from user's institutions
    $sql = "SELECT s.id, s.name, i.displayname FROM artefact_epos_subject s
            JOIN usr_institution ui ON ui.institution = s.institution
            JOIN institution i ON i.name = s.institution
            WHERE ui.usr = ? AND s.active = 1";

    if (!$data = get_records_sql_array($sql, array($USER->id))) {
        $data = array();
    }

    // subjects from "No institution"
    $sql = "SELECT s.id, s.name, i.displayname FROM artefact_epos_subject s
            JOIN institution i ON i.name = s.institution
            WHERE s.institution = 'mahara' AND s.active = 1";

    if (!$data1 = get_records_sql_array($sql, null)) {
        $data1 = array();
    }

    $data = array_merge($data, $data1);

    usort($data, function ($a, $b) {
        return strcoll($a->name, $b->name);
    });

    foreach ($data as $subject) {
        $subjects[$subject->id] = $subject->name . " ($subject->displayname)";
    }
    return $subjects;
}

/**
 * Get descriptor sets for pieform select
 */
function get_descriptorsets($subjects) {
    $sql = "SELECT id, name, descriptorset, subject FROM artefact_epos_descriptorset d
            JOIN artefact_epos_descriptorset_subject ds ON d.id = ds.descriptorset
            WHERE active = 1 AND (" .
            implode(" OR ", array_map(function ($id) {
                    return "subject = $id";
                }, $subjects)) .
            ")";
    if (!$data = get_records_sql_array($sql, array())) {
        $data = array();
    }
    $descriptorsets = array();
    foreach ($data as $descriptorset) {
        $descriptorsets[$descriptorset->id] = $descriptorset->name;
    }
    return $descriptorsets;
}

/**
 * form validate function
 */
function createselfevaluation_validate(Pieform $form, $values) {
    if ($values['label'] == '') {
        $form->set_error('label', get_string('labelnotvalid', 'artefact.epos'));
    }
    if ($values['descriptorset'] == '') {
        $form->set_error('descriptorset', get_string('descriptorsetnotvalid', 'artefact.epos'));
    }
}

/**
 * form submit function
 */
function createselfevaluation_submit(Pieform $form, $values) {
    global $USER, $optionsdescriptors;
    $owner = $USER->get('id');
    try {
        create_subject_for_user($values['subject'], $values['label'], $values['descriptorset'], $optionsdescriptors[$values['descriptorset']], $owner);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('addedlanguage', 'artefact.epos'));
}
