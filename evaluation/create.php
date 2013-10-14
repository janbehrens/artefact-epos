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
define('MENUITEM', 'evaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'selfevaluation');

require_once(dirname(dirname(dirname((dirname(__FILE__))))) . '/init.php');
define('TITLE', get_string('evaluation', 'artefact.epos'));

safe_require('artefact', 'epos');
require_once 'EvaluationRequest.php';

$request_id = param_integer('request');

$request = new EvaluationRequest($request_id);
if ($request->evaluator_id != $USER->get('id')) {
    throw new AccessDeniedException(get_string('youarenottheownerofthisevaluation', 'artefact.epos'));
}
if ($request->evaluation_id) {
    redirect('/artefact/epos/evaluation/evaluate.php?id=' . $request->evaluation_id);
}
db_begin();
$descriptorset = get_record('artefact_epos_descriptorset', 'id', $request->descriptorset_id);
$evaluation = ArtefactTypeEvaluation::create_evaluation_for_user(
        $request->descriptorset_id,
        $descriptorset->name,
        $request->subject_id,
        $request->inquirer_id,
        EVALUATION_ITEM_TYPE_COMPLEVEL);
$evaluation->evaluator = $USER->get('id');
$evaluation->commit();
$request->evaluation_id = $evaluation->get('id');
$request->commit();
db_commit();
redirect('/artefact/epos/evaluation/evaluate.php?id=' . $evaluation->get('id'));