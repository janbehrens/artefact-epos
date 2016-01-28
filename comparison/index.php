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
define('MENUITEM', 'evaluation/selfevaluation');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'comparison'); // this is for help

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/init.php');
define('TITLE', get_string('selfevaluation', 'artefact.epos'));

safe_require('artefact', 'epos');
require_once 'Comparison.php';

$evaluations = isset($_GET['evaluations']) ? $_GET['evaluations'] : null;

if ($evaluations !== null) {
    if (!is_array($evaluations)) {
        throw new ParameterException("Wrong arguments for comparison");
    }
    foreach ($evaluations as $evaluation_id) {
        assert_integer($evaluation_id);
    }
}
else {
    $smarty = smarty();
    $smarty->assign('content', get_string('noevaluationselected', 'artefact.epos'));
    $smarty->display('artefact:epos:simple.tpl');
    exit;
}

$comparison = new Comparison($evaluations);
$comparison->check_permission();

$comparison_of = get_string('comparisonof', 'artefact.epos');
$evaluation_titles = array_map(
    function ($item) {
        return '<strong>"' . $item->get('title') . '"</strong>';
    },
    $comparison->evaluations
);
$last  = array_slice($evaluation_titles, -1);
$first = join(', ', array_slice($evaluation_titles, 0, -1));
$both  = array_filter(array_merge(array($first), $last));
$comparison_of .= ' ' . implode(' ' . get_string('and', 'artefact.epos') . ' ', $both);

$smarty = smarty();
$smarty->assign('PAGEHEADING', get_string('comparison', 'artefact.epos'));
$smarty->assign('comparison_of', $comparison_of);
$smarty->assign('other', $comparison->form_select_other());
$smarty->assign('table', $comparison->render_table());
$smarty->assign('compared', $comparison->get_compared_items());
$smarty->display('artefact:epos:comparison_page.tpl');
