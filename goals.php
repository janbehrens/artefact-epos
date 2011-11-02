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
 * @copyright  (C) 2011 Jan Behrens, jb3@informatik.uni-bremen.de
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


// load language data
$haslanguages = true;

$owner = $USER->get('id');

//get user's languages
$sql = 'SELECT id, title
    FROM artefact 
    WHERE owner = ? and artefacttype = ?';

if (!$data = get_records_sql_array($sql, array($owner, 'learnedlanguage'))) {
    $data = array();
}

// generate language links
if ($data) {
    usort($data, 'cmpByTitle');

    // select first language if GET parameter is not set
    if (!isset($_GET['id'])) {
        $_GET['id'] = $data[0]->id;
    }

    $languagelinks = '<p>' . get_string('subjects', 'artefact.epos') . ': ';

    foreach ($data as $field) {
        if ($field->id == $_GET['id']) {
            $languagelinks .= '<b>';
        }
        else {
            $languagelinks .= '<a href="goals.php?id=' . $field->id . '">';
        }
        $languagelinks .= $field->title;
        if ($field->id == $_GET['id']) {
            $languagelinks .= '</b> | ';
        }
        else {
            $languagelinks .= '</a> | ';
        }
    }
    $languagelinks .= '<a href="index.php">' . get_string('edit', 'artefact.epos') . '</a></p>';
}
else {
    $haslanguages = false;
    $languagelinks = get_string('nolanguageselected1', 'artefact.epos') . '<a href="index.php">' . get_string('mylanguages', 'artefact.epos') . '</a>' . get_string('nolanguageselected2', 'artefact.epos');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
else $id = 0;


$inlinejs = <<<EOF
tableRenderer = new TableRenderer(
    'goals_table',
    'goals.json.php?id={$id}',
    [
        function (r, d) {
            return TD(null, r.descriptor);
        },
        function (r, d) {
            return TD(null, r.competence + ' ' + r.level);
        },
        function (r, d) {
        	return TD(null, r.descriptorset);
        },
    ]
);

tableRenderer.type = 'goals';
tableRenderer.statevars.push('type');
tableRenderer.emptycontent = '';
tableRenderer.paginate = false;
tableRenderer.updateOnLoad();
EOF;


$smarty = smarty(array('tablerenderer'));

$smarty->assign('haslanguages', $haslanguages);
$smarty->assign('languagelinks', $languagelinks);
//$smarty->assign('tables', $tables);
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('PAGEHEADING', get_string('goals', 'artefact.epos'));
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:goals.tpl');

?>
