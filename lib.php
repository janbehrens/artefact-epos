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
 u*
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

defined('INTERNAL') || die();

include_once('xmlize.php');

/**
 * PluginArtefactEpos implementing PluginArtefact
 */
class PluginArtefactEpos extends PluginArtefact {

    public static function get_artefact_types() {
        return array('learnedlanguage', 'checklist', 'customgoal', 'biography');
    }

    public static function get_block_types() {
        return array();
    }

    public static function get_plugin_name() {
        return 'epos';
    }

    public static function menu_items() {
        return array(
            array(
                'path' => 'goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 31,
            ),
            array(
                'path' => 'goals/mylanguages',
                'title' => get_string('mylanguages', 'artefact.epos'),
                'url' => 'artefact/epos/',
                'weight' => 60,
            ),
            array(
                'path' => 'goals/goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 28,
            ),
            array(
                'path' => 'selfevaluation',
                'title' => get_string('selfevaluation', 'artefact.epos'),
                'url' => 'artefact/epos/checklist.php',
                'weight' => 32,
            ),
            array(
                'path' => 'dossier',
                'title' => get_string('dossier', 'artefact.epos'),
                'url' => 'artefact/file/',
                'weight' => 34,
            ),
            /*array(
                'path' => 'diary',
                'title' => get_string('diary', 'artefact.epos'),
                'url' => 'artefact/blog',
                'weight' => 36,
            ),*/
            array(
                'path' => 'biography',
                'title' => get_string('biography', 'artefact.epos'),
                'url' => 'artefact/epos/biography',
                'weight' => 38,
            ),
            /*array(
                'path' => 'biography/resume',
                'title' => get_string('biography', 'artefact.epos'),
                'url' => 'artefact/resume/',
                'weight' => 10,
            ),
            array(
                'path' => 'biography/myexperience',
                'title' => get_string('myexperience', 'artefact.epos'),
                'url' => 'artefact/epos/experience.php',
                'weight' => 38,
            )*/
        );
    }
}

/**
 * ArtefactTypeLearnedLanguage implementing ArtefactType
 */
class ArtefactTypeLearnedLanguage extends ArtefactType {

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}
}

/**
 * ArtefactTypeChecklist implementing ArtefactType
 */
class ArtefactTypeChecklist extends ArtefactType {
    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}
    
    public $set;
    
    /**
     * Overriding the constructor in order to read the descriptors from the database
     * @param unknown_type $id
     * @param unknown_type $data
     */
    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);

        $this->set = $this->load_descriptorset();
    }
    
    public function render_self($options, $blockid = 0) {
        $this->add_to_render_path($options);

        $inlinejs = $this->returnJS(false, $blockid);
        
        //if this is used in a block, we use the block instance id, artefact id otherwise
        if($blockid == 0) $blockid = $this->id;

        $smarty = smarty_core();

        $smarty->assign('id', $blockid);
        $smarty->assign('levels', $this->set);
        $smarty->assign('JAVASCRIPT', $inlinejs);
        
        return array('html' => $smarty->fetch('artefact:epos:viewchecklist.tpl'), 'javascript' => '');
    }
	
    /**
     * This function builds the artefact title from language and checklist information
     * @see ArtefactType::display_title()
     */
    public function display_title() {
        $language = get_field('artefact', 'title', 'id', $this->parent);
        return $language . ' (' . get_string('descriptorset.' . $this->title, 'artefact.epos') . ')';
    }
    
    /**
     * Returns the JS used to build the checklist table
     * @param unknown_type $editable	whether this is used in the checklist page (editing support) or in a view
     * @param unknown_type $blockid
     * @return string
     */
    public function returnJS($editable, $blockid = 0) {
        $jsonpath = get_config('wwwroot') . 'artefact/epos/checklist.json.php?id=' . $this->id;

        //if this is used in a block, we use the block instance id, artefact id otherwise
        if($blockid == 0) $blockid = $this->id;
        
        $inlinejs = '
(function($){$.fn.checklist=function(){

var prevValue = {};';

        if(isset($blockid)) {
            $inlinejs .= <<<EOF

tableRenderer{$blockid} = new TableRenderer(
    'checklist{$blockid}',
EOF;
        }
        else {
            $inlinejs .= <<<EOF

tableRenderer{$this->id} = new TableRenderer(
    'checklist{$this->id}',
EOF;
        }
        
        $inlinejs .= <<<EOF

    '{$jsonpath}',
    [
        function (r, d) {
            return TD(null, r.competencestr);
        },
EOF;
    
        foreach (array_keys($this->set) as $competence) {
            foreach (array_keys($this->set[$competence]) as $level) {
                $inlinejs .= <<<EOF

        function (r) {
EOF;
                if ($editable) {
                    $inlinejs .= <<<EOF

            var str1 = 'toggleLanguageForm("' + r.competence + '", "$level")';
EOF;
                }
                else {
                    $inlinejs .= <<<EOF

            var str1 = '';
EOF;
                }
                
                $inlinejs .= <<<EOF

            var str2 = 'progressbar_' + r.competence + "_$level";
            var str3 = '#progressbar_' + r.previous + "_$level";
            var data = TD({'onclick': str1});
            data.innerHTML = '<div id="' + str2 + '"></div>';
            if (prevValue.hasOwnProperty("$level")) {
                $(str3).progressbar({ value: prevValue["$level"] });
            }
            prevValue["$level"] = r.$level;
            return data;
        },
EOF;
            }
            break;  //we need the column definitions only once
        }
    
        $inlinejs .= <<<EOF
    ]
);

tableRenderer{$blockid}.type = 'checklist';
tableRenderer{$blockid}.statevars.push('type');
tableRenderer{$blockid}.emptycontent = '';
tableRenderer{$blockid}.updateOnLoad();

$('#checklistnotvisible{$blockid}').addClass('hidden');};

$().checklist();})(jQuery);

EOF;
        return $inlinejs;
    }
    
    
    /**
     * load_descriptorset()
     * 
     * will return something like
     *     array(
     *         'listening' => array(
     *             'a1' => array(
     *                 0 => 'cercles_li_a1_1',
     *                 1 => 'cercles_li_a1_2',
     *                 etc.
     *             ),
     *             'a2' => array(
     *                 ...
     *             ),
     *             etc.
     *         ),
     *         'reading' => array(
     *             ...
     *         ),
     *         etc.
     *     )
     */
    function load_descriptorset() {
        $sql = 'SELECT d.*
            FROM artefact_epos_descriptor d
            JOIN artefact a ON a.title = d.descriptorset
            WHERE a.id = ?';
        
        if (!$descriptors = get_records_sql_array($sql, array($this->id))) {
            $descriptors = array();
        }
        
        $competences = array();
        
        // group them by competences and levels:
        foreach ($descriptors as $desc) {
            if (!isset($competences[$desc->competence])) {
                $competences[$desc->competence] = array();
            }
            if (!isset($competences[$desc->competence][$desc->level])) {
                $competences[$desc->competence][$desc->level] = array();
            }
            $competences[$desc->competence][$desc->level][] = $desc->name;
        }
        return $competences;
    }
    
    /**
     * load_checklist()
     * 
     * will return something like
     *     array(
     *         'evaluation' => array(
     *             'cercles_li_a1_1' => 0,
     *             'cercles_li_a1_2' => 2,
     *             etc.
     *         ),
     *         'goal' => array(
     *             'cercles_li_a1_1' => 0,
     *             'cercles_li_a1_2' => 1,
     *             etc.
     *         )
     *     )
     */
    function load_checklist() {
        $sql = 'SELECT *
            FROM artefact_epos_checklist_item
            WHERE checklist = ?';
        
        if (!$data = get_records_sql_array($sql, array($this->id))) {
            $data = array();
        }
        
        $evaluation = array();
        $goal = array();
        
        foreach ($data as $field) {
            $evaluation[$field->descriptor] = $field->evaluation;
            $goal[$field->descriptor] = $field->goal;
        }
        
        return array('evaluation' => $evaluation, 'goal' => $goal);
    }
    
    /**
     * Overriding the delete() function to clear the checklist table
     */
    public function delete() {
        delete_records('artefact_epos_checklist_item', 'checklist', $this->id);

        parent::delete();
    }
}

/**
* ArtefactTypeCustomGoal implementing ArtefactType
*/
class ArtefactTypeCustomGoal extends ArtefactType {

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}
}

/**
* ArtefactTypeBiography implementing ArtefactType - most parts copied from blog and resume artefacts
*/
class ArtefactTypeBiography extends ArtefactType {

    /**
     * This constant gives the per-page pagination for listing blogs.
     */
    const pagination = 10;

    /**
     * We override the constructor to fetch the extra data.
     *
     * @param integer
     * @param object
     */
    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);

        if (empty($this->id)) {
            $this->container = 1;
        }
    }

    /**
     * This function updates or inserts the artefact.  This involves putting
     * some data in the artefact table (handled by parent::commit()), and then
     * some data in the artefact_blog_blog table.
     */
    public function commit() {
        // Just forget the whole thing when we're clean.
        if (empty($this->dirty)) {
            return;
        }
      
        // We need to keep track of newness before and after.
        $new = empty($this->id);
        
        // Commit to the artefact table.
        parent::commit();

        $this->dirty = false;
    }

    /**
     * This function extends ArtefactType::delete() by deleting blog-specific
     * data.
     */
    public function delete() {
        if (empty($this->id)) {
            return;
        }

        $table = $this->get_other_table_name();
        db_begin();
        delete_records($table, 'artefact', $this->id);
        db_commit();

        // Delete the artefact and all children.
        parent::delete();
    }

    /**
     * Checks that the person viewing this blog is the owner. If not, throws an 
     * AccessDeniedException. Used in the blog section to ensure only the 
     * owners of the blogs can view or change them there. Other people see 
     * blogs when they are placed in views.
     */
    public function check_permission() {
        global $USER;
        if ($USER->get('id') != $this->owner) {
            throw new AccessDeniedException(get_string('youarenottheownerofthisblog', 'artefact.blog'));
        }
    }


    public function describe_size() {
        return $this->count_children() . ' ' . get_string('posts', 'artefact.blog');
    }

    /**
     * Renders a blog.
     *
     * @param  array  Options for rendering
     * @return array  A two key array, 'html' and 'javascript'.
     */
    public function render_self($options) {
        $this->add_to_render_path($options);

        if (!isset($options['limit'])) {
            $limit = self::pagination;
        }
        else if ($options['limit'] === false) {
            $limit = null;
        }
        else {
            $limit = (int) $options['limit'];
        }
        $offset = isset($options['offset']) ? intval($options['offset']) : 0;

        if (!isset($options['countcomments'])) {
            // Count comments if this is a view
            $options['countcomments'] = (!empty($options['viewid']));
        }

        $posts = ArtefactTypeBlogpost::get_posts($this->id, $limit, $offset, $options);

        $template = 'artefact:blog:viewposts.tpl';

        $baseurl = get_config('wwwroot') . 'view/artefact.php?artefact=' . $this->id;
        if (!empty($options['viewid'])) {
            $baseurl .= '&view=' . $options['viewid'];
        }
        $pagination = array(
            'baseurl' => $baseurl,
            'id' => 'blogpost_pagination',
            'datatable' => 'postlist',
            'jsonscript' => 'artefact/blog/posts.json.php',
        );

        ArtefactTypeBlogpost::render_posts($posts, $template, $options, $pagination);

        $smarty = smarty_core();
        if (isset($options['viewid'])) {
            $smarty->assign('artefacttitle', '<a href="' . get_config('wwwroot') . 'view/artefact.php?artefact='
                                             . $this->get('id') . '&view=' . $options['viewid']
                                             . '">' . hsc($this->get('title')) . '</a>');
        }
        else {
            $smarty->assign('artefacttitle', hsc($this->get('title')));
        }

        $options['hidetitle'] = true;
        $smarty->assign('options', $options);
        $smarty->assign('description', $this->get('description'));
        $smarty->assign('owner', $this->get('owner'));
        $smarty->assign('tags', $this->get('tags'));

        $smarty->assign_by_ref('posts', $posts);

        return array('html' => $smarty->fetch('artefact:blog:blog.tpl'), 'javascript' => '');
    }

                
    public static function get_icon($options=null) {
        global $THEME;
        return $THEME->get_url('images/blog.gif', false, 'artefact/blog');
    }

    public static function is_singular() {
        return false;
    }

    public static function collapse_config() {
    }

    /**
     * This function returns a list of the given user's blogs.
     *
     * @param User
     * @return array (count: integer, data: array)
     */
    public static function get_blog_list($limit, $offset) {
        global $USER;
        ($result = get_records_sql_array("
         SELECT b.id, b.title, b.description, b.locked
         FROM {artefact} b
         WHERE b.owner = ? AND b.artefacttype = 'biography'
         GROUP BY b.id, b.title, b.description, b.locked
         ORDER BY b.title", array($USER->get('id')), $offset, $limit))
            || ($result = array());

        foreach ($result as &$r) {
            if (!$r->locked) {
                $r->deleteform = ArtefactTypeBiography::delete_form($r->id);
            }
        }

        $count = (int)get_field('artefact', 'COUNT(*)', 'owner', $USER->get('id'), 'artefacttype', 'biography');

        return array($count, $result);
    }

    public static function build_blog_list_html(&$blogs) {
        $smarty = smarty_core();
        $smarty->assign_by_ref('blogs', $blogs);
        $blogs->tablerows = $smarty->fetch('artefact:epos:biographylist.tpl');
        $pagination = build_pagination(array(
            'id' => 'bloglist_pagination',
            'class' => 'center',
            'url' => get_config('wwwroot') . 'artefact/epos/biography/index.php',
            'jsonscript' => 'artefact/epos/biography/index.json.php',
            'datatable' => 'bloglist',
            'count' => $blogs->count,
            'limit' => $blogs->limit,
            'offset' => $blogs->offset,
            'firsttext' => '',
            'previoustext' => '',
            'nexttext' => '',
            'lasttext' => '',
            'numbersincludefirstlast' => false,
            'resultcounttextsingular' => get_string('blog', 'artefact.blog'),
            'resultcounttextplural' => get_string('blogs', 'artefact.blog'),
        ));
        $blogs->pagination = $pagination['html'];
        $blogs->pagination_js = $pagination['javascript'];
    }

    /**
     * This function creates a new blog.
     *
     * @param User
     * @param array
     */
    public static function new_blog(User $user, array $values) {
        $artefact = new ArtefactTypeBiography();
        $artefact->set('title', $values['title']);
        $artefact->set('description', $values['description']);
        $artefact->set('owner', $user->get('id'));
        $artefact->set('tags', $values['tags']);
        $artefact->commit();
    }

    /**
     * This function updates an existing blog.
     *
     * @param User
     * @param array
     */
    public static function edit_blog(User $user, array $values) {
        if (empty($values['id']) || !is_numeric($values['id'])) {
            return;
        }

        $artefact = new ArtefactTypeBiography($values['id']);
        if ($user->get('id') != $artefact->get('owner')) {
            return;
        }
        
        $artefact->set('title', $values['title']);
        $artefact->set('description', $values['description']);
        $artefact->set('tags', $values['tags']);
        $artefact->commit();
    }

    public static function get_links($id) {
        $wwwroot = get_config('wwwroot');

        return array(
            '_default'                                  => $wwwroot . 'artefact/epos/biography/view/?id=' . $id,
            get_string('blogsettings', 'artefact.blog') => $wwwroot . 'artefact/epos/biography/settings/?id=' . $id,
        );
    }

    /*public function copy_extra($new) {
        $new->set('title', get_string('Copyof', 'mahara', $this->get('title')));
    }*/

    /**
     * Returns the number of posts in this blog that have been published.
     *
     * The result of this function looked up from the database each time, so 
     * cache it if you know it's safe to do so.
     *
     * @return int
     */
    /*public function count_published_posts() {
        return (int)get_field_sql("
            SELECT COUNT(*)
            FROM {artefact} a
            LEFT JOIN {artefact_blog_blogpost} bp ON a.id = bp.blogpost
            WHERE a.parent = ?
            AND bp.published = 1", array($this->get('id')));
    }*/

    public static function delete_form($id) {
        global $THEME;
        return pieform(array(
            'name' => 'delete_' . $id,
            'successcallback' => 'delete_blog_submit',
            'renderer' => 'oneline',
            'elements' => array(
                'delete' => array(
                    'type' => 'hidden',
                    'value' => $id,
                ),
                'submit' => array(
                    'type' => 'image',
                    'src' => $THEME->get_url('images/icon_close.gif'),
                    'elementtitle' => get_string('delete', 'artefact.blog'),
                    'confirm' => get_string('deleteblog?', 'artefact.blog'),
                ),
            ),
        ));
    }
    
    //////     resume stuff     ///////
    
    public static function get_composite_artefact_types() {
        return array(
            'educationhistory'
        );
    }

    /**
    * This function processes the form for the composite
    * @throws Exception
    */
    public static function process_compositeform(Pieform $form, $values) {
        if (!isset($values['artefact'])) {
            $values['artefact'] = $_GET['id'];
        }

        $table = 'artefact_epos_biography_' . $values['compositetype'];
        if (!empty($values['id'])) {
            update_record($table, (object)$values, 'id');
        }
        else {
            if (isset($values['displayorder'])) {
                $values['displayorder'] = intval($values['displayorder']);
            }
            else {
                $max = get_field($table, 'MAX(displayorder)', 'artefact', $values['artefact']);
                $values['displayorder'] = is_numeric($max) ? $max + 1 : 0;
            }
            insert_record($table, (object)$values);
        }
    }

    /**
    * Takes a pieform that's been set up by all the 
    * subclass get_addform_elements functions
    * and puts the default values in (and hidden id field)
    * ready to be an edit form
    * 
    * @param $form pieform structure (before calling pieform() on it
    * passed by _reference_
    */
    public static function populate_form(&$form, $id, $type) {
        if (!$composite = get_record('artefact_epos_biography_' . $type, 'id', $id)) {
            throw new InvalidArgumentException("Couldn't find composite of type $type with id $id");
        }
        $datetypes = array('date', 'startdate', 'enddate');
        foreach ($form['elements'] as $k => $element) {
            if ($k == 'submit' || $k == 'compositetype') {
                continue;
            }
            if (isset($composite->{$k})) {
                $form['elements'][$k]['defaultvalue'] = $composite->{$k};
            }
        }
        $form['elements']['id'] = array(
            'type' => 'hidden',
            'value' => $id,
        );
        $form['elements']['artefact'] = array(
            'type' => 'hidden',
            'value' => $composite->artefact,
        );
    }

    /** 
    * returns the name of the supporting table
    */
    public function get_other_table_name() {
        return 'artefact_epos_biography_educationhistory';// . $this->get_artefact_type();
    }

    public static function get_js(array $compositetypes) {
        $js = self::get_common_js();
        foreach ($compositetypes as $compositetype) {
            $js .= self::get_artefacttype_js($compositetype);
        }
        return $js;
    }

    public static function get_common_js() {
        $cancelstr = get_string('cancel');
        $addstr = get_string('add');
        $confirmdelstr = get_string('compositedeleteconfirm', 'artefact.resume');
        $js = <<<EOF
var tableRenderers = {};

function toggleCompositeForm(type) {
    var elemName = '';
    elemName = type + 'form';
    if (hasElementClass(elemName, 'hidden')) {
        removeElementClass(elemName, 'hidden');
        $('add' + type + 'button').innerHTML = '{$cancelstr}';
    }
    else {
        $('add' + type + 'button').innerHTML = '{$addstr}';
        addElementClass(elemName, 'hidden');
    }
}

function compositeSaveCallback(form, data) {
    key = form.id.substr(3);
    tableRenderers[key].doupdate(); 
    toggleCompositeForm(key);
    // Can't reset() the form here, because its values are what were just submitted, 
    // thanks to pieforms
    forEach(form.elements, function(element) {
        if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) {
            element.value = '';
        }
    });
}

function deleteComposite(type, id, artefact) {
    if (confirm('{$confirmdelstr}')) {
        sendjsonrequest('compositedelete.json.php',
            {'id': id, 'artefact': artefact},
            'GET',
            function(data) {
                tableRenderers[type].doupdate();
            },
            function() {
                // @todo error
            }
        );
    }
    return false;
}

function moveComposite(type, id, artefact, direction) {
    sendjsonrequest('biographymove.json.php',
        {'id': id, 'artefact': artefact, 'direction':direction},
        'GET',
        function(data) {
            tableRenderers[type].doupdate();
        },
        function() {
            // @todo error
        }
    );
    return false;
}
EOF;
        $js .= self::get_showhide_composite_js();
        return $js;
    }

    static function get_tablerenderer_title_js($titlestring, $bodystring) {
        return "
                function (r, d) {
                    if (!{$bodystring}) {
                        return TD(null, {$titlestring});
                    }
                    var link = A({'href': ''}, {$titlestring});
                    connect(link, 'onclick', function (e) {
                        e.stop();
                        return showhideComposite(r, {$bodystring});
                    });
                    return TD({'id': 'composite-' + r.artefact + '-' + r.id}, link);
                },
                ";
    }

    static function get_showhide_composite_js() {
        return "
            function showhideComposite(r, content) {
                // get the reference for the title we just clicked on
                var titleTD = $('composite-' + r.artefact + '-' + r.id);
                var theRow = titleTD.parentNode;
                var bodyRow = $('composite-body-' + r.artefact +  '-' + r.id);
                if (bodyRow) {
                    if (hasElementClass(bodyRow, 'hidden')) {
                        removeElementClass(bodyRow, 'hidden');
                    }
                    else {
                        addElementClass(bodyRow, 'hidden');
                    }
                    return false;
                }
                // we have to actually create the dom node too
                var colspan = theRow.childNodes.length;
                var newRow = TR({'id': 'composite-body-' + r.artefact + '-' + r.id}, 
                    TD({'colspan': colspan}, content)); 
                insertSiblingNodesAfter(theRow, newRow);
            }
        ";
    }

    static function get_artefacttype_js($compositetype) {
        global $THEME;
        $editstr = get_string('edit');
        $delstr = get_string('delete');
        $imagemoveblockup   = json_encode($THEME->get_url('images/move-up.gif'));
        $imagemoveblockdown = json_encode($THEME->get_url('images/move-down.gif'));
        $upstr = get_string('moveup', 'artefact.resume');
        $downstr = get_string('movedown', 'artefact.resume');

        $js = self::get_composite_js();

        $js .= <<<EOF
tableRenderers.{$compositetype} = new TableRenderer(
    '{$compositetype}list',
    'composite.json.php',
    [
EOF;

        $js .= <<<EOF

        function (r, d) {
            var buttons = [];
            if (r._rownumber > 1) {
                var up = A({'href': ''}, IMG({'src': {$imagemoveblockup}, 'alt':'{$upstr}'}));
                connect(up, 'onclick', function (e) {
                    e.stop();
                    return moveComposite(d.type, r.id, r.artefact, 'up');
                });
                buttons.push(up);
            }
            if (!r._last) {
                var down = A({'href': '', 'class':'movedown'}, IMG({'src': {$imagemoveblockdown}, 'alt':'{$downstr}'}));
                connect(down, 'onclick', function (e) {
                    e.stop();
                    return moveComposite(d.type, r.id, r.artefact, 'down');
                });
                buttons.push(' ');
                buttons.push(down);
            }
            return TD({'class':'movebuttons'}, buttons);
        },
EOF;

        $js .= self::get_tablerenderer_js();

        $js .= <<<EOF
        function (r, d) {
            var editlink = A({'href': '../edit.php?id=' + r.id + '&artefact=' + r.artefact, 'title': '{$editstr}'}, IMG({'src': config.theme['images/edit.gif'], 'alt':'{$editstr}'}));
            var dellink = A({'href': '', 'title': '{$delstr}'}, IMG({'src': config.theme['images/icon_close.gif'], 'alt': '[x]'}));
            connect(dellink, 'onclick', function (e) {
                e.stop();
                return deleteComposite(d.type, r.id, r.artefact);
            });
            return TD({'class':'right'}, null, editlink, ' ', dellink);
        }
    ]
);

tableRenderers.{$compositetype}.type = '{$compositetype}';
tableRenderers.{$compositetype}.statevars.push('type');
tableRenderers.{$compositetype}.emptycontent = '';
tableRenderers.{$compositetype}.updateOnLoad();

EOF;
        return $js;
    }

    static function get_forms(array $compositetypes) {
        require_once(get_config('libroot') . 'pieforms/pieform.php');
        $compositeforms = array();
        foreach ($compositetypes as $compositetype) {
            $elements = self::get_addform_elements();
            $elements['submit'] = array(
                'type' => 'submit',
                'value' => get_string('save'),
            );
            $elements['compositetype'] = array(
                'type' => 'hidden',
                'value' => $compositetype,
            );
            $cform = array(
                'name' => 'add' . $compositetype,
                'plugintype' => 'artefact',
                'pluginname' => 'resume',
                'elements' => $elements,
                'jsform' => true,
                'successcallback' => 'biographyform_submit',
                'jssuccesscallback' => 'compositeSaveCallback',
            );
            $compositeforms[$compositetype] = pieform($cform);
        }
        return $compositeforms;
    }

    protected $startdate;
    protected $enddate;
    protected $level;
    protected $place;

    public static function get_tablerenderer_js() {

        return "
                'startdate',
                'enddate',
                " . self::get_tablerenderer_title_js(
                    self::get_tablerenderer_title_js_string(),
                    self::get_tablerenderer_body_js_string()
                ) . "
        ";
    }

    public static function get_tablerenderer_title_js_string() {
        return " formatQualification(r.name, r.level, r.place)";
    }

    public static function format_render_self_data($data) {
        $at = get_string('at');
        foreach ($data as &$row) {
            $row->qualification = '';
            if (strlen($row->name) && strlen($row->level)) {
                $row->qualification = $row->name. ' (' . $row->level . ') ' . $at . ' ';
            }
            else if (strlen($row->level)) {
                $row->qualification = $row->level . ' ' . $at . ' ';
            }
            else if (strlen($row->name)) {
                $row->qualification = $row->name . ' ' . $at . ' ';
            }
            $row->qualification .= $row->place;
        }
        return $data;
    }

    public static function get_tablerenderer_body_js_string() {
        return " r.description"; 
    }

    public static function get_addform_elements() {
        return array(
            'name' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('name', 'artefact.resume'),
                'size' => 50,
            ),
            'startdate' => array(
                'type' => 'text',
                'rules' => array(
                    'required' => true,
                ),
                'title' => get_string('startdate', 'artefact.resume'),
                'size' => 20,
                'help' => true,
            ),
            'enddate' => array(
                'type' => 'text', 
                'title' => get_string('enddate', 'artefact.resume'),
                'size' => 20,
            ),
            'place' => array(
                'type' => 'text',
                'title' => get_string('place', 'artefact.resume'),
                'size' => 50,
            ),
            'subject' => array(
                'type' => 'text',
                'title' => get_string('subject', 'artefact.resume'),
                'size' => 50,
            ),
            'level' => array(
                'type' => 'text',
                'title' => get_string('level', 'artefact.resume'),
                'size' => 50,
            ),
            'description' => array(
                'type' => 'textarea',
                'rows' => 10,
                'cols' => 50,
                'resizable' => false,
                'title' => get_string('description', 'artefact.resume'),
            ),
        );
    }

    static function get_composite_js() {
        $at = get_string('at');
        return <<<EOF
function formatQualification(name, level, place) {
    var qual = '';
    if (name && level) {
        qual = name + ' (' + level + ') {$at} ';
    }
    else if (level) {
        qual = type + ' {$at} ';
    }
    else if (name) {
        qual = name + ' {$at} ';
    }
    qual += place;
    return qual;
}
EOF;
    }

    /*public static function bulk_delete($artefactids) {
        ArtefactTypeResumeComposite::bulk_delete_composite($artefactids, 'educationhistory');
    }*/
}


//write descriptors from xml into database
function write_descriptor_db($xml) {
    if (file_exists($xml) && is_readable($xml)) {
        $contents = file_get_contents($xml);
        $xmlarr = xmlize($contents);
        
        $table = 'artefact_epos_descriptor';
        
        $descriptorset = $xmlarr['XML']['#']['DESCRIPTORSET']['0'];
        $values['descriptorset'] = $descriptorset['@']['NAME'] . '.' . $descriptorset['@']['LANGUAGE'];
        
        foreach ($xmlarr['XML']['#']['DESCRIPTORSET']['0']['#']['DESCRIPTOR'] as $x) {
            $values['competence'] = $x['@']['COMPETENCE'];
            $values['level']      = $x['@']['LEVEL'];
            $values['name']       = $x['@']['NAME'];
            
            insert_record($table, (object)$values);
            echo $values['name'];
        }
        return true;
    }
    return false;
}

// comparison functions for sql records
function cmpByTitle($a, $b) {
    return strcoll($a->title, $b->title);
}

function cmpByCompetenceAndLevel($a, $b) {
    $cmp = strcoll($a->competence, $b->competence);
    return $cmp == 0 ? strcoll($a->level, $b->level) : $cmp;
}

function cmpByLevel($a, $b) {
    return ;
}

function biographyform_submit(Pieform $form, $values) {
    try {
        ArtefactTypeBiography::process_compositeform($form, $values);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('compositesaved', 'artefact.resume'));
}

function biographyformedit_submit(Pieform $form, $values) {
    global $SESSION;

    $goto = get_config('wwwroot') . 'artefact/epos/biography/view/?id=' . $values['artefact'];

    try {
        ArtefactTypeBiography::process_compositeform($form, $values);
    }
    catch (Exception $e) {
        $SESSION->add_error_msg(get_string('compositesavefailed', 'artefact.resume'));
        redirect($goto);
    }
    $SESSION->add_ok_msg(get_string('compositesaved', 'artefact.resume'));
    redirect($goto);
}

?>
