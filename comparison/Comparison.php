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
                $evaluation = new ArtefactTypeChecklist($evaluation);
            }
            if (!is_a($evaluation, 'ArtefactTypeChecklist')) {
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

    public function get_other_matching_evaluations($owner) {
        $sql = "SELECT * FROM artefact a
                LEFT JOIN artefact_epos_evaluation e ON a.id = e.artefact
                WHERE e.descriptorset_id = ? and a.owner = ?";
        $evaluation_records = get_records_sql_array($sql, array($this->descriptorset->get_id(), $owner));
        $evaluations = array();
        foreach ($evaluation_records as $evaluation) {
            if (!isset($this->evaluations_by_id[$evaluation->id])) {
                $evaluation = new ArtefactTypeChecklist(0, $evaluation, false);
                $evaluation->set('dirty', false);
                $evaluations []= $evaluation;
            }
        }
        return $evaluations;
    }

    public function render_table() {
        $descriptorset = $this->descriptorset;
        $results = array();
        foreach ($this->evaluations as $evaluation) {
            foreach ($evaluation->results() as $competence => $row) {
                foreach ($row as $level => $complevel) {
                    $results[$competence][$level][] = $complevel;
                }
            }
        }

        $column_titles = array_map(function ($item) {
            return $item->name;
        }, $descriptorset->levels);
        array_unshift($column_titles, get_string('competence', 'artefact.epos'));

        $column_definitions = array(
            function ($row) use ($descriptorset) {
                return $row['name'][0];
            }
        );
        $levelcount = count($descriptorset->levels);
        foreach ($descriptorset->levels as $level) {
            $column_definitions []= function($row) use ($results, $level, $levelcount) {
                $bars = "";
                if (isset($row[$level->id])) {
                    $level_id = $level->id;
                }
                else {
                    // for EVALUATION_ITEM_TYPE_CUSTOM_GOAL level_id is always 0
                    $level_id = 0;
                }
                foreach ($row[$level_id] as $evaluation_row) {
                    $bars .= html_progressbar($evaluation_row['average']);
                }
                return $bars;
            };
        }
        $compare_table = new HTMLTable_epos($column_titles, $column_definitions);
        $compare_table->add_table_classes('comparison');
        $compare_table->always_even = true;
        return $compare_table->render($results);
    }

}