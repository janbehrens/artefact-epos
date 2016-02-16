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
 * @author     Björn Mellies, Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
//require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'epos');

$id = param_integer('customgoal_id');

$customdescriptor = new CustomDescriptor($id);
$evaluation = artefact_instance_from_id($customdescriptor->evaluationid);
$evaluation->check_permission();

try {
    $customdescriptor->delete();
    json_reply(false, get_string('customlearninggoaldeleted', 'artefact.epos'));
}
catch (Exception $e) {
    json_reply(true, $e->getMessage());
}
