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

    public $inquirer;

    public $inquirer_evaluation;

    public $evaluator;

    public $evaluator_evaluation;

    public $descriptorset;

    public $inquiry_date;

    public $inquiry_message;

    public $response_date;

    public $response_message;

    public $title;

    public $final;

    public function __construct($id = 0, $data = null) {
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
                'inquirer' => $this->inquirer,
                'inquirer_evaluation' => $this->inquirer_evaluation,
                'evaluator' => $this->evaluator,
                'evaluator_evaluation' => $this->evaluator_evaluation,
                'descriptorset' => $this->descriptorset,
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
     * Get the requests other users have sent to the current user.
     */
    public static function get_requests_for_evaluator() {
        global $USER;
        $sql = "SELECT r.*, e.final, a.title,
                       dset.name AS descriptorset,
                       u1.firstname AS inquirer_firstname,
                       u1.lastname AS inquirer_lastname,
                       u2.firstname AS evaluator_firstname,
                       u2.lastname AS evaluator_lastname
                FROM artefact_epos_evaluation_request r
                LEFT JOIN artefact_epos_evaluation e ON r.evaluator_evaluation = e.artefact
                LEFT JOIN artefact_epos_evaluation ie ON r.inquirer_evaluation = ie.artefact
                LEFT JOIN artefact a ON a.id = ie.artefact
                LEFT JOIN artefact_epos_descriptorset dset ON ie.descriptorset = dset.id
                LEFT JOIN usr u1 ON r.inquirer = u1.id
                LEFT JOIN usr u2 ON r.evaluator = u2.id
                WHERE r.evaluator = ?
                ORDER BY response_date DESC, inquiry_date DESC";
        if ($records = get_records_sql_array($sql, array($USER->get('id')))) {
            $requests = array();
            foreach ($records as $record) {
                $request = new self(0, $record);
                $request->inquirerfirstname = $record->inquirer_firstname;
                $request->inquirerlastname = $record->inquirer_lastname;
                $request->evaluatorfirstname = $record->evaluator_firstname;
                $request->evaluatorlastname = $record->evaluator_lastname;
                $requests []= $request;
            }
            return $requests;
        }
        else {
            return array();
        }
    }

    /**
     * Get the requests of the current user (either recently
     * sent or recently returned).
     */
    public static function get_requests_for_inquirer() {
        global $USER;
        $requests = array();
        $sql = "SELECT r.*, e.final, a.title,
                       dset.name AS descriptorset,
                       u.firstname AS evaluator_firstname,
                       u.lastname AS evaluator_lastname
                FROM artefact_epos_evaluation_request r
                LEFT JOIN artefact_epos_evaluation e ON r.evaluator_evaluation = e.artefact
                LEFT JOIN artefact_epos_evaluation ie ON r.inquirer_evaluation = ie.artefact
                LEFT JOIN artefact a ON a.id = ie.artefact
                LEFT JOIN artefact_epos_descriptorset dset ON ie.descriptorset = dset.id
                LEFT JOIN usr u ON r.evaluator = u.id
                WHERE r.inquirer = ?
                ORDER BY response_date DESC, inquiry_date DESC";
        if ($records = get_records_sql_array($sql, array($USER->get('id')))) {
            foreach ($records as $record) {
                $request = new self(0, $record);
                $request->evaluatorfirstname = $record->evaluator_firstname;
                $request->evaluatorlastname = $record->evaluator_lastname;
                $requests []= $request;
            }
        }
        return $requests;
    }

    public static function form_create_evaluation_request($subject = null, $descriptorset = null) {
        global $USER;
        global $descriptorset_ids;
        $owner = $USER->get('id');
        $sql = "SELECT a.*, e.*
                FROM artefact a
                INNER JOIN artefact_epos_evaluation e ON a.id = e.artefact
                WHERE a.artefacttype = 'evaluation' AND a.owner = ? AND e.final = 0";
        if (!$data = get_records_sql_array($sql, array($owner))) {
            $data = array();
        }
        $evaluation_options = array();
        $descriptorset_ids = array();
        foreach ($data as $evaluation) {
            $evaluation_options[$evaluation->id] = "$evaluation->title ($evaluation->description)";
            $descriptorset_ids[$evaluation->id] = $evaluation->descriptorset;
        }
        if (empty($evaluation_options)) {
            return null;
        }

        return pieform(array(
            'name' => 'create_evaluation_request',
            'elements' => array(
                'evaluation' => array(
                    'type' => 'select',
                    'title' => get_string('selfevaluation', 'artefact.epos'),
                    'options' => $evaluation_options,
                    'rules' => array('required' => true)
                ),
                'evaluator' => array(
                    'type' => 'text',
                    'title' => get_string('evaluator', 'artefact.epos'),
                    'rules' => array('required' => true)
                ),
                'message' => array(
                    'type' => 'textarea',
                    'width' => '600px',
                    'rows' => 4,
                    'title' => get_string('message')
                ),
                'submit' => array(
                    'type' => 'submit',
                    'value' => get_string('sendrequest', 'artefact.epos')
                )
            ),
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
    }

    public static function form_create_evaluation_request_submit(Pieform $form, $values) {
        safe_require('notification', 'internal');
        global $USER, $SESSION;

        $evaluator_id = username_to_id(array($values['evaluator']));
        $evaluator_id = $evaluator_id[$values['evaluator']];
        $inquirerevaluation = new ArtefactTypeEvaluation($values['evaluation']);
        $inquirerevaluation->evaluator = $evaluator_id;
        $inquirerevaluation->commit();

        $request = new EvaluationRequest();
        $request->inquirer_evaluation = $values['evaluation'];
        $request->descriptorset = $inquirerevaluation->descriptorset_id;
        $request->evaluator = $evaluator_id;
        $request->inquirer = $USER->get('id');
        $request->inquiry_message = $values['message'];
        $request->commit();

        $SESSION->add_info_msg(get_string('successfullysentrequest', 'artefact.epos'));

        // notify user
        if (is_plugin_active('internal')) {
            $inquirer = get_user($request->inquirer);
            $evaluator = get_user($request->evaluator);
            $data = new stdClass();
            $data->type = 1;
            $data->subject = get_string('evaluationrequestsent', 'artefact.epos');
            $data->message = get_string('evaluationrequestsentmessage', 'artefact.epos', "$inquirer->firstname $inquirer->lastname", $inquirerevaluation->get('title'));
            $data->url = 'artefact/epos/evaluation/external.php';
            $data->parent = null;
            PluginNotificationInternal::notify_user($evaluator, $data);
        }

        redirect(get_config('wwwroot') . 'artefact/epos/evaluation/external.php');
    }

    public static function form_return_evaluation_request($request) {
        $elements = array();
        $elements['includeevaluation'] = array(
            'type' => 'checkbox',
            'title' => get_string('includeevaluation', 'artefact.epos'),
            'defaultvalue' => 1
        );
        $elements['message'] = array(
            'type' => 'textarea',
            'width' => '600px',
            'rows' => 4,
            'title' => get_string('message')
        );
        $elements['submit'] = array(
            'type' => 'submit',
            'value' => get_string('submit')
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
    }

    public static function form_return_evaluation_request_submit(Pieform $form, $values) {
        safe_require('notification', 'internal');
        global $request, $USER, $SESSION;

        if ($USER->get('id') != $request->evaluator) {
            throw new AccessDeniedException(get_string('yourenottheevaluator', 'artefact.epos'));
        }

        db_begin();
        $request->response_message = $values['message'];
        $request->response_date = time();
        if ($request->evaluator_evaluation) {
            $evaluation = new ArtefactTypeEvaluation($request->evaluator_evaluation);
            if ($values['includeevaluation']) {
                $evaluation->final = 1;
                $evaluation->commit();
            }
        }
        $request->commit();
        db_commit();

        $SESSION->add_info_msg(get_string('successfullyreturnedrequest', 'artefact.epos'));

        // notify user
        if (is_plugin_active('internal')) {
            $inquirer = get_user($request->inquirer);
            $evaluator = get_user($request->evaluator);
            $data = new stdClass();
            $data->type = 1;
            $data->subject = get_string('evaluationrequestanswered', 'artefact.epos');
            $data->message = get_string('evaluationrequestansweredmessage', 'artefact.epos', "$evaluator->firstname $evaluator->lastname", $evaluation->get('title'));
            $data->url = 'artefact/epos/evaluation/external.php';
            $data->parent = null;
            PluginNotificationInternal::notify_user($inquirer, $data);
        }

        redirect('/artefact/epos/evaluation/external.php');
    }
}
