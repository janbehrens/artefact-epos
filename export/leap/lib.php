<?php
/**
 *
 * @package    mahara
 * @subpackage artefact-epos-export-leap
 * @author     Catalyst IT Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL version 3 or later
 * @copyright  For copyright information on Mahara, please see the README file distributed with this software.
 *
 */

class LeapExportElementEvaluation extends LeapExportElement {

    public function get_leap_type() {
        return 'evaluation';
    }

    public function get_content_type() {
        return 'text';
    }

    public function get_content() {
        $evaluation = new ArtefactTypeEvaluation($this->artefact->get('id'));
        return $evaluation->export_json();
    }

}
