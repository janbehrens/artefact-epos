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
 * @subpackage blocktype-biography
 * @author     Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2013 TZI / Universität Bremen
 *
 */

defined('INTERNAL') || die();

class PluginBlocktypeBiography extends PluginBlocktype {

    public static function single_only() {
        return true;
    }
    
    public static function get_title() {
        return get_string('biography', 'artefact.epos');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.epos/biography');
    }

    public static function get_categories() {
        return array('general');
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        require_once(get_config('docroot') . 'artefact/lib.php');
        $configdata = $instance->get('configdata');
        $blockid = $instance->get('id');
        if (!empty($configdata['artefactid'])) {
            $biography = $instance->get_artefact_instance($configdata['artefactid']);
            $smarty = smarty_core();
            $entries = $biography->get_entries();
            foreach ($entries as $type => $data) {
                $table = self::get_html_table($type);
                $table->add_table_classes("fullwidth");
                $entries[$type] = $table->render($data);
            }
            $smarty->assign('entries', $entries);
            return $smarty->fetch('blocktype:biography:content.tpl');
        }
        else {
            return "";
        }
    }
    
    public static function get_html_table($biotype) {
        if ($biotype == 'educationhistory') {
            return new HTMLTable(
                    array("Description", "From", "To"),
                    array("name", "startdate", "enddate"));
        }
        if ($biotype == 'certificates') {
            return new HTMLTable(
                    array("Title", "Awarding Body", "Date", "Level"),
                    array("name", "place", "date", "level"));
        }
        throw new Exception("Unknown biography type: " . $biotype);
    }
    
    public static function artefactchooser_element($default=null) {
        return array(
            'name'  => 'artefactid',
            'type'  => 'artefactchooser',
            'title' => get_string('selectbiography', 'blocktype.epos/biography'),
            'defaultvalue' => $default,
            'rules' => array(
                'required' => true,
            ),
            'blocktype' => 'biography',
            'limit' => 5,
            'artefacttypes' => array('biography'),
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
        return 'shallow';
    }

    /**
     * Biography blocktype is only allowed in personal views, because 
     * there's no such thing as group/site biography
     */
    public static function allowed_in_view(View $view) {
        return $view->get('owner') != null;
    }

}


class HTMLTable {
    
    public $titles;
    public $cols;
    public $data;
    private $even = false;
    public $table_classes = array();
    
    /**
     * 
     * @param array $titles List of column titles
     * @param array $cols Column definition e.g. array('propertyName', callback($row), ...)
     * @param array $data List of objects 
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
     * @param array $data List of objects 
     */
    public function render($data) {
        $this->data = $data;
        $classes = ' class="' . implode(" ", $this->table_classes) . '"';
        $out = "<table$classes>\n";
        $out .= "<thead>\n";
        foreach ($this->titles as $title) {
            $out .= "<th>$title</th>";
        }
        $out .= "</thead>\n";
        $out .= "<tbody>\n";
        while (current($this->data)) {
            $out .= $this->render_row();
            next($this->data);
        }
        $out .= "</tbody>\n";
        $out .= "</table>\n";
        return $out;
    }
    
    private function render_row() {
        $row = current($this->data);
        $classes = $this->zebra_classes();
        $out = "<tr class=\"$classes\">";
        foreach ($this->cols as $col) {
            if (isset($row->$col)) {
                $value = $row->$col;
            }
            else if (is_callable($col)) {
                $value = $col($row);
            }
            else {
                throw new Exception("Unexpected column definition: " . $col);
            }
            $out .= "<td>$value</td>";
        }
        $out .= "</tr>\n";
        return $out;
    }
    
    
}
