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

define('INTERNAL', 1);
define('JSON', 1);    //comment to debug

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

$limit = param_integer('limit', null);
$offset = param_integer('offset', 0);
$view = param_integer('view', 0);

$id = $_GET['id'];

$data = array();

// load all descriptors of a subject's evaluation that are marked as goal
$sql = 'SELECT d.name as descriptor, c.name AS competence, l.name AS level
	FROM artefact evaluation
    JOIN artefact_epos_evaluation_item ei ON ei.evaluation_id = evaluation.id
    JOIN artefact_epos_descriptor d ON d.id = ei.descriptor_id
	LEFT JOIN artefact_epos_competence c ON c.id = d.competence_id
    LEFT JOIN artefact_epos_level l ON l.id = d.level_id
    WHERE evaluation.id = ? AND ei.goal = 1
    ORDER BY competence, level, d.id';

if (!$data = get_records_sql_array($sql, array($id))) {
    $data = array();
}

// collect custom goals for certain language
$data_custom_goal = array();
$cast = "";
if (is_postgres()) {
    $cast = "::integer";
}
$sql = "SELECT goal.id, goal.description, competence.title AS competence
		FROM artefact goal
        LEFT JOIN artefact_epos_evaluation_item ei ON ei.target_key$cast = goal.id
        LEFT JOIN artefact competence ON goal.parent = competence.id
        LEFT JOIN artefact evaluation ON competence.parent = evaluation.id
		WHERE goal.artefacttype = 'customgoal' AND ei.goal = 1
        AND evaluation.id = ? AND ei.type = ?";

if (!$data_custom_goal = get_records_sql_array($sql, array($id, EVALUATION_ITEM_TYPE_CUSTOM_GOAL))) {
	$data_custom_goal = array();
	error_log("id=$id");
}

$data = array_merge($data, $data_custom_goal);

echo json_encode(array(
    'data' => $data,
    'limit' => $limit,
    'offset' => $offset,
    'count' => count($data),
));
