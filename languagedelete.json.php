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
require_once(get_config('docroot') . 'artefact/lib.php');

$id = param_integer('checklist_id');

//get artefact id
if ($data = get_records_array('artefact_epos_checklist', 'id', $id)) {
    $lang = $data[0]->learnedlanguage;
}

$a = artefact_instance_from_id($lang);

if ($a->get('owner') != $USER->get('id')) {
    throw new AccessDeniedException(get_string('notartefactowner', 'error'));
}

//delete checklist_item items
delete_records('artefact_epos_checklist_item', 'checklist', $id);

//delete checklist items
delete_records('artefact_epos_checklist', 'id', $id);

//delete artefact if there is no checklist left
$count = count_records('artefact_epos_checklist', 'learnedlanguage', $lang);
if (empty($count)) {
    $a->delete();
}
else {
    $a->set('mtime', time());
    $a->commit();
}

//reply
json_reply(null, get_string('deletedlanguage', 'artefact.epos'));

?>
