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
    global $USER;
    $keyword = param_variable('keyword', null);

    $sql = 'SELECT institution FROM usr_institution where usr = ?';

    if ($institutions = get_records_sql_array($sql, array((int)$USER->id))) {
        $sql = "SELECT DISTINCT usr.username, usr.firstname, usr.lastname FROM usr
                JOIN usr_institution ui ON ui.usr = usr.id
                WHERE ( ";
        $values = array();
        for ($i = 0; $i < count($institutions); $i++) {
            $sql .= $i == 0 ? "ui.institution = ? " : "OR ui.institution = ? ";
            $values []= $institutions[$i]->institution;
        }
        $sql .= ") AND usr.id <> ? AND (usr.username LIKE ? OR usr.firstname LIKE ? OR usr.lastname LIKE ?) ORDER BY usr.lastname";
        $values []= (int)$USER->id;
        $values []= '%' . $keyword . '%';
        $values []= '%' . $keyword . '%';
        $values []= '%' . $keyword . '%';
        $result = get_records_sql_array($sql, $values);

        $usernames = array();
        $firstnames = array();
        $lastnames = array();
        for($i=0; $i<sizeof($result); $i++) {
            array_push($usernames, $result[$i]->username);
            array_push($firstnames, $result[$i]->firstname);
            array_push($lastnames, $result[$i]->lastname);
        }

        json_reply(false, array('usernames' => $usernames, 'firstnames' => $firstnames, 'lastnames' => $lastnames));
    }
    else {
        json_reply(false, array('status' => 'institutionNull', 'msg' => "You can only search the users of your institution, and you are not in any institution. To enter one, please<br>consult your administrator."));
    }
}