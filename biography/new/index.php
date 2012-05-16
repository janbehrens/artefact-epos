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
 * @subpackage artefact-internal
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2006-2009 Catalyst IT Ltd http://catalyst.net.nz
 *
 */

define('INTERNAL', 1);
define('MENUITEM', 'biography');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'epos');

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/init.php');
define('TITLE', get_string('newbiography','artefact.epos') . ': ' . get_string('biographysettings','artefact.epos'));
require_once('pieforms/pieform.php');
safe_require('artefact', 'epos');

$form = pieform(array(
    'name' => 'newblog',
    'method' => 'post',
    'action' => '',
    'plugintype' => 'artefact',
    'pluginname' => 'blog',
    'elements' => array(
        'title' => array(
            'type'        => 'text',
            'title'       => get_string('biographytitle', 'artefact.epos'),
            'description' => get_string('biographytitledesc', 'artefact.epos'),
            'rules' => array(
                'required'    => true
            ),
        ),
        'description' => array(
            'type'        => 'wysiwyg',
            'rows'        => 10,
            'cols'        => 70,
            'title'       => get_string('biographydesc', 'artefact.epos'),
            'description' => get_string('biographydescdesc', 'artefact.epos'),
            'rules' => array(
                'maxlength'   => 65536,
                'required'    => false
            ),
        ),
        'tags'        => array(
            'type'        => 'tags',
            'title'       => get_string('tags'),
            'description' => get_string('tagsdescprofile'),
            'help'        => true,
        ),
        'submit' => array(
            'type'  => 'submitcancel',
            'value' => array(
                get_string('createbiography', 'artefact.epos'),
                get_string('cancel', 'artefact.epos')
            )
        )
    )
));

$smarty =& smarty();
$smarty->assign_by_ref('form', $form);
$smarty->assign('PAGEHEADING', TITLE);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('form.tpl');
exit;

/**
 * This function gets called to submit the new blog.
 *
 * @param array
 */
function newblog_submit(Pieform $form, $values) {
    global $USER;

    ArtefactTypeBiography::new_blog($USER, $values);
    redirect('/artefact/epos/biography/');
}

/**
 * This function gets called to cancel a submission.
 */
function newblog_cancel_submit() {
    redirect('/artefact/epos/biography/');
}
