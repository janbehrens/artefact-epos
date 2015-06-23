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
 * @author     Zhuli Li
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2015 TZI / Universität Bremen
 *
 */
define('INTERNAL', true);
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $subjectID = param_variable('subjectID', null);

    $sql = 'SELECT a.title, d.id FROM artefact a JOIN artefact_epos_descriptorset d ON d.name = a.title WHERE a.artefacttype = ? AND parent = ?';
    $result = get_records_sql_array($sql, array('evaluation', $subjectID));

    $descriptorSetIDs = array();
    $descriptorSets = array();
    for($i=0; $i<sizeof($result); $i++) {
        array_push($descriptorSetIDs, $result[$i]->id);
        array_push($descriptorSets, $result[$i]->title);
    }
    json_reply(false, array('descriptorSetIDs' => $descriptorSetIDs, 'descriptorSets' => $descriptorSets));
}