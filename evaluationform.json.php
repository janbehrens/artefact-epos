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
 * @author     Jan Behrens, Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

$addsubject = param_integer('subject_id', null);

$descriptorsets = array();

$data = array();
if ($addsubject != null) {
    $sql = "SELECT d.id, d.name FROM artefact_epos_descriptorset d
            JOIN artefact_epos_descriptorset_subject ds ON ds.descriptorset = d.id
            WHERE ds.subject = ? AND d.active = 1
            ORDER BY name";

    if (!$data = get_records_sql_array($sql, array($addsubject))) {
        $data = array();
    }
    foreach ($data as $field) {
        $descriptorsets[$field->id] = $field->name;
    }
}
else {
    $descriptorsets[''] = get_string('pleasechoosesubject', 'artefact.epos');
}

echo json_encode($descriptorsets);

