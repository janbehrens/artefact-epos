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
 * @subpackage blocktype-epos
 * @author     Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 Jan Behrens, jb3@informatik.uni-bremen.de
 *
 */

defined('INTERNAL') || die();

safe_require('artefact', 'epos');

class PluginBlocktypeChecklist extends PluginBlocktype {

    public static function single_only() {
        return false;
    }

    public static function get_title() {
        return get_string('title', 'blocktype.epos/checklist');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.epos/checklist');
    }

    public static function get_categories() {
        return array('general');
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        $configdata = $instance->get('configdata');
        $full_self_url = urlencode(get_full_script_path());
        $result = 'foo';
        return $result;
    }

    /*public static function get_artefacts(BlockInstance $instance) {
        $configdata = $instance->get('configdata');
        $artefacts = array();
        
        if (isset($configdata['artefactid'])) {
            $artefacts[] = $configdata['artefactid'];
        }
        return $artefacts;
    }*/
    
    /*public static function artefactchooser_element($default=null) {
        return array(
        	'name' => 'artefactid',
            'type'  => 'artefactchooser',
            'title' => 'Select language',
            //'defaultvalue' => $default,
            'selectone' => true,
            'blocktype' => 'checklist',
        	'artefacttypes' => array('checklist'),
        );
    }*/
    
    public static function artefactchooser_element($default=null) {
        return array(
            'name'  => 'artefactid',
            'type'  => 'artefactchooser',
            'title' => get_string('selectchecklist', 'blocktype.epos/checklist'),
            'defaultvalue' => $default,
            'rules' => array(
                'required' => true,
            ),
            'blocktype' => 'checklist',
            'limit' => 5,
            'artefacttypes' => array('checklist'),
            //'template' => 'artefact:file:artefactchooser-element.tpl',
        );
    }
    
    public static function has_instance_config() {
        return true;
    }
    
    public static function artefactchooser_get_element_data($data) {
        $data->id = $data->id . $data->id;
        return $data;
    }

    public static function instance_config_form() {
        //$configdata = $instance->get('configdata');

        $form = array();

        $form[] = self::artefactchooser_element((isset($configdata['artefactid'])) ? $configdata['artefactid'] : null);
        $form['message'] = array(
            'type' => 'html',
            'value' => '',
        );
        
        return $form;
        
        /*global $USER;
        
        $data = array();
        $options = array();
        $count = 0;
        $table = 'artefact_epos_learnedlanguage';
        
        $owner = $USER->get('id');
        
        $sql = 'SELECT ar.*, a.owner
            FROM {artefact} a 
            JOIN {' . $table . '} ar ON ar.artefact = a.id
            WHERE a.owner = ? AND a.artefacttype = ?';
        
        if (!$data = get_records_sql_array($sql, array($owner, 'learnedlanguage'))) {
            $data = array();
        }
        
        // For converting language and descriptorset codes to their respective names...
        if ($data) {
            foreach ($data as $field) {
                $options[$count] = get_string('language.'.$field->language, 'artefact.epos') . ' (' . get_string('descriptorset.'.$field->descriptorset, 'artefact.epos') . ')';
                $count++;
            }
        }
        
        return array(
            'language' => array(
                'type' => 'select',
                'title' => get_string('language', 'mahara'),
                'options' => $options,
                'defaultvalue' => 0,
            ),
        );*/
    }

    public static function instance_config_validate(Pieform $form, $values) {
    }
    
    public static function default_copy_type() {
        return 'full';
    }
}

?>
