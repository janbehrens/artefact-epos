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
 * @author     Tim-Christian Mundt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

class Comparison {

    public $evaluations;

    private $evaluations_by_id;

    private $descriptorset;

    public static $colors = array('blue', 'red', 'green', 'purple', 'gray');

    public static $colors_html = array('afcae4', 'f0d2d2', 'b4efa4', 'd0afe4', 'cccccc');

    private $color_id = 0;

    /**
     * Construct a comparison of evaluations
     * @param array $evaluations An array of evaluations or their ids
     */
    public function __construct($evaluations) {
        if (count($evaluations) < 1) {
            throw new Exception("Not enough evaluations given for comparison.");
        }
        $this->evaluations = array();
        foreach ($evaluations as $evaluation) {
            if (is_numeric($evaluation)) {
                $evaluation = artefact_instance_from_id($evaluation);
            }
            if (!is_a($evaluation, 'ArtefactTypeEvaluation')) {
                throw new ParameterException("No valid evaluation: $evaluation");
            }
            $this->evaluations_by_id[$evaluation->get('id')]= $evaluation;
            $this->evaluations []= $evaluation;
        }
        $this->validate();
        $this->descriptorset = $this->evaluations[0]->get_descriptorset();
    }

    public function check_permission() {
        foreach ($this->evaluations as $evaluation) {
            $evaluation->check_permission();
        }
    }

    private function validate() {
        $descriptorset = $this->evaluations[0]->get_descriptorset();
        foreach ($this->evaluations as $evaluation) {
            if ($descriptorset !== $evaluation->get_descriptorset()) {
                throw new ParameterException("Those evaluations cannot be compared because their descriptor sets do not match.");
            }
        }
        return true;
    }

    private function color_reset() {
        $this->color_id = -1;
    }

    private function color_next() {
        $this->color_id++;
        if ($this->color_id >= count(self::$colors)) {
            $this->color_id = 0;
        }
        return self::$colors[$this->color_id];
    }

    private function color_html() {
        return '#' . self::$colors_html[$this->color_id];
    }

    public function get_other_matching_evaluations($owner) {
        $sql = "SELECT * FROM artefact a
                LEFT JOIN artefact_epos_evaluation e ON a.id = e.artefact
                WHERE e.descriptorset_id = ? and a.owner = ?";
        $evaluation_records = get_records_sql_array($sql, array($this->descriptorset->get_id(), $owner));
        $evaluations = array();
        foreach ($evaluation_records as $evaluation) {
            if (!isset($this->evaluations_by_id[$evaluation->id])) {
                $evaluation = new ArtefactTypeEvaluation($evaluation->id, $evaluation, false);
                $evaluations []= $evaluation;
            }
        }
        return $evaluations;
    }

    /**
     * Assemble a list of the compared evaluations.
     * @return An array of objects with id, title and url_without_this
     */
    public function get_compared_items() {
        global $USER;
        $items = array();
        $this->color_reset();
        foreach ($this->evaluations as $evaluation) {
            $evaluation_item = new stdClass();
            $evaluation_item->id = $evaluation->get('id');
            $evaluation_item->final = $evaluation->final;
            if ($evaluation->final) {
                $evaluation_item->title = $evaluation->get('title');
                $evaluation_item->url = get_config('wwwroot') . "artefact/epos/evaluation/display.php?id=$evaluation_item->id";
            }
            else {
                $evaluation_item->title = $evaluation->get_parent_instance()->get('title');
                $evaluation_item->url = get_config('wwwroot') . "artefact/epos/evaluation/self-eval.php?id=$evaluation_item->id";
            }
            $evaluation_item->mtime = format_date($evaluation->get('mtime'));
            if ($USER->get('id') == $evaluation->evaluator) {
                $evaluation_item->evaluator = get_string('by', 'artefact.epos') . ' ' . get_string('yourself', 'artefact.epos');
            }
            else {
                $evaluation_item->evaluator = get_string('by', 'artefact.epos') . ' ' . $evaluation->evaluator_display_name;
            }
            $evaluation_item->url_without_this = $this->get_url_without($evaluation_item->id);
            $evaluation_item->color = $this->color_next();
            $evaluation_item->color_html = $this->color_html();
            $items[$evaluation_item->id] = $evaluation_item;
        }
        return $items;
    }

    /**
     * Return the url to the comparison without the given evaluation
     * @param id $evaluation_id The id of the evaluation to remove from the comparison
     */
    public function get_url_without($evaluation_id) {
        $all_ids = array_fill_keys(array_keys($this->evaluations_by_id), true);
        unset($all_ids[$evaluation_id]);
        $url = "";
        foreach (array_keys($all_ids) as $id) {
            $url .= "&evaluations[]=$id";
        }
        return trim($url, '&');
    }

    /**
     * Render a select form to select more evaluations to compare with the currently
     * selected ones.
     * @return The HTML of the form ore FALSE if no further evaluations are available
     */
    public function form_select_other() {
        global $USER;
        $other = $this->get_other_matching_evaluations($USER->get('id'));
        $selectform = false;
        if (count($other) > 0) {
            $data = array();
            foreach ($other as $evaluation) {
                $item = new stdClass();
                $item->id = $evaluation->get('id');
                if ($evaluation->final) {
                    $evaluator_name = $evaluation->evaluator == $USER->get('id') ?
                        get_string('yourself', 'artefact.epos') : $evaluation->evaluator_display_name;
                    $item->title = $evaluation->get('title') . ' (' . format_date($evaluation->get('mtime')) . ', '
                    . get_string('by', 'artefact.epos') . ' ' . $evaluator_name . ')';
                }
                else {
                    $item->title = $evaluation->get_parent_instance()->get('title') . ' (' . get_string('current', 'artefact.epos') . ')';
                }
                $data []= $item;
            }
            $current_ids = array();
            foreach ($this->evaluations as $evaluation) {
                $current_ids []= (object) array('name' => "evaluations[]", 'value' => $evaluation->get('id'));
            }
            $selectform = html_select($data, "Select", "evaluations[]", null, $current_ids);
        }
        return $selectform;
    }

    public function render_table() {
        $descriptorset = $this->descriptorset;
        $results = array();
        $colors = array();
        $this->color_reset();
        foreach ($this->evaluations as $evaluation) {
            foreach ($evaluation->results() as $competence_id => $row) {
                foreach ($row['levels'] as $level_id => $complevel) {
                    if ($row['type'] == EVALUATION_ITEM_TYPE_CUSTOM_GOAL) {
                        $results[$row['name']][$level_id][$evaluation->get('id')] = $complevel;
                        $results[$row['name']]['name'] = $row['name'];
                    }
                    else {
                        $results[$competence_id][$level_id][$evaluation->get('id')] = $complevel;
                        $results[$competence_id]['name'] = $row['name'];
                    }
                }
            }
            $colors[$evaluation->get('id')] = $this->color_next();
        }

        $column_titles = array_map(function ($item) {
            return $item->name;
        }, $descriptorset->levels);
        array_unshift($column_titles, get_string('competence', 'artefact.epos'));

        $column_definitions = array(
            function ($row) use ($descriptorset) {
                return $row['name'];
            }
        );
        $levelcount = count($descriptorset->levels);
        foreach ($descriptorset->levels as $level) {
            $column_definitions []= function($row) use ($results, $level, $levelcount, $colors) {
                $bars = "";
                if (isset($row[$level->id])) {
                    $level_id = $level->id;
                }
                else {
                    // for EVALUATION_ITEM_TYPE_CUSTOM_GOAL level_id is always 0
                    $level_id = 0;
                }
                foreach ($row[$level_id] as $evaluation_id => $evaluation_row) {
                    $bars .= html_progressbar($evaluation_row['average'], null, $colors[$evaluation_id]);
                }
                return array('content' => $bars, 'properties' => array(
                    'class' => 'progress'
                ));
            };
        }
        $compare_table = new HTMLTable_epos($column_titles, $column_definitions);
        $compare_table->add_table_classes('comparison results');
        $compare_table->always_even = true;
        return $compare_table->render($results);
    }

}