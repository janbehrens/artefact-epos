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
define('TITLE', get_string('deleteevaluation', 'artefact.epos'));
safe_require('artefact', 'epos');

$id = param_integer('id', -1);
$evaluation = artefact_instance_from_id($id);
$evaluation->check_permission();

$question = get_string('confirmdeleteevaluation', 'artefact.epos', '"' . $evaluation->get('title') . '"');
$confirm = ArtefactTypeEvaluation::form_delete_evaluation($id);

$smarty = smarty();
$smarty->assign('PAGEHEADING', get_string('deleteevaluation', 'artefact.epos'));
$smarty->assign('content', "<p>$question</p> $confirm");
$smarty->display('artefact:epos:simple.tpl');
