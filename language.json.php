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
define('JSON', 1);

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

$limit = param_integer('limit', null);
$offset = param_integer('offset', 0);
$type = 'checklist';//param_alpha('type');
$view = param_integer('view', 0);

$owner = $USER->get('id');
$count = 0;

$data = array();

$sql = "SELECT a.id, a.parent, a.title as descriptorset, b.title as language
	FROM artefact a, artefact b
	WHERE a.parent = b.id AND a.owner = ? AND a.artefacttype = ?";

if (!$data = get_records_sql_array($sql, array($owner, $type))) {
    $data = array();
}


// For converting language and descriptorset codes to their respective names...
if ($data) {
    foreach ($data as $field) {
        //$field->language = get_string('language.'.$field->language, 'artefact.epos');
        $field->descriptorset = get_string('descriptorset.'.$field->descriptorset, 'artefact.epos');
    }
}


$count = count($data);

usort($data, 'cmpByTitle');

echo json_encode(array(
    'data' => $data,
    'limit' => $limit,
    'offset' => $offset,
    'count' => $count,
    'type' => $type,
));

?>
