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
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'identify/evaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');

require_once(dirname(dirname(dirname((dirname(__FILE__))))) . '/init.php');
define('TITLE', get_string('evaluation', 'artefact.epos'));

safe_require('artefact', 'epos');

$id = param_integer('id');

$evaluation = new ArtefactTypeEvaluation($id);
$evaluation->check_permission();
if ($evaluation->get('final')) {
    throw new ParameterException(get_string('evaluationisnoteditable', 'artefact.epos'));
}
$render = $evaluation->render_evaluation();
$selfevaluation = $render['html'];
$includejs = $render['includejs'];
$user = get_user($evaluation->get('owner'));

$smarty = smarty($includejs);
$smarty->assign('PAGEHEADING', $user->firstname . ' ' . $user->lastname . ': ' . $evaluation->display_title());
$smarty->assign('MENUITEM', MENUITEM);
$smarty->assign('id', $id);
$smarty->assign('selfevaluation', $selfevaluation);
$smarty->display('artefact:epos:evaluation-single.tpl');
