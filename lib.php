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
        return array('learnedlanguage', 'checklist', 'customgoal');
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
            /*array(
                'path' => 'biography',
                'title' => get_string('biography', 'artefact.epos'),
                'url' => 'artefact/resume/',
                'weight' => 38,
            ),*/
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

?>
