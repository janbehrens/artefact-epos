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
define('MENUITEM', 'diary');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');
define('SECTION_PAGE', 'diary');

require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('artefact', 'epos');

define('TITLE', get_string('blogs','artefact.epos'));

if ($delete = param_integer('delete', 0)) {
    ArtefactTypeDiary::delete_form($delete);
}

$blogs = (object) array(
    'offset' => param_integer('offset', 0),
    'limit'  => param_integer('limit', 10),
);

list($blogs->count, $blogs->data) = ArtefactTypeDiary::get_blog_list($blogs->limit, $blogs->offset);

ArtefactTypeDiary::build_blog_list_html($blogs);

$smarty = smarty(array('paginator'));
$smarty->assign_by_ref('blogs', $blogs);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('INLINEJAVASCRIPT', 'addLoadEvent(function() {' . $blogs->pagination_js . '});');
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:diary.tpl');

function delete_blog_submit(Pieform $form, $values) {
    global $SESSION;
    $blog = new ArtefactTypeDiary($values['delete']);
    $blog->check_permission();
    if ($blog->get('locked')) {
        $SESSION->add_error_msg(get_string('submittedforassessment', 'view'));
    }
    else {
        $blog->delete();
        $SESSION->add_ok_msg(get_string('blogdeleted', 'artefact.epos'));
    }
    redirect('/artefact/epos/diary.php');
}
