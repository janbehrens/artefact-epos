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
define('MENUITEM', 'selfevaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'selfevaluation');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');
safe_require('artefact', 'epos');

$haslanguages = true;
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$owner = $USER->get('id');

//get user's checklists
$sql = "SELECT a.id, a.parent, a.title as descriptorset, b.title
	FROM artefact a, artefact b
	WHERE a.parent = b.id AND a.owner = ? AND a.artefacttype = ?";

if (!$data = get_records_sql_array($sql, array($owner, 'checklist'))) {
    $data = array();
}

// comparison functions for sql records
function cmpByTitle($a, $b) {
    return strcoll($a->title, $b->title);
}

// generate language links
if ($data) {
    usort($data, 'cmpByTitle');

    // select first language if GET parameter is not set
    if (!isset($_GET['id'])) {
        $id = $data[0]->id;
    }

    $subjectlinks = get_string('languages', 'artefact.epos') . ': ';
    $subjectlinks .= '<form action="" method="GET"><select name="id">';
    foreach ($data as $subject) {
        $selected = '';
        if ($subject->id == $id) {
            $selected = 'selected="selected"';
        }
        $subjectlinks .= "<option value=\"$subject->id\" $selected>$subject->title ($subject->descriptorset)</option>";
    }
    $subjectlinks .= '</select>';
    $subjectlinks .= '<input type="submit" value="Select" />';
    $subjectlinks .= '</form>';
}
else {
    $haslanguages = false;
    $subjectlinks = get_string('nolanguageselected', 'artefact.epos', '<a href=".">' . get_string('mylanguages', 'artefact.epos') . '</a>');
}

if ($haslanguages) {
    $evaluation = new ArtefactTypeChecklist($id);
    $evaluation->check_permission();
    $render = $evaluation->render_evaluation();
    $selfevaluation = $render['html'];
    $includejs = $render['includejs'];
}

$smarty = smarty($includejs);
$smarty->assign('PAGEHEADING', get_string('selfevaluation', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->assign('id', $id);
$smarty->assign('languagelinks', $subjectlinks);
$smarty->assign('haslanguages', $haslanguages);
$smarty->assign('selfevaluation', $selfevaluation);
$smarty->display('artefact:epos:checklist.tpl');
