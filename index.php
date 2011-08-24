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
define('MENUITEM', 'goals/mylanguages');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'index');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('mylanguages', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');


$addstr = get_string('add', 'artefact.epos');
$cancelstr = get_string('cancel', 'artefact.epos');
$delstr = get_string('del', 'artefact.epos');
$editstr = get_string('edit', 'artefact.epos');
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
            return TD(null, r.language);
        },
        function (r, d) {
            return TD(null, r.descriptorset);
        },
        function (r, d) {
            var link = A({'class': 'icon btn-del s', 'href': ''}, '{$delstr}');
            connect(link, 'onclick', function (e) {
                e.stop();
                return deleteLanguage(r.id);
            });
            return TD(null, A({'class': 'icon btn-edit s', 'href': 'checklist.php?id=' + r.id}, '{$editstr}'), link);
        },
    ]
);

tableRenderer.type = 'learnedlanguage';
tableRenderer.statevars.push('type');
tableRenderer.emptycontent = '';
tableRenderer.updateOnLoad();
EOF;

//pieform
$optionslanguage = get_learnedlanguages();
$optionsdescriptors = get_descriptors();

$elements = array(
    'language' => array(
        'type' => 'select',
        'title' => get_string('language', 'mahara'),
        'options' => $optionslanguage,
    ),
    'descriptorset' => array(
        'type' => 'select',
        'title' => get_string('descriptors', 'artefact.epos'),
        'options' => $optionsdescriptors,
    ),
);
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
    'successcallback' => 'form_submit',
    'jssuccesscallback' => 'languageSaveCallback',
));


$smarty = smarty(array('tablerenderer'));

$smarty->assign('languageform', $languageform);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:index.tpl');

/**
 * Get language options for pieform select
 */
function get_learnedlanguages() {
    static $languages;
    if (!empty($languages)) {
        return $languages;
    }
    $codes = array('ar', 'ca', 'de', 'en', 'eo', 'es', 'fi', 'fr', 'he', 'hu', 'it', 'ja', 'la', 'nl', 'pl', 'pt', 'ru', 'sv', 'tr', 'zh');

    foreach ($codes as $c) {
        $languages[$c] = get_string("language.{$c}", 'artefact.epos');
    };
    uasort($languages, 'strcoll');
    return $languages;
}

/**
 * Get descriptor sets for pieform select
 */
function get_descriptors() {
    static $descriptors;
    if (!empty($descriptors)) {
        return $descriptors;
    }
    $codes = array('cercles', 'elc', 'schule');

    foreach ($codes as $c) {
        $descriptors[$c] = get_string("descriptorset.{$c}", 'artefact.epos');
    };
    uasort($descriptors, 'strcoll');
    return $descriptors;
}

/**
 * form submit function
 */
function form_submit(Pieform $form, $values) {
    try {
        process_languageform($form, $values);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('addedlanguage', 'artefact.epos'));
}

function process_languageform(Pieform $form, $values) {
    global $USER;
    $owner = $USER->get('id');
    
    // update artefact 'learnedlanguage' ...
    $sql = 'SELECT * FROM {artefact} WHERE owner = ? AND artefacttype = ? AND title = ?';
    if ($langs = get_records_sql_array($sql, array($owner, 'learnedlanguage', $values['language']))) {
        $a = artefact_instance_from_id($langs[0]->id);
        $a->set('mtime', time());
        $a->commit();
    }
    // ... or create it if it doesn't exist
    else {
        safe_require('artefact', 'epos');
        $a = new ArtefactTypeLearnedLanguage(0, array(
                'owner' => $owner,
                'title' => $values['language'],
            )
        );
    }
    $a->commit();

    $values['artefact'] = $a->get('id');
    
    // update artefact_epos_descriptor if descriptors are not in database yet
    $sql = 'SELECT *
        FROM {artefact_epos_descriptor}
        WHERE descriptorset = ?';
    
    if (!get_records_sql_array($sql, array($values['descriptorset']))) {
        write_descriptor_db('db/' . $values['descriptorset'] . '.xml');
    }

    // update artefact_epos_checklist if checklist not in database yet
    $sql = 'SELECT c.*
        FROM {artefact_epos_checklist} c
        JOIN {artefact} a ON c.learnedlanguage = a.id
        WHERE learnedlanguage = ? AND descriptorset = ?';
    
    if (!get_records_sql_array($sql, array($values['artefact'], $values['descriptorset']))) {
        $values['learnedlanguage'] = $values['artefact'];
        
        // insert into checklist, returns id
        $values['checklist'] = insert_record('artefact_epos_checklist', (object)$values, 'id', true);
        
        // load descriptors
        $descriptors = array();
        
        $sql = 'SELECT * FROM {artefact_epos_descriptor} WHERE descriptorset = ?';
        
        if (!$descriptors = get_records_sql_array($sql, array($values['descriptorset']))) {
            $descriptors = array();
        }
        
        $values['evaluation'] = 0;
        $values['goal'] = 0;
        
        // update artefact_epos_checklist_item
        foreach ($descriptors as $field) {
            $values['descriptor'] = $field->name;
            insert_record('artefact_epos_checklist_item', (object)$values);
        }
    }
}

?>
