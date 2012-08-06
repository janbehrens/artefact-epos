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

//read files
if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false) {
        if (substr($file, 0, 1) != '.') {
            $xmlcontents = file_get_contents($dir . $file);
            $xmlarr = xmlize($xmlcontents);
            
            $data[] = array(
                    'name' => $xmlarr['DESCRIPTORSET']['@']['NAME'],
                    'file' => $file,
            );
        }
    }
    closedir($dh);
}

$institution = $_GET['institution'];
$subject = $_GET['subject'];

//read DB
$sql = 'SELECT d.id, d.name FROM artefact_epos_descriptor_set d
        JOIN artefact_epos_descriptorset_subject ds ON d.id = ds.descriptorset
        JOIN artefact_epos_subject s ON s.id = ds.subject
        JOIN institution i ON i.name = s.institution
        WHERE i.name = ? AND s.id = ?';
if (!$dbdata = get_records_sql_array($sql, array($institution, $subject))) {
    $dbdata = array();
}

for ($i = 0; $i < count($data); $i++) {
    $installed = false;
    for ($j = 0; $j < count($dbdata); $j++) {
        if ($dbdata[$j]->name == $data[$i]['name']) {
            $dbdata[$j]->installed = 'installed';
            $installed = true;
        }
    }
    if (!$installed) {
        $dbdata[] = (object) array(
                'name' => $data[$i]['name'],
                'file' => $data[$i]['file'],
                'installed' => 'not installed'
        );
    }
}

usort($dbdata, function ($a, $b) {
    return strcoll($a->name, $b->name);
});

echo json_encode(array(
    'data' => $dbdata,
    'count' => count($dbdata)
));

?>
