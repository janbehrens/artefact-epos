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
 * @copyright  (C) 2011 TZI / Universität Bremen
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'evaluation/selfevaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'selfevaluation');

require_once(dirname(dirname(dirname((dirname(__FILE__))))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));

safe_require('artefact', 'epos');

$id = param_integer('id', null);

list($selectform, $id) = ArtefactTypeEvaluation::form_user_evaluation_selector($id);

$includejs = array();
$selfevaluation = array();
$customgoalform = null;
$description = null;
if (!$selectform) {
    $selectform = get_string('nolanguageselected', 'artefact.epos', '<a href="../index.php">' . get_string('addremoveevaluations', 'artefact.epos') . '</a>');
}
else {
    $evaluation = new ArtefactTypeEvaluation($id);
    $evaluation->check_permission();
    if ($evaluation->get('final')) {
        throw new ParameterException(get_string('evaluationisnoteditable', 'artefact.epos'));
    }
    $customdescriptor = new CustomDescriptor();
    $customdescriptor->evaluationid = $evaluation->get('id');
    $customgoalform = $customdescriptor->form_add_customgoal();
    $render = $evaluation->render_evaluation();
    $selfevaluation = $render['html'];
    $includejs = $render['includejs'];

    // Get the description imformation of the evaluation
    $sql = "SELECT d.description
                FROM artefact_epos_evaluation e
                JOIN artefact_epos_descriptorset d ON e.descriptorset = d.id
                WHERE e.artefact = ?";

    if (!$data = get_records_sql_array($sql, array($id))) {
        return array(null, false);
    } else {
        $description = $data[0]->description;
    }
}

$smarty = smarty($includejs);
$smarty->assign('PAGEHEADING', get_string('selfevaluation', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->assign('id', $id);
$smarty->assign('selectform', $selectform);
$smarty->assign('selfevaluation', $selfevaluation);
$smarty->assign('customgoalform', $customgoalform);
$smarty->assign('description', $description);
$smarty->display('artefact:epos:evaluation-self.tpl');
