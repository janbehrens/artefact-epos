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
 * @author     Jan Behrens, Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

defined('INTERNAL') || die();

include_once('xmlize.php');

/**
 * PluginArtefactEpos implementing PluginArtefact
 */
class PluginArtefactEpos extends PluginArtefact {

    public static function get_artefact_types() {
        return array('subject', 'checklist', 'customgoal', 'biography');
    }

    public static function get_block_types() {
        return array('checklist', 'goals');
    }

    public static function get_plugin_name() {
        return 'epos';
    }

    public static function menu_items() {
        return array(
            array(
                'path' => 'subjects',
                'title' => get_string('languages', 'artefact.epos'),
                'url' => 'artefact/epos/',
                'weight' => 30,
            ),
            array(
                'path' => 'selfevaluation',
                'title' => get_string('selfevaluation', 'artefact.epos'),
                'url' => 'artefact/epos/checklist.php',
                'weight' => 31,
            ),
            array(
                'path' => 'goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 32,
            ),
            array(
                'path' => 'goals/goals',
                'title' => get_string('goals', 'artefact.epos'),
                'url' => 'artefact/epos/goals.php',
                'weight' => 28,
            ),
            array(
                'path' => 'biography',
                'title' => get_string('biography', 'artefact.epos'),
                'url' => 'artefact/epos/biography',
                'weight' => 38,
            ),
        );
    }
}

/**
 * ArtefactTypeSubject implementing ArtefactType
 */
class ArtefactTypeSubject extends ArtefactType {

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    /**
     * Overriding the delete() function to clear table references
     */
    public function delete() {
        delete_records('artefact_epos_artefact_subject', 'artefact', $this->id);

        parent::delete();
    }
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

    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);
    }

    public function check_permission() {
        global $USER;
        if ($USER->get('id') != $this->owner) {
            throw new AccessDeniedException(get_string('youarenottheownerofthischecklist', 'artefact.epos'));
        }
    }

    public function render_self($options, $blockid = 0) {
        $this->add_to_render_path($options);
        $this->set = $this->load_descriptorset();

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
        return $language . ' (' . $this->title . ')';
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
            return TD(null, r.competence);
        },
EOF;

        foreach (array_keys($this->set) as $competence) {
            $count = 0;
            foreach (array_keys($this->set[$competence]) as $level) {
            //for ($level = 0; $level < count($this->set[$competence]); $level++) {
                $inlinejs .= <<<EOF

        function (r) {
EOF;
                if ($editable) {
                    $inlinejs .= <<<EOF

            var str1 = 'toggleLanguageForm("' + r.index + '", "$count")';
EOF;
                }
                else {
                    $inlinejs .= <<<EOF

            var str1 = '';
EOF;
                }

                $inlinejs .= <<<EOF

            var str2 = 'progressbar_$blockid' + '_' + r.index + "_$count";
            var str3 = '#progressbar_$blockid' + '_' + r.previous + "_$count";
            var data = TD({'onclick': str1});
            data.innerHTML = '<div id="' + str2 + '"></div>';
            if (prevValue.hasOwnProperty('$level')) {
                $(str3).progressbar({ value: prevValue['$level'] });
            }
            if ('$level' in r) {
                prevValue['$level'] = r['$level']['val'];
            }
            return data;
        },
EOF;
                $count++;
            }
            break;  //we need the column definitions only once
        }

        $inlinejs .= <<<EOF
    ]
);

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
     * will return something like:
     *     array(
     *         'Listening' => array(
     *             'A1' => array(
     *                 101 => array(
     *                     'name' => 'I can something',
     *                     'evaluations' => 'not at all; satisfactory; good',
     *                     'goal' => 1
     *                 102 => array(...),
     *                 etc.
     *             ),
     *             'A2' => array(
     *                 ...
     *             ),
     *             etc.
     *         ),
     *         'Reading' => array(
     *             ...
     *         ),
     *         etc.
     *     )
     */
    function load_descriptorset() {
        $sql = 'SELECT DISTINCT d.*, s.file
            FROM artefact_epos_descriptor_set s
            JOIN artefact_epos_descriptor d ON s.id = d.descriptorset
            JOIN artefact_epos_checklist_item i ON d.id = i.descriptor 
            JOIN artefact a ON a.id = i.checklist 
            WHERE a.id = ?
            ORDER BY d.level, d.competence';

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
            $competences[$desc->competence][$desc->level][$desc->id] = array(
                    'name' => $desc->name,
                    'evaluations' => $desc->evaluations,
                    'goal' => $desc->goal_available,
                    'link' => $desc->link
            );
        }
        return array(
                'competences' => $competences,
                'file' => $descriptors[0]->file
                );
    }

    /**
     * load_checklist()
     *
     * will return something like
     *     array(
     *         'evaluation' => array(
     *             33 => 0,
     *             34 => 2,
     *             etc.
     *         ),
     *         'goal' => array(
     *             33 => 0,
     *             34 => 1,
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
     * We override the constructor to set as container.
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
        db_begin();
        foreach (self::get_type_names() as $type) {
            delete_records(self::get_table_name($type), 'artefact', $this->id);
        }
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
            throw new AccessDeniedException(get_string('youarenottheownerofthisbiography', 'artefact.epos'));
        }
    }

    public function describe_size() {
        return $this->count_children() . ' ' . get_string('posts', 'artefact.blog');
    }

    public function get_entries() {
        global $USER;
        $owner = $USER->get('id');
        $entries = array();
        foreach (self::get_type_names() as $type) {
            $othertable = 'artefact_epos_biography_' . $type;
            $sql = 'SELECT ar.*, a.owner
                    FROM {artefact} a
                    JOIN {' . $othertable . '} ar ON ar.artefact = a.id
                    WHERE a.owner = ? AND a.id = ?
                    ORDER BY ar.displayorder';
            $data = get_records_sql_array($sql, array($owner, $this->id));
            if ($data) {
                $entries[$type] = $data;
            }
        }
        return $entries;
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
            'resultcounttextsingular' => get_string('biography', 'artefact.epos'),
            'resultcounttextplural' => get_string('biographies', 'artefact.epos'),
        ));
        $blogs->pagination = $pagination['html'];
        $blogs->pagination_js = $pagination['javascript'];
    }

    /**
     * This function creates a new biography.
     *
     * @param User
     * @param array
     */
    public static function new_biography(User $user, array $values) {
        $artefact = new ArtefactTypeBiography();
        $artefact->set('title', $values['title']);
        $artefact->set('description', $values['description']);
        $artefact->set('owner', $user->get('id'));
        $artefact->set('tags', $values['tags']);
        $artefact->commit();
    }

    /**
     * This function updates the settings of the biography.
     *
     * @param User
     * @param array
     */
    public static function save_settings(User $user, array $values) {
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
            get_string('biographysettings', 'artefact.epos') => $wwwroot . 'artefact/epos/biography/settings/?id=' . $id,
        );
    }

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
                    'elementtitle' => get_string('delete'),
                    'confirm' => get_string('deletebiography?', 'artefact.epos'),
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
    * returns the name of the supporting tables
    */
    public static function get_type_names() {
        return array('educationhistory', 'certificates');
    }

    public static function get_table_name($type) {
        return 'artefact_epos_biography_' . $type;
    }

    public static function get_js(array $compositetypes, $id) {
        $js = self::get_common_js();
        foreach ($compositetypes as $compositetype) {
            $js .= self::get_artefacttype_js($compositetype, $id);
        }
        return $js;
    }

    public static function get_common_js() {
        $cancelstr = get_string('cancel');
        $addstr = get_string('add');
        $confirmdelstr = get_string('compositedeleteconfirm', 'artefact.epos');
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
            {'id': id, 'artefact': artefact, 'type': type},
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
        return <<<EOF
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
EOF;
    }

    static function get_showhide_composite_js() {
        return <<<EOF

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

EOF;
    }

    static function get_artefacttype_js($compositetype, $id) {
        global $THEME;
        $editstr = get_string('edit');
        $delstr = get_string('delete');
        $imagemoveblockup   = json_encode($THEME->get_url('images/move-up.gif'));
        $imagemoveblockdown = json_encode($THEME->get_url('images/move-down.gif'));
        $upstr = get_string('moveup', 'artefact.epos');
        $downstr = get_string('movedown', 'artefact.epos');

        $js = self::get_composite_js();

        $js .= <<<EOF

tableRenderers.{$compositetype} = new TableRenderer(
    '{$compositetype}list',
    'composite.json.php?id={$id}',
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

        $js .= self::get_tablerenderer_js($compositetype);

        $js .= <<<EOF
        function (r, d) {
            var editlink = A({'href': '../edit.php?id=' + r.id + '&artefact=' + r.artefact + '&type=$compositetype', 'title': '{$editstr}'}, IMG({'src': config.theme['images/edit.gif'], 'alt':'{$editstr}'}));
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
            $elements = self::get_addform_elements($compositetype);
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

    public static function get_tablerenderer_js($biotype) {
        if ($biotype == "educationhistory") {
            return "
            'startdate',
            'enddate',
            " . self::get_tablerenderer_title_js(
                            self::get_tablerenderer_title_js_string(),
                            self::get_tablerenderer_body_js_string()
                        ) . "
            ";
        }
        if ($biotype == "certificates") {
            return "
            'date',
            " . self::get_tablerenderer_title_js(
                            self::get_tablerenderer_title_js_string(),
                            self::get_tablerenderer_body_js_string()
                        ) . "
            ";
        }
    }

    public static function get_tablerenderer_title_js_string() {
        return " formatQualification(r.name, r.level, r.place, r.subject)";
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

    public static function get_addform_elements($type) {
        if ($type == 'educationhistory') {
            return array(
                'name' => array(
                    'type' => 'text',
                    'rules' => array(
                        'required' => true,
                    ),
                    'title' => get_string('biographyform.name', 'artefact.epos'),
                    'size' => 50,
                ),
                'startdate' => array(
                    'type' => 'text',
                    'rules' => array(
                        'required' => true,
                    ),
                    'title' => get_string('biographyform.startdate', 'artefact.epos'),
                    'size' => 20,
                    'help' => true,
                ),
                'enddate' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.enddate', 'artefact.epos'),
                    'size' => 20,
                ),
                'place' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.place', 'artefact.epos'),
                    'size' => 50,
                ),
                'subject' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.subject', 'artefact.epos'),
                    'size' => 50,
                ),
                'level' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.level', 'artefact.epos'),
                    'size' => 50,
                ),
                'description' => array(
                    'type' => 'textarea',
                    'rows' => 10,
                    'cols' => 50,
                    'resizable' => false,
                    'title' => get_string('biographyform.description', 'artefact.epos'),
                ),
            );
        }
        if ($type == 'certificates') {
            return array(
                'name' => array(
                    'type' => 'text',
                    'rules' => array(
                        'required' => true,
                    ),
                    'title' => get_string('biographyform.certificatename', 'artefact.epos'),
                    'size' => 50,
                ),
                'date' => array(
                    'type' => 'text',
                    'rules' => array(
                        'required' => true,
                    ),
                    'title' => get_string('biographyform.date', 'artefact.epos'),
                    'size' => 20,
                ),
                'place' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.awardingbody', 'artefact.epos'),
                    'size' => 50,
                ),
                'subject' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.subject', 'artefact.epos'),
                    'size' => 50,
                ),
                'level' => array(
                    'type' => 'text',
                    'title' => get_string('biographyform.level', 'artefact.epos'),
                    'size' => 50,
                ),
                'description' => array(
                    'type' => 'textarea',
                    'rows' => 10,
                    'cols' => 50,
                    'resizable' => false,
                    'title' => get_string('biographyform.certificatedetails', 'artefact.epos'),
                ),
            );
        }
    }

    static function get_composite_js() {
        $at = get_string('at');
        return <<<EOF

function formatQualification(name, level, place, subject) {
    var qual = name;
    if (place) {
        qual += ' (' + place;
        if (subject) {
       		qual += ', ' + subject;
       		if (level) {
       			qual += ', ' + level;
       		}
       	}
   		else if (level) {
   			qual += ', ' + level;
   		}
        qual += ')';
    }
    else if (subject) {
        qual += ' (' + subject;
   		if (level) {
   			qual += ', ' + level;
   		}
   		qual += ')';
    }
    else if (level) {
        qual += ' (' + level + ')';
    }
    return qual;
}

EOF;
    }
}

/**
 * load_descriptorset()
 *
 * will return something like:
 *     array(
 *         'Listening' => array(
 *             'A1' => array(
 *                 101 => array(
 *                     'name' => 'I can something',
 *                     'evaluations' => 'not at all; satisfactory; good',
 *                     'goal' => 1
 *                 102 => array(...),
 *                 etc.
 *             ),
 *             'A2' => array(
 *                 ...
 *             ),
 *             etc.
 *         ),
 *         'Reading' => array(
 *             ...
 *         ),
 *         etc.
 *     )
 */
function load_descriptors($id) {
    $sql = 'SELECT * FROM artefact_epos_descriptor
        WHERE descriptorset = ?
        ORDER BY level, competence, id';

    if (!$descriptors = get_records_sql_array($sql, array($id))) {
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
        $competences[$desc->competence][$desc->level][$desc->id] = array(
                'name' => $desc->name,
                'evaluations' => $desc->evaluations,
                'goal' => $desc->goal_available,
                'link' => $desc->link
        );
    }
    return $competences;
}

/*
 * write descriptors from xml into database
 * @param $xml path to the xml file
 *        $fileistemporary whether the file will be moved to its final destination later
 *        $subjectid ID of the subject the descriptorset shall be associated with
 *        $descriptorsetid = ID of the descriptorset that is to be replaced by a new one
 */
function write_descriptor_db($xml, $fileistemporary, $subjectid, $descriptorsetid=null) {
    if (file_exists($xml) && is_readable($xml)) {
        $contents = file_get_contents($xml);
        $xmlarr = xmlize($contents);

        $descriptorsettable = 'artefact_epos_descriptor_set';
        $descriptortable = 'artefact_epos_descriptor';

        $descriptorset = $xmlarr['DESCRIPTORSET'];
        $values['name'] = $descriptorsetname = $descriptorset['@']['NAME'];
        if ($fileistemporary) {
            $values['file'] = 'unknown'; //file name may not be known yet
        }
        else {
            //extract file name from path
            $path = explode('/', $xml);
            foreach ($path as $word) {
                $values['file'] = $word;
            }
        }
        $values['visible'] = 1;
        $values['active'] = 1;

        //insert
        $values['descriptorset'] = insert_record($descriptorsettable, (object)$values, 'id', true);

        insert_record('artefact_epos_descriptorset_subject', array(
                'descriptorset' => $values['descriptorset'],
                'subject' => $subjectid
        ));

        if ($descriptorsetid != null) {
            update_record(
                    $descriptorsettable,
                    (object) array('id' => $descriptorsetid, 'visible' => 0, 'active' => 0),
                    'id'
            );
        }

        foreach ($xmlarr['DESCRIPTORSET']['#']['DESCRIPTOR'] as $x) {
            $values['competence'] = $x['@']['COMPETENCE'];
            $values['level']      = $x['@']['LEVEL'];
            $values['name']       = $x['@']['NAME'];
            $values['link']       = $x['@']['LINK'];
            $values['evaluations'] = $x['@']['EVALUATIONS'];
            $values['goal_available'] = $x['@']['GOAL'];

            insert_record($descriptortable, (object)$values);
        }
        return array('id' => $values['descriptorset'], 'name' => $descriptorsetname);
    }
    return false;
}

function get_manageable_institutions($user) {
    if ($user->get('staff') == 1 || $user->get('admin') == 1) {
        $sql = "SELECT name, displayname FROM institution ORDER BY displayname";
        if (!$data = get_records_sql_array($sql, array())) {
            $data = array();
        }
    }
    else {
        $sql = "SELECT i.name, i.displayname FROM institution i
        JOIN usr_institution ui ON ui.institution = i.name
        WHERE ui.usr = ? AND (ui.staff = 1 OR ui.admin = 1)
        ORDER BY i.displayname";
        if (!$data = get_records_sql_array($sql, array($user->id))) {
            $data = array();
        }
    }
    return $data;
}

function biographyform_submit(Pieform $form, $values) {
    try {
        ArtefactTypeBiography::process_compositeform($form, $values);
    }
    catch (Exception $e) {
        $form->json_reply(PIEFORM_ERR, $e->getMessage());
    }
    $form->json_reply(PIEFORM_OK, get_string('compositesaved', 'artefact.epos'));
}

function biographyformedit_submit(Pieform $form, $values) {
    global $SESSION;

    $goto = get_config('wwwroot') . 'artefact/epos/biography/view/?id=' . $values['artefact'];

    try {
        ArtefactTypeBiography::process_compositeform($form, $values);
    }
    catch (Exception $e) {
        $SESSION->add_error_msg(get_string('compositesavefailed', 'artefact.epos'));
        redirect($goto);
    }
    $SESSION->add_ok_msg(get_string('compositesaved', 'artefact.epos'));
    redirect($goto);
}

/**
 * Create a subject artefact for a user with a checklist assigned
 * @param $subject_id The subject the user chooses to partake in
 * @param $subject_title The title the user assigns to that subject's instance
 * @param $descriptorset_id The descriptorset to use as checklist in this instance
 * @param $checklist_title The title of the checklist created for this subject
 * @param $user_id The user to create the subject artefact for, defaults to the current user
 */
function create_subject_for_user($subject_id, $subject_title, $descriptorset_id, $checklist_title, $user_id=null) {
    if (!isset($user_id)) {
        global $USER;
        $user_id = $USER->get('id');
    }

    // update artefact 'subject' ...
    $sql = "SELECT * FROM artefact WHERE owner = ? AND artefacttype = 'subject' AND title = ?";
    if ($subjects = get_records_sql_array($sql, array($user_id, $subject_title))) {
        $subject = artefact_instance_from_id($subjects[0]->id);
        $subject->set('mtime', time());
        $subject->commit();
        $id = $subject->get('id');
    }
    // ... or create it if it doesn't exist
    else {
        safe_require('artefact', 'epos');
        $subject = new ArtefactTypeSubject(0, array(
                'owner' => $user_id,
                'title' => $subject_title,
            )
        );
        $subject->commit();
        $id = $subject->get('id');
        //insert: artefact_epos_artefact_subject
        $values_artefact_subject = array('artefact' => $id, 'subject' => $subject_id);
        insert_record('artefact_epos_artefact_subject', (object)$values_artefact_subject);
    }

    /*
    // if there is already a checklist with the given title, don't create another one
    $sql = 'SELECT * FROM artefact WHERE parent = ? AND title = ?';
    if (get_records_sql_array($sql, array($id, $checklist_title))) {
        return;
    }
    */
    create_checklist_for_user($descriptorset_id, $checklist_title, $id, $user_id);
}


/**
 * Create a checlist artefact for a user
 * @param $descriptorset_id The descriptorset to use as checklist in this instance
 * @param $checklist_title The title of the checklist created for this subject
 * @param $parent The parent item (e.g. subject)
 * @param $user_id The user to create the subject artefact for, defaults to the current user
 */
function create_checklist_for_user($descriptorset_id, $checklist_title, $parent, $user_id=null) {
    if (!isset($user_id)) {
        global $USER;
        $user_id = $USER->get('id');
    }

    // create checklist artefact
    $checklist = new ArtefactTypeChecklist(0, array(
        'owner' => $user_id,
        'title' => $checklist_title,
        'parent' => $parent
    ));
    $checklist->commit();

    // load descriptors
    $descriptors = array();
    $sql = 'SELECT d.id, d.goal_available FROM artefact_epos_descriptor d
            JOIN artefact_epos_descriptor_set s ON s.id = d.descriptorset
            WHERE s.id = ?';
    if (!$descriptors = get_records_sql_array($sql, array($descriptorset_id))) {
        $descriptors = array();
    }

    // update artefact_epos_checklist_item
    $checklist_item = array('checklist' => $checklist->get('id'), 'evaluation' => 0);
    foreach ($descriptors as $descriptor) {
        $checklist_item['descriptor'] = $descriptor->id;
        if ($descriptor->goal_available == 1) {
            $checklist_item['goal'] = 0;
        }
        else {
            unset($checklist_item['goal']);
        }
        insert_record('artefact_epos_checklist_item', (object)$checklist_item);
    }
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

?>
