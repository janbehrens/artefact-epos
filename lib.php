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
        return array('subject', 'checklist', 'customgoal');
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

            var str2 = 'progressbar_' + r.index + "_$count";
            var str3 = '#progressbar_' + r.previous + "_$count";
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
        $sql = 'SELECT DISTINCT d.*
            FROM artefact_epos_descriptor d 
            JOIN artefact_epos_checklist_item i ON d.id = i.descriptor 
            JOIN artefact a ON a.id = i.checklist 
            WHERE a.id = ?
            ORDER BY d.id, d.level';
        
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
        return $competences;
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

//write descriptors from xml into database
function write_descriptor_db($xml, $subjectid) {
    if (file_exists($xml) && is_readable($xml)) {
        $contents = file_get_contents($xml);
        $xmlarr = xmlize($contents);
        
        $descriptorsettable = 'artefact_epos_descriptor_set';
        $descriptortable = 'artefact_epos_descriptor';
        
        $descriptorset = $xmlarr['DESCRIPTORSET'];
        $values['name'] = $descriptorset['@']['NAME'];
        
        $values['descriptorset'] = insert_record($descriptorsettable, (object)$values, 'id', true);
        
        insert_record('artefact_epos_descriptorset_subject', array(
                'descriptorset' => $values['descriptorset'],
                'subject' => $subjectid
        ));
        
        foreach ($xmlarr['DESCRIPTORSET']['#']['DESCRIPTOR'] as $x) {
            $values['competence'] = $x['@']['COMPETENCE'];
            $values['level']      = $x['@']['LEVEL'];
            $values['name']       = $x['@']['NAME'];
            $values['link']       = $x['@']['LINK'];
            $values['evaluations'] = $x['@']['EVALUATIONS'];
            $values['goal_available'] = $x['@']['GOAL'];
            
            insert_record($descriptortable, (object)$values);
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

?>
