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

require(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
safe_require('artefact', 'epos');

$data = array();

$dataroot = realpath(get_config('dataroot'));
$dir = $dataroot . '/artefact/epos/descriptorsets/';

$institution = $_GET['institution'];
$subject = $_GET['subject'];

//read DB
$sql = 'SELECT d.* FROM artefact_epos_descriptor_set d
        JOIN artefact_epos_descriptorset_subject ds ON d.id = ds.descriptorset
        JOIN artefact_epos_subject s ON s.id = ds.subject
        JOIN institution i ON i.name = s.institution
        WHERE i.name = ? AND s.id = ? AND d.visible = 1';
if (!$dbdata = get_records_sql_array($sql, array($institution, $subject))) {
    $dbdata = array();
}

usort($dbdata, function ($a, $b) {
    return strcoll($a->name, $b->name);
});

echo json_encode(array(
    'data' => $dbdata,
    'count' => count($dbdata)
));

?>
