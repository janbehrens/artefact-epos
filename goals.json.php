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

define('INTERNAL', 1);
define('JSON', 1);    //comment to debug

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

//non-debug
$limit = param_integer('limit', null);
$offset = param_integer('offset', 0);
$type = param_alpha('type');
$view = param_integer('view', 0);

$owner = $USER->get('id');
$id = $_GET['id'];

//debug
// $type = 'debug';
// $id = 408;


$data = array();

$sql = 'SELECT c.descriptorset, ci.descriptor, d.level, d.competence
	FROM artefact a
    JOIN {artefact_epos_checklist} c ON c.learnedlanguage = a.id
    JOIN {artefact_epos_checklist_item} ci ON ci.checklist = c.id
    JOIN {artefact_epos_descriptor} d ON d.name = ci.descriptor
    WHERE a.id = ? AND ci.goal = ?';

if (!$data = get_records_sql_array($sql, array($id, 1))) {
    $data = array();
}

//substitute strings
if ($data) {
    foreach ($data as $field) {
        $field->descriptor = get_string($field->descriptor, 'artefact.epos');
        $field->descriptorset = get_string('descriptorset.' . $field->descriptorset, 'artefact.epos');
        $field->competence = get_string($field->competence, 'artefact.epos');
        $field->level = get_string($field->level, 'artefact.epos');
    }
}


$count = count($data);

usort($data, 'cmpByCompetenceAndLevel');

echo json_encode(array(
    'data' => $data,
    'limit' => $limit,
    'offset' => $offset,
    'count' => $count,
    'type' => $type,
));

?>