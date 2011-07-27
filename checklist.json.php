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

//???
/*if (isset($_POST['view'])) {
    define('PUBLIC', 1);
}*/

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

$limit = param_integer('limit', null);
$offset = param_integer('offset', 0);
//$type = 'checklist';//param_alpha('type');
$view = param_integer('view', 0);

$owner = $USER->get('id');
$id = $_GET['id'];
$count = 0;

$descriptors = array();

$sql = 'SELECT ci.*, d.competence, d.level
    FROM {artefact_epos_descriptor} d 
    JOIN {artefact_epos_checklist_item} ci ON ci.descriptor = d.name
    WHERE ci.checklist = ?';

if (!$descriptors = get_records_sql_array($sql, array($id))) {
    $descriptors = array();
}

// group by competences and levels
$competences = array();
$sendarray = array();

foreach ($descriptors as $desc) {
    if (!array_key_exists($desc->competence, $competences)) {
        $competences[$desc->competence] = array('competence' => $desc->competence,
        					   'competencestr' => get_string($desc->competence, 'artefact.epos'),
                               $desc->level => 0.0,
                               $desc->level . 'max' => 0);
        $count++;
    }
    if (!array_key_exists($desc->level, $competences[$desc->competence])) {
        $competences[$desc->competence][$desc->level] = 0.0;
        $competences[$desc->competence][$desc->level . 'max'] = 0;
    }
    $competences[$desc->competence][$desc->level] += (float)$desc->evaluation;
    $competences[$desc->competence][$desc->level . 'max'] += 2;
}

$competences['final'] = array();
$previous = '';

//calculate percentage
foreach (array_keys($competences) as $c) {
    foreach (array_keys($competences[$c]) as $l) {
        if (array_key_exists($l . 'max', $competences[$c])) {
            $competences[$c][$l] = round(100 * ($competences[$c][$l] / $competences[$c][$l . 'max']));
        }
    }
    $competences[$c]['previous'] = $previous;
    $previous = $c;
    $sendarray[] = $competences[$c];
}

//send
echo json_encode(array(
    'data' => $sendarray,
    'limit' => $limit,
    'offset' => $offset,
    'count' => $count
));

?>
