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

    private $id;

    public $inquirer;

    public $evaluator;

    private $subject_id;

    private $descriptorset_id;

    private $evaluation_id;

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
                'inquirer' => $this->inquirer,
                'evaluator' => $this->evaluator,
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

    public function delete() {
        if (empty($this->id)) {
            return;
        }
        delete_records('artefact_epos_evaluation_request', 'id', $this->id);
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
            'width' => '300px',
            'rows' => 8,
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
        global $USER;
        $evaluator_id = username_to_id(array($values['evaluator']));
        $evaluator_id = $evaluator_id[$values['evaluator']];
        $request = new EvaluationRequest();
        $request->descriptorset_id = $values['descriptorset'];
        $request->subject_id = $values['subject'];
        $request->evaluator = $evaluator_id;
        $request->inquirer = $USER->get('id');
        $request->inquiry_message = $values['message'];
        $request->commit();
        redirect(get_config('wwwroot') . 'artefact/epos/evaluation/external.php'');
    }

}
