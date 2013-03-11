<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
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
 * @author     Catalyst IT Ltd, Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2006-2009 Catalyst IT Ltd http://catalyst.net.nz
 *                 2012-2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', 1);
define('JSON', 1);

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/init.php');
safe_require('artefact', 'resume');

$id = param_integer('id');
$limit = param_integer('limit', null);
$offset = param_integer('offset', 0);
$type = param_alpha('type');

$data = array();
$count = 0;

$othertable = 'artefact_epos_biography_' . $type;

$owner = $USER->get('id');

$sql = 'SELECT ar.*, a.owner
    FROM {artefact} a 
    JOIN {' . $othertable . '} ar ON ar.artefact = a.id
    WHERE a.owner = ? AND a.id = ?
    ORDER BY ar.displayorder';

if (!$data = get_records_sql_array($sql, array($owner, $id))) {
    $data = array();
}

$count = count($data);

json_reply(false, array(
    'data' => $data,
    'limit' => $limit,
    'offset' => $offset,
    'count' => $count,
    'type' => $type,
));
