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
 * @copyright  (C) 2012 Jan Behrens, jb3@informatik.uni-bremen.de
 *
 */

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
safe_require('artefact', 'epos');

$id = param_variable('id');

/*$sql = 'SELECT id FROM artefact_epos_descriptor
        WHERE descriptorset = ?';
$data = get_records_sql_array($sql, array($id));

foreach ($data as $field) {
    execute_sql("UPDATE artefact_epos_checklist_item
            SET descriptor = 0 WHERE descriptor = $field->id");
}*/

try {
    delete_records('artefact_epos_descriptor', 'descriptorset', $id);
    delete_records('artefact_epos_descriptorset_subject', 'descriptorset', $id);
    delete_records('artefact_epos_descriptor_set', 'id', $id);

    //reply
    json_reply(false, get_string('unloaddescriptorsetsuccess', 'artefact.epos'));
}
catch (Exception $e) {
    //reply
    json_reply(true, get_string('unloaddescriptorsetfailed', 'artefact.epos'));
}


?>
