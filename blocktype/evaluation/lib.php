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
 * @subpackage blocktype-evaluation
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011 TZI / Universität Bremen
 *
 */

defined('INTERNAL') || die();

class PluginBlocktypeEvaluation extends PluginBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.epos/evaluation');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.epos/evaluation');
    }

    public static function get_categories() {
        return array('general');
    }

    public static function get_instance_title(BlockInstance $bi) {
        $configdata = $bi->get('configdata');

        if (!empty($configdata['artefactid'])) {
            return $bi->get_artefact_instance($configdata['artefactid'])->display_title();
        }
        return '';
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        $configdata = $instance->get('configdata');
        $blockid = $instance->get('id');

        $result = '';
        if (!empty($configdata['artefactid'])) {
            $evaluation = $instance->get_artefact_instance($configdata['artefactid']);
            $result = $evaluation->render_self($configdata, $blockid);
            $result = $result['html'];
        }
        return $result;
    }

    public static function artefactchooser_element($default=null) {
        return array(
            'name'  => 'artefactid',
            'type'  => 'artefactchooser',
            'title' => get_string('selectevaluation', 'blocktype.epos/evaluation'),
            'defaultvalue' => $default,
            'rules' => array(
                'required' => true,
            ),
            'blocktype' => 'evaluation',
            'limit' => 5,
            'artefacttypes' => array('evaluation'),
        );
    }

    public static function has_instance_config() {
        return true;
    }

    /**
     * Optional method. If specified, allows the blocktype class to munge the
     * artefactchooser element data before it's templated
     */
    public static function artefactchooser_get_element_data($artefact) {
        $instance = artefact_instance_from_id($artefact->id);
        $artefact->title = $instance->display_title();
        $artefact->hovertitle = '';
        return $artefact;
    }

    public static function instance_config_form(BlockInstance $instance) {
        $configdata = $instance->get('configdata');
        $elements = array();
        $elements[] = self::artefactchooser_element((isset($configdata['artefactid'])) ? $configdata['artefactid'] : null);
        return $elements;
    }

    public static function default_copy_type() {
        return 'full';
    }

    /**
     * Allow this blocktype in personal views only
     */
    public static function allowed_in_view(View $view) {
        return $view->get('owner') != null;
    }
}
