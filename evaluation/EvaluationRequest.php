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

class EvaluationRequest {

    public $id;

    public $inquirer_id;

    public $inquirer;

    public $evaluator;

    public $evaluator_id;

    public $subject_id;

    public $subject;

    public $descriptorset_id;

    public $descriptorset;

    public $evaluation_id;

    public $inquiry_date;

    public $inquiry_message;

    public $response_date;

    public $response_message;

    public function __construct($id=0, $data=null) {
        if (!empty($id)) {
            if (empty($data)) {
                $data = get_record('artefact_epos_evaluation_request', 'id', $id);
                if (!$data) {
                    throw new ArtefactNotFoundException(get_string('artefactnotfound', 'error', $id));
                }
            }
            $this->id = $id;
        }
        if (!empty($data)) {
            foreach ((array)$data as $field => $value) {
                if (property_exists($this, $field)) {
                    $this->{$field} = $value;
                }
            }
        }
    }

    public function commit() {
        db_begin();
        $new = empty($this->id);
        if (empty($this->inquiry_date)) {
            $this->inquiry_date = time();
        }
        $data = (object)array(
                'id' => $this->id,
                'inquirer_id' => $this->inquirer_id,
                'evaluator_id' => $this->evaluator_id,
                'subject_id' => $this->subject_id,
                'descriptorset_id' => $this->descriptorset_id,
                'evaluation_id' => $this->evaluation_id,
                'inquiry_message' => $this->inquiry_message,
                'response_message' => $this->response_message
        );
        if (isset($this->inquiry_date)) {
            $data->inquiry_date = db_format_timestamp($this->inquiry_date);
        }
        if (isset($this->response_date)) {
            $data->response_date = db_format_timestamp($this->response_date);
        }
        if ($new) {
            $success = insert_record('artefact_epos_evaluation_request', $data);
        }
        else {
            $success = update_record('artefact_epos_evaluation_request', $data, 'id');
        }
        db_commit();
    }

    public function get_id() {
        return $this->id;
    }

    public function delete() {
        if (empty($this->id)) {
            return;
        }
        delete_records('artefact_epos_evaluation_request', 'id', $this->id);
    }

    /**
     * Get the open requests other users have sent to the current user.
     */
    public static function get_open_requests_for_evaluator() {
        global $USER;
        $sql = "
                SELECT r.*,
                       u1.username AS inquirer_username,
                       u1.firstname AS inquirer_firstname,
                       u1.lastname AS inquirer_lastname,
                       u2.username AS evaluator_username,
                       u2.firstname AS evaluator_firstname,
                       u2.lastname AS evaluator_lastname,
                       subject.title AS subject,
                       dset.name AS descriptorset
                FROM artefact_epos_evaluation_request r
                LEFT JOIN usr u1 ON r.inquirer_id = u1.id
                LEFT JOIN usr u2 ON r.evaluator_id = u2.id
                LEFT JOIN artefact subject ON r.subject_id = subject.id
                LEFT JOIN artefact_epos_descriptorset dset ON r.descriptorset_id = dset.id
                WHERE evaluator_id = ?
                    AND response_date IS NULL
                ORDER BY inquiry_date
                ";
        if ($records = get_records_sql_array($sql, array($USER->get('id')))) {
            $requests = array();
            foreach ($records as $record) {
                $inquirer = array('username' => $record->inquirer_username,
                                  'firstname' => $record->inquirer_firstname,
                                  'lastname' => $record->inquirer_lastname);
                $evaluator = array('username' => $record->evaluator_username,
                                  'firstname' => $record->evaluator_firstname,
                                  'lastname' => $record->evaluator_lastname);
                $request = new self(0, $record);
                $request->inquirer = $inquirer;
                $request->evaluator = $evaluator;
                $requests []= $request;
            }
            return $requests;
        }
        else {
            return array();
        }
    }

    /**
     * Get the recently modified requests of the current user (either recently
     * sent or recently returned).
     */
    public static function get_recent_requests_for_inquirer() {
        global $USER;
        $requests = array();
        $sql = "
                SELECT r.*,
                       u.username AS evaluator_username,
                       u.firstname AS evaluator_firstname,
                       u.lastname AS evaluator_lastname,
                       subject.title AS subject,
                       dset.name AS descriptorset
                FROM artefact_epos_evaluation_request r
                LEFT JOIN artefact subject ON r.subject_id = subject.id
                LEFT JOIN artefact_epos_descriptorset dset ON r.descriptorset_id = dset.id
                LEFT JOIN usr u ON r.evaluator_id = u.id
                WHERE inquirer_id = ?
                    AND response_date IS NOT NULL
                ORDER BY response_date DESC
                LIMIT 5
                ";
        if ($records = get_records_sql_array($sql, array($USER->get('id')))) {
            foreach ($records as $record) {
                $evaluator = array('username' => $record->evaluator_username,
                                  'firstname' => $record->evaluator_firstname,
                                  'lastname' => $record->evaluator_lastname);
                $request = new self(0, $record);
                $request->evaluator = $evaluator;
                $requests []= $request;
            }
        }
        $sql = "
                SELECT r.*,
                       u.username AS evaluator_username,
                       u.firstname AS evaluator_firstname,
                       u.lastname AS evaluator_lastname,
                       subject.title AS subject,
                       dset.name AS descriptorset
                FROM artefact_epos_evaluation_request r
                LEFT JOIN artefact subject ON r.subject_id = subject.id
                LEFT JOIN artefact_epos_descriptorset dset ON r.descriptorset_id = dset.id
                LEFT JOIN usr u ON r.evaluator_id = u.id
                WHERE inquirer_id = ?
                    AND response_date IS NULL
                ORDER BY inquiry_date DESC
                LIMIT 5
                ";
        if ($records = get_records_sql_array($sql, array($USER->get('id')))) {
            foreach ($records as $record) {
                $evaluator = array('username' => $record->evaluator_username,
                                  'firstname' => $record->evaluator_firstname,
                                  'lastname' => $record->evaluator_lastname);
                $request = new self(0, $record);
                $request->evaluator = $evaluator;
                $requests []= $request;
            }
        }
        usort($requests, function ($left, $right) {
                $left_value = isset($left->response_date) ? $left->response_date : $left->inquiry_date;
                $right_value = isset($right->response_date) ? $right->response_date : $right->inquiry_date;
                return $left_value > $right_value ? -1 : 1;
        });
        return $requests;
    }



    public static function form_create_evaluation_request($subject=null, $descriptorset=null) {
        $subject_options = array();
        $all_subjects = ArtefactTypeSubject::get_all_subjects();
        foreach ($all_subjects as $subject_instance) {
            $subject_options[$subject_instance->get('id')] = $subject_instance->get('title');
        }
        if (empty($subject)) {
            reset($all_subjects);
            $first_subject = current($all_subjects);
            $subject = $first_subject->get('id');
        }
        $descriptorsets = Descriptorset::get_descriptorsets_for_mysubject_records($subject);
        $descriptorset_options = array();
        foreach ($descriptorsets as $descriptorset_record) {
            $descriptorset_options[$descriptorset_record->id] = $descriptorset_record->name;
        }
        if (empty($descriptorset)) {
            $descriptorset = Descriptorset::get_default_descriptorset_for_subject_record($subject);
            $descriptorset = $descriptorset ? $descriptorset->id : null;
        }
        $elements = array();
        $elements['subject'] = array(
            'type' => 'select',
            'title' => get_string('subjectform.subject', 'artefact.epos'),
            'options' => $subject_options,
            'defaultvalue' => $subject,
            'rules' => array('required' => true)
        );
        $elements['descriptorset'] = array(
            'type' => 'select',
            'title' => get_string('descriptorset', 'artefact.epos'),
            'options' => $descriptorset_options,
            'defaultvalue' => $descriptorset,
            'rules' => array('required' => true)
        );
        $elements['evaluator'] = array(
            'type' => 'text',
            'title' => get_string('evaluator', 'artefact.epos'),
            'rules' => array('required' => true)
        );
        $elements['evaluator_search'] = array(
            'type' => 'html',
            'value' => "<div>Search User</div>"
        );
        $elements['message'] = array(
            'type' => 'textarea',
            'width' => '600px',
            'rows' => 4,
            'title' => get_string('message')
        );
        $elements['submit'] = array(
            'type' => 'submit',
            'value' => get_string('sendrequest', 'artefact.epos')
        );
        return pieform(array(
            'name' => 'create_evaluation_request',
            'plugintype' => 'artefact',
            'pluginname' => 'epos',
            'elements' => $elements,
            'validatecallback' => array('EvaluationRequest', "form_create_evaluation_request_validate"),
            'successcallback' => array('EvaluationRequest', "form_create_evaluation_request_submit")
        ));
    }

    public static function form_create_evaluation_request_validate(Pieform $form, $values) {
        global $USER;
        if ($values['evaluator']) {
            $user_ids = username_to_id(array($values['evaluator']));
            if (empty($user_ids)) {
                $form->set_error('evaluator', get_string('invalidusername', 'artefact.epos'));
            }
            else if ($user_ids[$values['evaluator']] == $USER->get('id')) {
                $form->set_error('evaluator', get_string('cannotevaluateyourself', 'artefact.epos'));
            }
        }
        if (!Descriptorset::is_valid_descriptorset_for_subject($values['descriptorset'], $values['subject'])) {
            $form->set_error('descriptorset', get_string('invaliddescriptorsetforsubject', 'artefact.epos'));
        }
    }

    public static function form_create_evaluation_request_submit(Pieform $form, $values) {
        global $USER, $SESSION;
        $evaluator_id = username_to_id(array($values['evaluator']));
        $evaluator_id = $evaluator_id[$values['evaluator']];
        $request = new EvaluationRequest();
        $request->descriptorset_id = $values['descriptorset'];
        $request->subject_id = $values['subject'];
        $request->evaluator_id = $evaluator_id;
        $request->inquirer_id = $USER->get('id');
        $request->inquiry_message = $values['message'];
        $request->commit();
        $SESSION->add_info_msg(get_string('successfullysentrequest', 'artefact.epos'));
        redirect(get_config('wwwroot') . 'artefact/epos/evaluation/external.php');
    }

    public static function form_return_evaluation_request($request) {
        $options = array(
                0 => get_string('doreturnrequest', 'artefact.epos'),
                1 => get_string('dontreturnrequest', 'artefact.epos')
        );
        $default = isset($request->evaluation_id) ? 0 : 1;
        $elements = array();
        $elements['action'] = array(
            'type' => 'radio',
            'title' => get_string('action', 'artefact.epos'),
            'options' => $options,
    		'defaultvalue' => $default
        );
        $elements['message'] = array(
            'type' => 'textarea',
            'width' => '600px',
            'rows' => 4,
            'title' => get_string('message')
        );
        $elements['submit'] = array(
            'type' => 'submit',
            'value' => get_string('returnrequest', 'artefact.epos')
        );
        return pieform(array(
            'name' => 'create_evaluation_request',
            'plugintype' => 'artefact',
            'pluginname' => 'epos',
            'elements' => $elements,
            'validatecallback' => array('EvaluationRequest', "form_return_evaluation_request_validate"),
            'successcallback' => array('EvaluationRequest', "form_return_evaluation_request_submit")
        ));
    }

    public static function form_return_evaluation_request_validate(Pieform $form, $values) {
        global $request;
        if ($values['action'] == 0 && empty($request->evaluation_id)) {
            $form->set_error('action', get_string('noevaluationtoreturn', 'artefact.epos'));
        }
    }

    public static function form_return_evaluation_request_submit(Pieform $form, $values) {
        global $request, $USER, $SESSION;
        if ($USER->get('id') != $request->evaluator_id) {
            throw new AccessDeniedException(get_string('yourenottheevaluator', 'artefact.epos'));
        }
        db_begin();
        $evaluation = new ArtefactTypeEvaluation($request->evaluation_id);
        $request->response_message = $values['message'];
        $request->response_date = time();
        if ($request->evaluation_id && $values['action']) {
            // an evaluation has been created but should no be returned, so delete it
            $request->evaluation_id = null;
            $request->commit();
            $evaluation->delete();
        }
        else {
            $evaluation->final = 1;
            $evaluation->commit();
            $request->commit();
        }
        db_commit();
        $SESSION->add_info_msg(get_string('successfullyreturnedrequest', 'artefact.epos'));
        redirect('/artefact/epos/evaluation/external.php');
    }

}
