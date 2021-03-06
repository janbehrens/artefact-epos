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
 * @author     Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'evaluation/stored');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
define('TITLE', get_string('storedevaluations', 'artefact.epos'));
safe_require('artefact', 'epos');

$evaluation_id = param_integer('id', -1);

if ($evaluation_id != -1) {
    $evaluation = new ArtefactTypeEvaluation($evaluation_id);
    $evaluation->check_permission();
    $subject = $evaluation->get_parent_instance();
}
else {
    $evaluations = ArtefactTypeEvaluation::get_all_stored_evaluation_records();
    $by_subject_and_descriptorset = array();
    foreach ($evaluations as $evaluation) {
        if (!$evaluation->final) {
            $evaluation->title = '(' . get_string('current', 'artefact.epos') . ')';
            $evaluation->url = get_config('wwwroot') . 'artefact/epos/evaluation/self-eval.php?id=' . $evaluation->id;
        }
        else {
            $evaluation->url = get_config('wwwroot') . 'artefact/epos/evaluation/stored.php?id=' . $evaluation->id;
            $evaluation->url = get_config('wwwroot') . 'artefact/epos/evaluation/display.php?id=' . $evaluation->id;
        }
        /*if ($evaluation->evaluator == $USER->get('id')) {
            $evaluation->firstname = get_string('yourself', 'artefact.epos');
            $evaluation->lastname = "";
        }*/
        $by_subject_and_descriptorset[$evaluation->subject][$evaluation->descriptorset_id]['evaluations'] []= $evaluation;
        $by_subject_and_descriptorset[$evaluation->subject][$evaluation->descriptorset_id]['name'] = $evaluation->descriptorset;
    }
}

$heading = get_string('storedevaluations', 'artefact.epos');

$smarty = smarty();
$smarty->assign('PAGEHEADING', $heading);
$smarty->assign('subjects', $by_subject_and_descriptorset);
$smarty->display('artefact:epos:stored-evaluations.tpl');
