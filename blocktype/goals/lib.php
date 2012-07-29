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

class PluginBlocktypeGoals extends PluginBlocktype {

    public static function single_only() {
        return true;
    }

    public static function get_title() {
        return get_string('title', 'blocktype.epos/goals');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.epos/goals');
    }

    public static function get_categories() {
        return array('general');
    }

    public static function get_instance_title(BlockInstance $bi) {
        $configdata = $bi->get('configdata');

        if (!empty($configdata['artefactid'])) {
            return 'Goals for ' . $bi->get_artefact_instance($configdata['artefactid'])->display_title();
        }
        return '';
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        $result = '';
        $configdata = $instance->get('configdata');
        
        if (!empty($configdata['artefactid'])) {
            $jsonpath = get_config('wwwroot') . 'artefact/epos/goals.json.php?id=' . $configdata['artefactid'];
            
            $inlinejs = <<<EOF
        
tableRenderer = new TableRenderer(
    'goals_table',
    '{$jsonpath}',
    [
        function (r, d) {
        	var data = TD(null);
        	if(r.descriptor == null && r.description != null) {
            	data.innerHTML = '<div class="customgoalText" id="' + r.id + '">' + r.description + '</div>';
            	return data;
			}
            return TD(null, r.descriptor);
        },
        function (r, d) {
        	if(r.competence == null) {
        			r.competence = "";
        			r.level = "";
        	}
            return TD(null, r.competence + ' ' + r.level);
        },
        function (r, d) {
        	return TD(null, r.descriptorset);
     
        },
        function (r, d) {
			return TD(null);
		},
    ]
);

tableRenderer.emptycontent = '';
tableRenderer.paginate = false;
tableRenderer.updateOnLoad();
EOF;
            
            $smarty = smarty_core();
            $smarty->assign('JAVASCRIPT', $inlinejs);
            
            $result = $smarty->fetch('artefact:epos:viewgoals.tpl');
        }
        return $result;
    }
	
    public static function artefactchooser_element($default=null) {
        return array(
            'name'  => 'artefactid',
            'type'  => 'artefactchooser',
            'title' => get_string('selectgoals', 'blocktype.epos/goals'),
            'defaultvalue' => $default,
            'rules' => array(
                'required' => true,
            ),
            'blocktype' => 'goals',
            'limit' => 5,
            'artefacttypes' => array('subject'),
        );
    }
    
    public static function has_instance_config() {
        return true;
    }

    public static function instance_config_form($instance) {
        $configdata = $instance->get('configdata');

        $elements = array();
        $elements[] = self::artefactchooser_element((isset($configdata['artefactid'])) ? $configdata['artefactid'] : null);
        return $elements;
    }
    
    public static function default_copy_type() {
        return 'full';
    }
}

?>
