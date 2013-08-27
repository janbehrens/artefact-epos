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
define('JSON', 1);

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

$limit = param_integer('limit', null);
$offset = param_integer('offset', 0);
$view = param_integer('view', 0);

$owner = $USER->get('id');
$count = 0;

$data = array();

$sql = "SELECT DISTINCT a.id, b.title, s.name as descriptorset FROM artefact b, artefact a
        JOIN artefact_epos_evaluation_item i ON a.id = i.evaluation_id
        JOIN artefact_epos_descriptor d ON d.id = i.descriptor_id
        JOIN artefact_epos_descriptorset s ON s.id = d.descriptorset
        WHERE a.parent = b.id AND a.owner = ? AND a.artefacttype = 'checklist' ORDER BY b.title;";

if (!$data = get_records_sql_array($sql, array($owner))) {
    $data = array();
}

$count = count($data);

echo json_encode(array(
    'data' => $data,
    'limit' => $limit,
    'offset' => $offset,
    'count' => $count,
));

?>
