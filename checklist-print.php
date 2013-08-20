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
 * @author     Tim Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 Tim Mundt, mundt@tzi.de
 *
 */

define('INTERNAL', true);

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');
safe_require('artefact', 'epos');

$owner = $USER->get('id');

//get user's checklists
$sql = "SELECT a.id, a.parent, a.title as descriptorset, b.title
    FROM artefact a, artefact b
    WHERE a.parent = b.id AND a.owner = ? AND a.artefacttype = ?";
$params = array($owner, 'checklist');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $a = new ArtefactTypeChecklist($id);
    if (!$USER->can_view_artefact($a)) {
        throw new AccessDeniedException(get_string('notownerofchecklist', 'artefact.epos'));
    }
    $sql .= " AND a.id = ?";
    $params []= $id;
}
if (!$checklists = get_records_sql_array($sql, $params)) {
    throw new NotFoundException(get_string('nochecklistsforuser', 'artefact.epos'));
}
// select first checklist if id is not given
if (!isset($id)) {
    $id = $checklists[0]->id;
    $a = new ArtefactTypeChecklist($id);
}

$descriptorset = $a->get_descriptorset();

$smarty = smarty();
$smarty->assign('results', $a->results());
$smarty->assign('levels', $descriptorset->levels);
$smarty->assign('evaluations', $evaluations);
$smarty->assign('subject', $a->get_parent_instance()->get_name());
$smarty->assign('PAGEHEADING', get_string('selfevaluationprintout', 'artefact.epos'));
$smarty->display('artefact:epos:checklist-print.tpl');