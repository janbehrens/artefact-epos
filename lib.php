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

define('EVALUATION_ITEM_TYPE_DESCRIPTOR', 0);
define('EVALUATION_ITEM_TYPE_COMPLEVEL', 1);

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

    private  $descriptorset_id;

    private $descriptorset;

    public $items = array();

    private $items_by_descriptor_id = array();

    /**
     * Override the constructor to fetch extra data.
     *
     * @param integer $id The id of the element to load
     * @param object $data Data to fill the object with instead from the db
     */
    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);
        if ($this->id) {
        	$sql = 'SELECT e.descriptorset_id
                    FROM {artefact} a
                    LEFT JOIN {artefact_epos_evaluation} e ON a.id = e.artefact
                    WHERE a.id = ?';
        	$data = get_record_sql($sql, array($this->id));
        	if ($data) {
        		foreach((array)$data as $field => $value) {
        			if (property_exists($this, $field) && $field != 'id') {
        				$this->{$field} = $value;
        			}
        		}
        	}
        	else {
        		// This should never happen unless the user is playing around with task IDs in the location bar or similar
        		throw new ArtefactNotFoundException(get_string('evaluationnotfound', 'artefact.epos'));
        	}
        	if ($items = get_records_array('artefact_epos_evaluation_item', 'checklist', $this->id, 'id')) {
        		foreach ($items as $item) {
        			$this->items[$item->id] = $item;
        			$this->items_by_descriptor_id[$item->descriptor] = $item;
        		}
        	}
        }
    }

    public function commit() {
        db_begin();
        $new = empty($this->id);
    	parent::commit();
    	$data = (object) array(
    			'artefact'  => $this->get('id'),
    			'descriptorset_id'  => $this->descriptorset_id
    	);
    	if ($new) {
    		insert_record('artefact_epos_evaluation', $data);
    	}
    	else {
    		update_record('artefact_epos_evaluation', $data, 'artefact');
    	}
    	db_commit();
    }

    /**
     * Overriding the delete() function to clear the checklist table
     */
    public function delete() {
        db_begin();
        delete_records('artefact_epos_evaluation_item', 'checklist', $this->id);
        delete_records('artefact_epos_evaluation', 'artefact', $this->id);
        parent::delete();
        db_commit();
    }

    public static function get_icon($options=null) {}

    public static function is_singular() {
        return false;
    }

    public static function get_links($id) {}

    /**
     * This function builds the artefact title from language and checklist information
     * @see ArtefactType::display_title()
     */
    public function display_title() {
        $language = get_field('artefact', 'title', 'id', $this->parent);
        return $language . ' (' . $this->title . ')';
    }

    public function get_descriptorset() {
		if (!isset($this->descriptorset)) {
			$this->descriptorset = new Descriptorset($this->descriptorset_id);
		}
		return $this->descriptorset;
    }

    public function check_permission() {
        global $USER;
        if ($USER->get('id') != $this->owner) {
            throw new AccessDeniedException(get_string('youarenottheownerofthischecklist', 'artefact.epos'));
        }
    }

    /**
     * Calculate the results in an array of competences of levels.
     */
    public function results() {
        $descriptorset = $this->get_descriptorset();
        $max_rating = count($descriptorset->ratings) - 1;
        $results = array();
        $empty_complevel = array(
            'value' => 0,
            'max' => 0,
            'evaluation_sums' => array_fill(0, $max_rating+1, 0)
        );
        foreach($this->items as $item) {
            $descriptor = $descriptorset[$item->descriptor];
            if (!isset($results[$descriptor->competence_id][$descriptor->level_id])) {
                $results[$descriptor->competence_id][$descriptor->level_id] = $empty_complevel;
            }
            $complevel = &$results[$descriptor->competence_id][$descriptor->level_id];
            $complevel['value'] += $item->evaluation;
            $complevel['max'] += $max_rating;
            increase_array_value($complevel['evaluation_sums'], $item->evaluation);
        }
        foreach ($results as $competence_id => &$levels) {
            ksort($levels);
            foreach ($levels as &$complevel) {
                $complevel['average'] = round(100 * $complevel['value'] / $complevel['max']);
            }
            $levels['name'] = $descriptorset->competences[$competence_id]->name;
        }
        ksort($results);
        return $results;
    }

    /**
     * Used by views to display this artefact.
     * @see ArtefactType::render_self()
     */
    public function render_self($options, $blockid = 0) {
        //$this->add_to_render_path($options);
        return array('html' => $this->render_evaluation_table(false), 'javascript' => '');
    }

    /**
     * Get the forms and JS necessary to display the self-evaluation.
     * @param array $alterform An array containing elements that should override
     * the values of the generated forms.
     * @return array ($forms, $inlinejs)
     */
    public function render_evaluation($alterform = array()) {
        $checklistforms = $this->form_evaluation($alterform);
        $inlinejs = $this->form_evaluation_js();
        $smarty = smarty();
        $smarty->assign('id', $this->get('id'));
        $smarty->assign('checklistforms', $checklistforms);
        $smarty->assign('evaltable', $this->render_evaluation_table());
        $includejs = array('jquery',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.core.min.js',
                       'artefact/epos/js/jquery/ui/minified/jquery.ui.widget.min.js',
                       'artefact/epos/js/jquery/jquery.simplemodal.1.4.4.min.js'
        );
        return array(
            'html' => $smarty->fetch('artefact:epos:evaluation.tpl'),
            'inlinejs' => $inlinejs,
            'includejs' => $includejs
        );
    }

    /**
     * Get the forms for the self-evaluation.
     *
     * @param array $alterform
     *            An array containing elements that should override
     *            the values of the generated forms.
     * @return array $forms
     */
    private function form_evaluation($alterform = array()) {
        $checklistforms = array();
        $descriptorset = $this->get_descriptorset();
        $descriptorsetfile = substr($descriptorset->file, 0, count($descriptorset->file) - 5);
        $ratings = array();
        foreach ($descriptorset->ratings as $id => $rating) {
            $ratings[] = $rating->name;
        }
        foreach ($descriptorset->competences as $competence) {
            foreach ($descriptorset->levels as $level) {
                $elements = array();
                $elements['header'] = array(
                        'type' => 'html',
                        'title' => ' ',
                        'value' => ''
                );
                $elements['header_goal'] = array(
                        'type' => 'html',
                        'title' => ' ',
                        'value' => get_string('goal', 'artefact.epos') . '?'
                );
                $goals = false;
                foreach ($descriptorset->get_descriptors($competence->id, $level->id) as $descriptor) {
                    $item = $this->items_by_descriptor_id[$descriptor->id];
                    if ($descriptor->goal_available) $goals = true;
                    $this->form_evaluation_item($elements, $item, $descriptor, $ratings, $descriptorsetfile);
                }
                if (!$goals) {
                    unset($elements['header_goal']);
                }
                $elements['competence'] = array(
                        'type' => 'hidden',
                        'value' => $competence->name
                );
                $elements['level'] = array(
                        'type' => 'hidden',
                        'value' => $level->name
                );
                $elements['submit'] = array(
                        'type' => 'submit',
                        'title' => '',
                        'value' => get_string('save', 'artefact.epos')
                );
                $checklistform = array(
                        'name' => 'checklistform_' . $competence->id . '_' . $level->id,
                        'plugintype' => 'artefact',
                        'pluginname' => 'epos',
                        'jsform' => true,
                        'renderer' => 'multicolumntable',
                        'elements' => $elements,
                        'elementclasses' => true,
                        'successcallback' => array(
                                'ArtefactTypeChecklist',
                                'submit_checklistform'
                        ),
                        'jssuccesscallback' => 'checklistSaveCallback'
                );
                foreach ($alterform as $key => $value) {
                    $checklistform[$key] = $value;
                }
                $checklistform = pieform($checklistform);
                $form_name = 'checklistform_' . $competence->id . '_' . $level->id;
                $checklistforms[$competence->id][$level->name]['competence'] = $competence->name;
                $checklistforms[$competence->id][$level->name]['form'] = $checklistform;
                $checklistforms[$competence->id][$level->name]['name'] = $form_name;
            }
        }
        return $checklistforms;
    }

    private function form_evaluation_item(&$elements, $item, $descriptor, $ratings, $descriptorsetfile) {
    	$elements['item' . $item->id] = array(
    			'type' => 'radio',
    			'title' => $descriptor->name,
    			'options' => $ratings,
    			'defaultvalue' => $item->evaluation,
    	);
    	//goal checkbox
    	if ($descriptor->goal_available) {
    		$elements['item' . $item->id . '_goal'] = array(
    				'type' => 'checkbox',
    				'title' => $descriptor->name,
    				'defaultvalue' => $item->goal,
    		);
    	}
    	//link
    	if ($descriptor->link != '') {
    		//check if http(s):// is present in link
    		if (substr($descriptor->link, 0, 7) != "http://" && substr($descriptor->link, 0, 8) != "https://") {
    			$descriptor->link = "example.php?d=" . $descriptorsetfile . "&l=" . $descriptor->link;
    		}
    		$elements['item' . $item->id]['title'] .= ' <a href="' . $descriptor->link . '"  onclick="openPopup(\'' . $descriptor->link . '\'); return false;">(' . get_string('exampletask', 'artefact.epos') . ')</a>';
    		if ($descriptor->goal_available) {
    			$elements['item' . $item->id . '_goal']['title'] = $elements['item' . $item->id]['title'];
    		}
    	}
    }

    private function form_evaluation_js() {
        $descriptorset = $this->get_descriptorset();
        $jsdivs = 'divs = [';
        foreach ($descriptorset->competences as $competence) {
            foreach ($descriptorset->levels as $level) {
                $form_name = 'checklistform_' . $competence->id . '_' . $level->id;
                $jsdivs .= '"' . $form_name . '_div", ';
            }
        }
        // remove last comma
        $jsdivs = substr($jsdivs, 0, strlen($jsdivs) - 2);
        $jsdivs .= '];';

        $inlinejs = $jsdivs;
        $inlinejs .= "

        function toggleLanguageForm(comp, level) {
            var elemName = 'checklistform_' + comp + '_' + level + '_div';
            for(var i = 0; i < divs.length; i++) {
                addElementClass(divs[i], 'hidden');
            }
            if (hasElementClass(elemName, 'hidden')) {
                removeElementClass(elemName, 'hidden');
            }
        }

        function checklistSaveCallback(form, data) {
            window.location.reload();
        }

        function openPopup(url) {
            jQuery('<div id=\"example_popup\"></div>').modal({overlayClose:true, closeHTML:''});
            jQuery('<iframe src=\"' + url + '\">').appendTo('#example_popup');
        }

        ";
        return $inlinejs;
    }

    public function render_evaluation_table($interactive=true) {
        $descriptorset = $this->get_descriptorset();
        $results = $this->results();
        $rows = array();

        $column_titles = array_map(function ($item) {
            return $item->name;
        }, $descriptorset->levels);
        array_unshift($column_titles, get_string('competence', 'artefact.epos'));

        $column_definitions = array(
            function ($row) use ($descriptorset) {
                return $row['name'];
            }
        );
        foreach ($descriptorset->levels as $level) {
            $column_definitions []= function($row) use ($level, $interactive) {
                $cell = array('content' => html_progressbar($row[$level->id]['average']));
                if ($interactive) {
                    $cell['properties'] = array(
                            'onclick' => "toggleLanguageForm(" . $row['__id'] . ", $level->id)",
                            'class' => "interactive"
                    );
                }
                return $cell;
            };
        }

        $eval_table = new HTMLTable_epos($column_titles, $column_definitions);
        $eval_table->add_table_classes('evaluation');
        $eval_table->always_even = true;
        return $eval_table->render($results);
    }

    /**
     * This writes changed checklist items to the database.
     */
    public static function submit_checklistform(Pieform $form, $values) {
        try {
            global $id;
            $data = new stdClass();
            $data->checklist = $id;
            $item_pattern = '/^item(\d+)$/';
            foreach ($values as $name => $value) {
                if (preg_match($item_pattern, $name, $parts)) {
                    $data->id = $parts[1];
                    $data->evaluation = $value;
                    if (isset($values[$name . '_goal'])) {
                        $data->goal = $values[$name . '_goal'] ? 1 : 0;
                    }
                    else {
                        unset($data->goal);
                    }
                    update_record('artefact_epos_evaluation_item', $data, array('checklist', 'id'));
                }
            }
        }
        catch (Exception $e) {
            $form->json_reply(PIEFORM_ERR, $e->getMessage());
        }
        $form->json_reply(PIEFORM_OK, get_string('savedchecklist', 'artefact.epos'));
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

class Descriptorset implements ArrayAccess, Iterator {

	private $id;

	private $name;

	public $file;

	public $visible;

	public $active;

	public $descriptors = array();

	public $ratings = array();

	public $levels = array();

	public $competences = array();

	private $descriptors_by_competence_level = array();

	function __construct($id=0) {
		// load
		if (!empty($id)) {
			if (!$data = get_record('artefact_epos_descriptorset', 'id', $id)) {
				throw new Exception(get_string('descriptorsetnotfound', 'artefact.epos'));
			}
			foreach((array)$data as $field => $value) {
				if (property_exists($this, $field)) {
					$this->{$field} = $value;
				}
			}
			if ($descriptors = get_records_array('artefact_epos_descriptor', 'descriptorset', $id, 'competence_id, level_id')) {
				foreach ($descriptors as $descriptor) {
					$this->descriptors[$descriptor->id] = $descriptor;
					$this->descriptors_by_competence_level[$descriptor->competence_id][$descriptor->level_id] []= $descriptor;
				}
			}
			if ($ratings = get_records_array('artefact_epos_rating', 'descriptorset_id', $id, 'id')) {
				foreach ($ratings as $rating) {
					$this->ratings[$rating->id] = $rating;
				}
			}
			if ($levels = get_records_array('artefact_epos_level', 'descriptorset_id', $id, 'id')) {
				foreach ($levels as $level) {
					$this->levels[$level->id] = $level;
				}
			}
			if ($competences = get_records_array('artefact_epos_competence', 'descriptorset_id', $id, 'id')) {
				foreach ($competences as $competence) {
					$this->competences[$competence->id] = $competence;
				}
			}
		}
	}

	public function commit() {
		db_begin();
		$new = empty($this->id);
		$data = (object)array(
				'id'  => $this->id,
		);
		if ($new) {
			$success = insert_record('artefact_epos_descriptorset', $data);
		}
		else {
			$success = update_record('artefact_epos_descriptorset', $data, array('id'));
		}
		db_commit();
	}

	public function delete() {
		if (empty($this->id)) {
			return;
		}
		db_begin();
		// TODO: delete competences, ratings and levels
		delete_records('artefact_epos_descriptorset', 'id', $this->id);
		db_commit();
	}

	// array interface

	public function offsetExists($offset) {
		return isset($this->descriptors);
	}

	public function offsetGet($offset) {
		return $this->descriptors[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->descriptors[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->descriptors[$offset]);
	}

	// iterator interface

	public function rewind() {
        return reset($this->descriptors);
    }

    public function current() {
        return current($this->descriptors);
    }

    public function key() {
        return key($this->descriptors);
    }

    public function next() {
        return next($this->descriptors);
    }

    public function valid() {
        return current($this->descriptors) !== false;
    }

    // other

    public function get_descriptors($competence_id, $level_id) {
    	return $this->descriptors_by_competence_level[$competence_id][$level_id];
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
    $sql = 'SELECT d.id, d.name, d.link, d.goal_available, c.name AS competence, l.name AS level FROM artefact_epos_descriptor d
            LEFT JOIN artefact_epos_competence c ON d.competence_id = c.id
            LEFT JOIN artefact_epos_level l ON d.level_id = l.id
        WHERE descriptorset = ?
        ORDER BY level, competence, id';

    if (!$descriptors = get_records_sql_array($sql, array($id))) {
        $descriptors = array();
    }
    // TODO: move ratings to up to descriptor set layer
    if (!$ratings = get_records_array('artefact_epos_rating', 'descriptorset_id', $id, 'id')) {
        $ratings = array();
    }
    $ratings = implode(';', array_map(
        function($rating) { return $rating->name; }, $ratings));
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
                'evaluations' => $ratings,
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

        $descriptorsettable = 'artefact_epos_descriptorset';
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
        db_begin();
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

        $competences = array();
        $levels = array();

        foreach ($xmlarr['DESCRIPTORSET']['#']['DESCRIPTOR'] as $x) {
            $competence = $x['@']['COMPETENCE'];
            $level = $x['@']['LEVEL'];
            if (!isset($competences[$competence])) {
                $cid = insert_record('artefact_epos_competence', (object) array (
                    'descriptorset_id' => $values['descriptorset'],
                    'name' => $competence
                ), 'id', true);
                $competences[$competence] = $cid;
            }
            if (!isset($levels[$level])) {
                $lid = insert_record('artefact_epos_level', (object) array (
                    'descriptorset_id' => $values['descriptorset'],
                    'name' => $level
                ), 'id', true);
                $levels[$level] = $lid;
            }
            $values['competence_id']  = $competences[$competence];
            $values['level_id']       = $levels[$level];
            $values['name']           = $x['@']['NAME'];
            $values['link']           = $x['@']['LINK'];
            $values['goal_available'] = $x['@']['GOAL'];
            insert_record($descriptortable, (object)$values);
        }
        $ratings = array_map('trim', explode(';', $x['@']['EVALUATIONS']));
        foreach ($ratings as $rating) {
            insert_record('artefact_epos_rating', (object) array(
                'descriptorset_id' => $values['descriptorset'],
                'name' => $rating
            ));
        }
        db_commit();
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
        'parent' => $parent,
    	'descriptorset_id' => $descriptorset_id
    ));
    $checklist->commit();

    // load descriptors
    $descriptors = array();
    $sql = 'SELECT d.id, d.goal_available FROM artefact_epos_descriptor d
            JOIN artefact_epos_descriptorset s ON s.id = d.descriptorset
            WHERE s.id = ?';
    if (!$descriptors = get_records_sql_array($sql, array($descriptorset_id))) {
        $descriptors = array();
    }

    // update artefact_epos_evaluation_item
    $checklist_item = array('checklist' => $checklist->get('id'), 'evaluation' => 0);
    foreach ($descriptors as $descriptor) {
        $checklist_item['descriptor'] = $descriptor->id;
        if ($descriptor->goal_available == 1) {
            $checklist_item['goal'] = 1;
        }
        else {
            unset($checklist_item['goal']);
        }
        insert_record('artefact_epos_evaluation_item', (object)$checklist_item);
    }
}

function increase_array_value(&$data, $key, $value=1) {
    if (!array_key_exists($key, $data)) {
        $data[$key] = $value;
    }
    else {
        $data[$key] += $value;
    }
}


class HTMLTable_epos {

    public $titles;
    public $cols;
    public $id;
    public $data;
    private $even = true;
    public $table_classes = array();
    public $properties = array();

    // if true, appends an empty row in case there's an odd number of rows
    public $always_even = false;

    /**
     *
     * @param array $titles
     *            List of column titles
     * @param array $cols
     *            Column definition e.g. array('propertyName', callback($row), ...)
     * @param array $data
     *            List of objects
     */
    public function __construct($titles, $cols) {
        $this->titles = $titles;
        $this->cols = $cols;
        if (count($cols) != count($titles)) {
            throw new Exception("The number or column definitions does not match the number of column titles.");
        }
    }

    public function add_table_classes($classes) {
        if (!is_array($classes)) {
            $classes = array($classes);
        }
        $this->table_classes = array_merge($this->table_classes, $classes);
    }

    private function zebra_classes() {
        $this->even = !$this->even;
        return $this->even ? "even r0" : "odd r1";
    }

    /**
     * Generate HTML from a list of data objects (like record sets)
     *
     * @param array $data List of objects
     */
    public function render($data) {
        $this->data = $data;
        $classes = ' class="' . implode(" ", $this->table_classes) . '"';
        $properties = $this->render_properties($this->properties);
        $out = "<table $classes $properties>\n";
        $out .= "<thead><tr>\n";
        foreach ($this->titles as $id => $title) {
            $column_id = "column_";
            $column_id .= isset($this->id) ? $this->id . '_' . $id : $id;
            $out .= "<th class=\"$column_id\">$title</th>";
        }
        $out .= "</tr></thead>\n";
        $out .= "<tbody>\n";
        while ($row = current($this->data)) {
            $out .= $this->render_row($row);
            next($this->data);
        }
        if ($this->always_even && !$this->even) {
            $out .= $this->render_empty_row();
        }
        $out .= "</tbody>\n";
        $out .= "</table>\n";
        return $out;
    }

    private function render_row($row) {
        $classes = $this->zebra_classes();
        $out = "<tr class=\"$classes\">";
        if (is_array($row)) {
            $row['__id'] = key($this->data);
        }
        else if (is_object($row)) {
            $row->__id = key($this->data);
        }
        foreach ($this->cols as $col) {
            if (is_callable($col)) {
                $value = $col($row);
            }
            else if (is_array($row) && isset($row[$col])) {
                $value = $row[$col];
            }
            else if (is_object($row) && isset($row->$col)) {
                $value = $row->$col;
            }
            else {
                throw new Exception("Unexpected column definition: " . $col);
            }
            $properties = "";
            if (is_array($value)) {
                if (isset($value['properties'])) {
                    $properties = $this->render_properties($value['properties']);
                }
                $value = $value['content'];
            }
            $out .= "<td $properties>$value</td>";
        }
        $out .= "</tr>\n";
        return $out;
    }

    private function render_empty_row() {
        $classes = $this->zebra_classes();
        $colspan = count($this->cols);
        return "<tr class=\"$classes\"><td colspan=\"$colspan\"></td>\n";
    }

    private function render_properties($properties) {
        if (is_object($properties)) {
            $properties = (array) $properties;
        }
        $rendered = array();
        foreach ($properties as $property => $propvalue) {
            $rendered []= "$property=\"$propvalue\"";
        }
        return implode(" ", $rendered);
    }

}

function html_progressbar($value, $content=null) {
    $smarty = smarty();
    $smarty->assign('value', $value);
    if ($content != null) {
        $smarty->assign('content', $content);
    }
    return $smarty->fetch('artefact:epos:progressbar.tpl');
}