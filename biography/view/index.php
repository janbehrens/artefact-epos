<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
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
 * @subpackage artefact-blog
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2006-2009 Catalyst IT Ltd http://catalyst.net.nz
 *
 */

define('INTERNAL', 1);
define('MENUITEM', 'biography');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'blog');
define('SECTION_PAGE', 'view');

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/init.php');
define('TITLE', get_string('viewblog','artefact.blog'));
safe_require('artefact', 'epos');
require_once(get_config('libroot') . 'pieforms/pieform.php');


$id = param_integer('id', null);
if (is_null($id)) {
    if (!$records = get_records_select_array(
            'artefact',
            "artefacttype = 'biography' AND \"owner\" = ?",
            array($USER->get('id')),
            'id ASC'
        )) {
        throw new ParameterException();
    }
    $id = $records[0]->id;
    $blog = new ArtefactTypeBiography($id, $records[0]);
}
else {
    $blog = new ArtefactTypeBiography($id);
}
$blog->check_permission();

$limit = param_integer('limit', 5);
$offset = param_integer('offset', 0);


$compositetypes = array('educationhistory');
$inlinejs = ArtefactTypeBiography::get_js($compositetypes);
$compositeforms = ArtefactTypeBiography::get_forms($compositetypes);


$smarty = smarty(array('tablerenderer','jquery')); 
$smarty->assign('PAGEHEADING', $blog->get('title'));
$smarty->assign('INLINEJAVASCRIPT', $inlinejs);
$smarty->assign('controls', TRUE);
$smarty->assign('compositeforms', $compositeforms);

$smarty->assign_by_ref('blog', $blog);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:biographyview.tpl');

