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
    $a = artefact_instance_from_id($id);
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
    $a = artefact_instance_from_id($id);
}

$sql = 'SELECT * FROM artefact_epos_descriptor d
        JOIN artefact_epos_checklist_item ci ON ci.descriptor = d.id
        WHERE ci.checklist = ?
        ORDER BY d.level, d.competence';
if (!$descriptors = get_records_sql_array($sql, array($id))) {
    $descriptors = array();
}

function increase_array_value(&$data, $key, $value=1) {
    if (!array_key_exists($key, $data)) {
        $data[$key] = $value;
    }
    else {
        $data[$key] += $value;
    }
}

// group by competences and levels
$competences = array();
$levels = array();
$evaluations = array();
$count = 0;

foreach ($descriptors as $descriptor) {
    if (!array_key_exists($descriptor->competence, $competences)) {
        $competences[$descriptor->competence] = array(
                'name' => $descriptor->competence,
                'index' => $count,
                'levels' => array()
        );
        $count++;
    }
    if (!array_key_exists($descriptor->level, $competences[$descriptor->competence]['levels'])) {
        $competences[$descriptor->competence]['levels'][$descriptor->level] = array(
                'val' => 0.0,
                'max' => 0,
                'descriptors' => array(),
                'evaluation_sums' => array()
        );
    }
    if (!in_array($descriptor->level, $levels)) {
        $levels []= $descriptor->level;
    }
    $descriptor->evaluations = explode('; ', $descriptor->evaluations);
    $evaluations = array_replace($evaluations, $descriptor->evaluations);
    $comp_level = &$competences[$descriptor->competence]['levels'][$descriptor->level];
    $comp_level['val'] += (float)$descriptor->evaluation;
    $comp_level['max'] += count($descriptor->evaluations) - 1;
    $comp_level['descriptors'] []= $descriptor;
    increase_array_value($comp_level['evaluation_sums'], $descriptor->evaluation);
}

//calculate percentage
foreach ($competences as $c) {
    foreach (array_keys($c) as $l) {
        if (is_array($c[$l])) {
            $c[$l]['val'] = round(100 * $c[$l]['val'] / $c[$l]['max']);

        }
    }
}

//print_r($competences); exit;


$smarty = smarty();
$smarty->assign('competences', $competences);
$smarty->assign('levels', $levels);
$smarty->assign('evaluations', array_flip($evaluations));
$smarty->assign('subject', $a->get_parent_instance()->get_name());
$smarty->assign('PAGEHEADING', get_string('selfevaluationprintout', 'artefact.epos'));
$smarty->display('artefact:epos:checklist-print.tpl');