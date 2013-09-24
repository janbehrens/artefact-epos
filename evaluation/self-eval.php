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
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'evaluation/selfevaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'selfevaluation');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));

safe_require('artefact', 'epos');

$haslanguages = true;

$evaluation_selector = ArtefactTypeChecklist::form_user_evaluation_selector();
if (!$evaluation_selector) {
    $haslanguages = false;
    $subjectlinks = get_string('nolanguageselected', 'artefact.epos', '<a href=".">' . get_string('mylanguages', 'artefact.epos') . '</a>');
}
$id = $evaluation_selector['selected'];

if ($haslanguages) {
    $evaluation = new ArtefactTypeChecklist($id);
    $evaluation->check_permission();
    $render = $evaluation->render_evaluation();
    $selfevaluation = $render['html'];
    $includejs = $render['includejs'];
}

$smarty = smarty($includejs);
$smarty->assign('PAGEHEADING', get_string('selfevaluation', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->assign('id', $id);
$smarty->assign('languagelinks', $evaluation_selector['html']);
$smarty->assign('haslanguages', $haslanguages);
$smarty->assign('selfevaluation', $selfevaluation);
$smarty->display('artefact:epos:checklist.tpl');
