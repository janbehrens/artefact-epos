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
define('MENUITEM', 'goals/goals');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'goals');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('goals', 'artefact.epos'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');
safe_require('artefact', 'internal');
safe_require('artefact', 'epos');

$id = param_integer('id', null);
list($selectform, $id) = ArtefactTypeEvaluation::form_user_evaluation_selector($id);

$editbuttonurl = $THEME->get_url('images/btn_edit.png');
$deletebuttonurl = $THEME->get_url('images/btn_deleteremove.png');

$inlinejs = array();
if (!$selectform) {
    $selectform = get_string('nolanguageselected', 'artefact.epos', '<a href=".">' . get_string('myselfevaluations', 'artefact.epos') . '</a>');
}
else {
    $evaluation = new ArtefactTypeEvaluation($id);
    $evaluation->check_permission();

    $textSaveCustomgoalchanges = get_string('save', 'artefact.epos');
    $textCancelCustomgoalchanges = get_string('cancel', 'artefact.epos');
    $reallyDeleteCustomGoal = get_string('customlearninggoalwanttodelete', 'artefact.epos');

    $editCustomgoal = get_string('edit', 'mahara');
    $deleteCustomgoal = get_string('delete', 'mahara');

    $inlinejs = <<<EOF

tableRenderer = new TableRenderer(
    'goals_table',
    'goals.json.php?id={$id}',
    [
        function (r, d) {
            var data = $('<td />');
            if(r.descriptor == null && r.description != null) {
                data.append($('<div />', {
                    class: 'customgoalText',
                    id: 'custom_' + r.id,
                    text: r.description
                }));
            } else {
                data.text(r.descriptor_name);
            }
            return data;            
        },
        function (r, d) {
            var level = '';
            var competence = '';
            if (r.competence) {
                competence = r.competence_name;
            }
            if (r.level) {
                level = ' – ' + r.level_name;
            }
            return $('<td />', { text: competence + ' ' + level });            
        },
        function (r, d) {
            var data = document.createElement('td');
            if(r.description != null) {
                data.innerHTML = '<div style="width:48px;"><a href="javascript: onClick=editCustomGoal('+r.id+');" title="$editCustomgoal"><img src="$editbuttonurl" alt="$editCustomgoal"></a><a href="javascript: deleteCustomGoal('+r.id+');" title="$deleteCustomgoal"><img src="$deletebuttonurl" alt="$deleteCustomgoal"></a></div>';
            }
            return data;
        },
    ]
);

tableRenderer.type = 'goals';
tableRenderer.statevars.push('type');
tableRenderer.emptycontent = '';
tableRenderer.paginate = false;
tableRenderer.updateOnLoad();
EOF;
}

$smarty = smarty(array('tablerenderer',
                       'artefact/epos/js/customgoals.js'));

$smarty->assign('haslanguages', $id !== false);
$smarty->assign('selectform', $selectform);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('goals', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:goals.tpl');
