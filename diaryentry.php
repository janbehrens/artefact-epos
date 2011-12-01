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
require_once('pieforms/pieform.php');

safe_require('artefact', 'epos');
safe_require('artefact', 'file');

/* 
 * For a new post, the 'blog' parameter will be set to the blog's
 * artefact id.  For an existing post, the 'blogpost' parameter will
 * be set to the blogpost's artefact id.
 */
$blogpost = param_integer('blogpost', param_integer('id', 0));
if (!$blogpost) {
    $blog = param_integer('blog');
    if (!get_record('artefact', 'id', $blog, 'owner', $USER->get('id'))) {
        // Blog security is also checked closer to when blogs are added, this 
        // check ensures that malicious users do not even see the screen for 
        // adding a post to a blog that is not theirs
        throw new AccessDeniedException(get_string('youarenottheownerofthisblog', 'artefact.epos'));
    }
    $title = '';
    $description = '';
    $tags = array();
    $checked = '';
    $pagetitle = get_string('newblogpost', 'artefact.epos', get_field('artefact', 'title', 'id', $blog));
    $focuselement = 'title';
    $attachments = array();
    define('TITLE', $pagetitle);
}
else {
    $blogpostobj = new ArtefactTypeDiaryEntry($blogpost);
    $blogpostobj->check_permission();
    if ($blogpostobj->get('locked')) {
        throw new AccessDeniedException(get_string('submittedforassessment', 'view'));
    }
    $blog = $blogpostobj->get('parent');
    $title = $blogpostobj->get('title');
    $description = $blogpostobj->get('description');
    $tags = $blogpostobj->get('tags');
    $checked = !$blogpostobj->get('published');
    $pagetitle = get_string('editblogpost', 'artefact.epos');
    $focuselement = 'description'; // Doesn't seem to work with tinyMCE.
    $attachments = $blogpostobj->attachment_id_list();
    define('TITLE', get_string('editblogpost','artefact.epos'));
}

$folder = param_integer('folder', 0);
$browse = (int) param_variable('browse', 0);
$highlight = null;
if ($file = param_integer('file', 0)) {
    $highlight = array($file);
}


$form = pieform(array(
    'name'               => 'editpost',
    'method'             => 'post',
    'autofocus'          => $focuselement,
    'jsform'             => true,
    'newiframeonsubmit'  => true,
    'jssuccesscallback'  => 'editpost_callback',
    'jserrorcallback'    => 'editpost_callback',
    'plugintype'         => 'artefact',
    'pluginname'         => 'epos',
    'configdirs'         => array(get_config('libroot') . 'form/', get_config('docroot') . 'artefact/file/form/'),
    'elements' => array(
        'blog' => array(
            'type' => 'hidden',
            'value' => $blog,
        ),
        'blogpost' => array(
            'type' => 'hidden',
            'value' => $blogpost,
        ),
        'title' => array(
            'type' => 'text',
            'title' => get_string('posttitle', 'artefact.epos'),
            'rules' => array(
                'required' => true
            ),
            'defaultvalue' => $title,
        ),
        'description' => array(
            'type' => 'textarea',       //FIXME wysiwyg broken
            'rows' => 20,
            'cols' => 70,
            'title' => get_string('postbody', 'artefact.epos'),
            'description' => get_string('postbodydesc', 'artefact.epos'),
            'rules' => array(
                'maxlength' => 65536,
                'required' => true
            ),
            'defaultvalue' => $description,
        ),
        'tags'       => array(
            'defaultvalue' => $tags,
            'type'         => 'tags',
            'title'        => get_string('tags'),
            'description'  => get_string('tagsdesc'),
            'help' => true,
        ),
        'filebrowser' => array(
            'type'         => 'filebrowser',
            'title'        => get_string('attachments', 'artefact.epos'),
            'folder'       => $folder,
            'highlight'    => $highlight,
            'browse'       => $browse,
            'page'         => get_config('wwwroot') . 'artefact/epos/diaryentry.php?' . ($blogpost ? ('id=' . $blogpost) : ('blog=' . $blog)) . '&browse=1',
            'browsehelp'   => 'browsemyfiles',
            'config'       => array(
                'upload'          => true,
                'uploadagreement' => get_config_plugin('artefact', 'file', 'uploadagreement'),
                'createfolder'    => false,
                'edit'            => false,
                'select'          => true,
            ),
            'defaultvalue'       => $attachments,
            'selectlistcallback' => 'artefact_get_records_by_id',
            'selectcallback'     => 'add_attachment',
            'unselectcallback'   => 'delete_attachment',
        ),
        'draft' => array(
            'type' => 'checkbox',
            'title' => get_string('draft', 'artefact.epos'),
            'description' => get_string('thisisdraftdesc', 'artefact.epos'),
            'defaultvalue' => $checked,
            'help' => true,
        ),
        'allowcomments' => array(
            'type'         => 'checkbox',
            'title'        => get_string('allowcomments','artefact.comment'),
            'description'  => get_string('allowcommentsonpost','artefact.epos'),
            'defaultvalue' => $blogpost ? $blogpostobj->get('allowcomments') : 1,
        ),
        'submitpost' => array(
            'type' => 'submitcancel',
            'value' => array(get_string('savepost', 'artefact.epos'), get_string('cancel')),
            'goto' => get_config('wwwroot') . 'artefact/epos/diaryview.php?id=' . $blog,
        )
    )
));


/*
 * Javascript specific to this page.  Creates the list of files
 * attached to the blog post.
 */
$wwwroot = get_config('wwwroot');
$noimagesmessage = json_encode(get_string('noimageshavebeenattachedtothispost', 'artefact.epos'));
$javascript = <<<EOF



// Override the image button on the tinyMCE editor.  Rather than the
// normal image popup, open up a modified popup which allows the user
// to select an image from the list of image files attached to the
// post.

// Get all the files in the attached files list that have been
// recognised as images.  This function is called by the the popup
// window, but needs access to the attachment list on this page
function attachedImageList() {
    var images = [];
    var attachments = editpost_filebrowser.selecteddata;
    for (var a in attachments) {
        if (attachments[a].artefacttype == 'image') {
            images.push({
                'id': attachments[a].id,
                'name': attachments[a].title,
                'description': attachments[a].description ? attachments[a].description : ''
            });
        }
    }
    return images;
}


function imageSrcFromId(imageid) {
    return config.wwwroot + 'artefact/file/download.php?file=' + imageid;
}

function imageIdFromSrc(src) {
    var artefactstring = 'download.php?file=';
    var ind = src.indexOf(artefactstring);
    if (ind != -1) {
        return src.substring(ind+artefactstring.length, src.length);
    }
    return '';
}

var imageList = {};

function blogpostImageWindow(ui, v) {
    var t = tinyMCE.activeEditor;

    imageList = attachedImageList();

    var template = new Array();

    template['file'] = '{$wwwroot}artefact/blog/image_popup.php';
    template['width'] = 355;
    template['height'] = 275 + (tinyMCE.isMSIE ? 25 : 0);

    // Language specific width and height addons
    template['width'] += t.getLang('lang_insert_image_delta_width', 0);
    template['height'] += t.getLang('lang_insert_image_delta_height', 0);
    template['inline'] = true;

    t.windowManager.open(template);
}

function editpost_callback(form, data) {
    editpost_filebrowser.callback(form, data);
};

EOF;

$smarty = smarty(array(), array(), array(), array(
    'tinymcesetup' => "ed.addCommand('mceImage', blogpostImageWindow);",
    'sideblocks' => array(
        array(
            'name'   => 'quota',
            'weight' => -10,
            'data'   => array(),
        ),
    ),
));
$smarty->assign('INLINEJAVASCRIPT', $javascript);
$smarty->assign_by_ref('form', $form);
$smarty->assign('PAGEHEADING', $pagetitle);
$smarty->assign('MENUITEM', MENUITEM);
$smarty->display('artefact:epos:editdiaryentry.tpl');



/** 
 * This function get called to cancel the form submission. It returns to the
 * blog list.
 */
function editpost_cancel_submit() {
    global $blog;
    redirect(get_config('wwwroot') . 'artefact/epos/diaryview.php?id=' . $blog);
}

function editpost_submit(Pieform $form, $values) {
    global $USER, $SESSION, $blogpost, $blog;

    db_begin();
    $postobj = new ArtefactTypeDiaryEntry($blogpost, null);
    $postobj->set('title', $values['title']);
    $postobj->set('description', $values['description']);
    $postobj->set('tags', $values['tags']);
    $postobj->set('published', !$values['draft']);
    $postobj->set('allowcomments', (int) $values['allowcomments']);
    if (!$blogpost) {
        $postobj->set('parent', $blog);
        $postobj->set('owner', $USER->id);
    }
    $postobj->commit();
    $blogpost = $postobj->get('id');

    // Attachments
    $old = $postobj->attachment_id_list();
    // $new = is_array($values['filebrowser']['selected']) ? $values['filebrowser']['selected'] : array();
    $new = is_array($values['filebrowser']) ? $values['filebrowser'] : array();
    if (!empty($new) || !empty($old)) {
        foreach ($old as $o) {
            if (!in_array($o, $new)) {
                try {
                    $postobj->detach($o);
                }
                catch (ArtefactNotFoundException $e) {}
            }
        }
        foreach ($new as $n) {
            if (!in_array($n, $old)) {
                try {
                    $postobj->attach($n);
                }
                catch (ArtefactNotFoundException $e) {}
            }
        }
    }
    db_commit();

    $result = array(
        'error'   => false,
        'message' => get_string('blogpostsaved', 'artefact.epos'),
        'goto'    => get_config('wwwroot') . 'artefact/epos/viewdiary.php?id=' . $blog,
    );
    if ($form->submitted_by_js()) {
        // Redirect back to the blog page from within the iframe
        $SESSION->add_ok_msg($result['message']);
        $form->json_reply(PIEFORM_OK, $result, false);
    }
    $form->reply(PIEFORM_OK, $result);
}

function add_attachment($attachmentid) {
    global $blogpostobj;
    if ($blogpostobj) {
        $blogpostobj->attach($attachmentid);
    }
}

function delete_attachment($attachmentid) {
    global $blogpostobj;
    if ($blogpostobj) {
        $blogpostobj->detach($attachmentid);
    }
}
