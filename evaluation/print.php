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

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');

$id = param_integer('id');

$evaluation = artefact_instance_from_id($id);
$evaluation->check_permission();

$descriptorset = $evaluation->get_descriptorset();
$ratings = array_values(array_map(function($item) {
    return $item->name;
}, $descriptorset->ratings));

$smarty = smarty();
$smarty->assign('title', $evaluation->display_title());
$smarty->assign('results', $evaluation->get_results());
$smarty->assign('levels', $evaluation->get_levels());
$smarty->assign('ratings', $ratings);
$smarty->assign('PAGEHEADING', get_string('selfevaluationprintout', 'artefact.epos'));
$smarty->display('artefact:epos:evaluation-print.tpl');
