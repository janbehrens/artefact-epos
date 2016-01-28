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
define('MENUITEM', 'evaluation/external');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');

require_once(dirname(dirname(dirname((dirname(__FILE__))))) . '/init.php');
define('TITLE', get_string('returnexternalevaluation', 'artefact.epos'));

safe_require('artefact', 'epos');
require_once 'EvaluationRequest.php';

$id = param_integer('id');
$request = new EvaluationRequest($id);

$return_evaluation_request_form = EvaluationRequest::form_return_evaluation_request($request);
$user = get_user($request->inquirer);

$smarty = smarty();
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->assign('return_evaluation_request_form', $return_evaluation_request_form);
$smarty->assign('title', $user->firstname . ' ' . $user->lastname . ': ' . $request->title);
$smarty->display('artefact:epos:evaluation-return-external.tpl');
