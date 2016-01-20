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

$owner = $USER->get('id');

$sql = "SELECT DISTINCT evaluation.id, subject.title, s.name as descriptorset
        FROM artefact subject
        INNER JOIN artefact evaluation ON subject.id = evaluation.parent
        LEFT JOIN artefact_epos_evaluation e ON e.artefact = evaluation.id
        LEFT JOIN artefact_epos_descriptorset s ON s.id = e.descriptorset_id
        WHERE evaluation.owner = ?
            AND evaluation.artefacttype = 'evaluation'
            AND e.final = 0
        ORDER BY subject.title";

if (!$data = get_records_sql_array($sql, array($owner))) {
    $data = array();
}

echo json_encode(array(
    'data' => $data,
    'limit' => -1,
    'offset' => 0,
    'count' => count($data)
));

