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
define('MENUITEM', 'subjects');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'index');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('mylanguages', 'artefact.epos'));
require_once('pieforms/pieform.php');

$optionssubject = get_subjects();
$accessdenied = false;
$nodescriptorsets = false;

if (isset($_GET['addsubject'])) {
    $addsubject = $_GET['addsubject'];

    //check if user is allowed to use the subject indicated by GET parameter
    if ($addsubject != 0 && !in_array($addsubject, array_keys($optionssubject))) {
        $accessdenied = true;
    }
}
else {
    foreach (array_keys($optionssubject) as $id) {
        $addsubject = $id;
        break;
    }
}

$optionsdescriptors = get_descriptorsets();

if (count($optionsdescriptors) == 0) {
    $nodescriptorsets = true;
}

$addstr = get_string('add', 'artefact.epos');
$cancelstr = get_string('cancel', 'artefact.epos');
$delstr = get_string('del', 'artefact.epos');
$selfevalstr = get_string('selfevaluation', 'artefact.epos');
$confirmdelstr = get_string('confirmdel', 'artefact.epos');

$inlinejs = <<<EOF

function toggleLanguageForm() {
    var elemName = 'learnedlanguageform';
    if (hasElementClass(elemName, 'hidden')) {
        removeElementClass(elemName, 'hidden');
        $('addlearnedlanguagebutton').innerHTML = '{$cancelstr}';
    }
    else {
        $('addlearnedlanguagebutton').innerHTML = '{$addstr}';
        addElementClass(elemName, 'hidden');
    }
}

function languageSaveCallback(form, data) {
    tableRenderer.doupdate();
    toggleLanguageForm();
    // Can't reset() the form here, because its values are what were just submitted,
    // thanks to pieforms
    forEach(form.elements, function(element) {
        if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) {
            element.value = '';
        }
    });
}

function deleteLanguage(checklist_id) {
    if (confirm('{$confirmdelstr}')) {
        sendjsonrequest('languagedelete.json.php',
            {'checklist_id': checklist_id},
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

tableRenderer = new TableRenderer(
    'learnedlanguagelist',
    'language.json.php',
    [
        function (r, d) {
            return TD(null, r.title);
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
            var edit = A({'class': 'icon btn-edit s', 'href': 'checklist.php?id=' + r.id}, '{$selfevalstr}');
            return TD(null, edit, ' ', del);
        },
    ]
);

tableRenderer.emptycontent = '';
tableRenderer.updateOnLoad();

function refreshDescriptorsets() {
    var selected = jQuery('#addlearnedlanguage_subject_container').children('td:first').children(':first').attr('value');
    window.location = '?addsubject=' + selected;
}
EOF;

//pieform
if (count($optionssubject) > 0 /*&& count($optionsdescriptors) > 0*/) {
    $elements = array(
        'subject' => array(
            'type' => 'select',
            'title' => get_string('subjectform.subject', 'artefact.epos'),
            'options' => $optionssubject,
        ),
        'title' => array(
            'type' => 'text',
            'title' => get_string('subjectform.title', 'artefact.epos'),
            'defaultvalue' => '',
        ),
        'descriptorset' => array(
            'type' => 'select',
            'title' => get_string('subjectform.descriptorset', 'artefact.epos'),
            'options' => $optionsdescriptors,
         ),
    );
    if ($addsubject != 0) {
        $elements['subject']['defaultvalue'] = $addsubject;
    }
    $elements['submit'] = array(
        'type' => 'submit',
        'value' => get_string('save', 'artefact.epos'),
    );

    $languageform = pieform(array(
        'name' => 'addlearnedlanguage',
        'plugintype' => 'artefact',
        'pluginname' => 'epos',
        'elements' => $elements,
        'jsform' => true,
        'jssuccesscallback' => 'languageSaveCallback',
    ));
}

$smarty = smarty(array('tablerenderer', 'jquery'));
$smarty->assign('addsubjectset', isset($_GET['addsubject']));
$smarty->assign('accessdenied', $accessdenied);
$smarty->assign('nodescriptorsets', $nodescriptorsets);
$smarty->assign_by_ref('languageform', $languageform);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:index.tpl');

/**
 * Get language options for pieform select
 */
function get_subjects() {
    global $USER;
    $subjects = array();

    $sql = "SELECT s.id, s.name, s.institution, i.displayname FROM artefact_epos_subject s
            JOIN usr_institution ui ON ui.institution = s.institution
            JOIN institution i ON i.name = s.institution
            WHERE ui.usr = ? AND s.active = 1";

    if (!$data = get_records_sql_array($sql, array($USER->id))) {
        $data = array();
    }

    $sql = "SELECT s.id, s.name, s.institution, i.displayname FROM artefact_epos_subject s
            JOIN institution i ON i.name = s.institution
            WHERE s.institution = 'mahara' AND s.active = 1";

    if (!$data1 = get_records_sql_array($sql, null)) {
        $data1 = array();
    }

    $data = array_merge($data, $data1);

    usort($data, function ($a, $b) {
        return strcoll($a->name, $b->name);
    });

    foreach ($data as $field) {
        $subjects[$field->id] = $field->name . " ($field->displayname)";
    }

    return $subjects;
}

/**
 * Get descriptor sets for pieform select
 */
function get_descriptorsets() {
    global $addsubject;
    $descriptorsets = array();

    if ($addsubject != 0) {
        $sql = "SELECT d.id, d.name FROM artefact_epos_descriptorset d
                JOIN artefact_epos_descriptorset_subject ds ON ds.descriptorset = d.id
                WHERE ds.subject = ? AND d.active = 1
                ORDER BY name";

        if (!$data = get_records_sql_array($sql, array($addsubject))) {
            $data = array();
        }
        foreach ($data as $field) {
            $descriptorsets[$field->id] = $field->name;
        }
    }
    else {
        $descriptorsets[''] = get_string('pleasechoosesubject', 'artefact.epos');
    }

    return $descriptorsets;
}

/**
 * form validate function
 */
function addlearnedlanguage_validate(Pieform $form, $values) {
    if ($values['title'] == '') {
        $form->set_error('title', get_string('titlenotvalid', 'artefact.epos'));
    }
    if ($values['descriptorset'] == '') {
        $form->set_error('descriptorset', get_string('descriptorsetnotvalid', 'artefact.epos'));
    }
}

/**
 * form submit function
 */
function addlearnedlanguage_submit(Pieform $form, $values) {
    try {
        global $USER, $optionsdescriptors;
        safe_require('artefact', 'epos');
        $owner = $USER->get('id');
        create_subject_for_user($values['subject'], $values['title'], $values['descriptorset'], $optionsdescriptors[$values['descriptorset']], $owner);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('addedlanguage', 'artefact.epos'));
}
