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
 * @author     Jan Behrens
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2011-2013 TZI / Universität Bremen
 *
 */

defined('INTERNAL') || die();

//general
$string['pluginname'] = 'epos';
$string['goals'] = 'Learning objectives';
$string['dossier'] = 'Dossier';
$string['diary'] = 'Diary';
$string['biography'] = 'Biography';
//$string['languages'] = 'Subjects';
//$string['mylanguages'] = 'My subjects';
$string['myexperience'] = 'My experience';
$string['mydiary'] = 'My diary';
$string['templates'] = 'Templates';
$string['current'] = 'current';

//self-evaluations
$string['myselfevaluations'] = 'My self-evaluations';
$string['selfevaluations'] = 'Self-evaluations';
$string['addremoveevaluations'] = 'Add/remove self-evaluations';
$string['label'] = 'Label';

//interaction
$string['add'] = 'Add';
$string['cancel'] = 'Cancel';
$string['del'] = 'Delete';
$string['edit'] = 'Edit';
$string['save'] = 'Save';
$string['print'] = 'Print';
$string['back'] = 'Back';
$string['close'] = 'Close';

//notifications
$string['addedlanguage'] = 'Subject has been added.';
$string['confirmdel'] = 'Are you sure you want to delete this subject?';
$string['deletedlanguage'] = 'Subject has been deleted.';
$string['nolanguageselected'] = 'You have not selected any subjects. Go to %s to add one.';
$string['savedevaluation'] = 'Your evaluation has been saved.';
$string['labelnotvalid'] = 'Label is not valid.';
$string['descriptorsetnotvalid'] = 'Competence grid is not valid.';
$string['pleasechoosesubject'] = 'Please choose a subject first';

//vocabulary
$string['competence'] = 'Competence area';
$string['level'] = 'Competence level';
$string['descriptors'] = 'Descriptors';
$string['descriptorset'] = 'Competence grid';
$string['language'] = 'My subject';
$string['subject'] = 'Subject';
$string['subjects'] = 'Subjects';
$string['competencegrid'] = 'Competence grid';
$string['goal'] = 'Goal';
$string['institution'] = 'Institution';
$string['exampletask'] = 'example/task';

//help text
$string['helpselfevaluation'] = 'Click on one of the bars in order to evaluate your expertise in the selected area of competence and level.';

//custom competences
$string['customcompetencearea'] = 'Custom Competence Area';
$string['standardcompetencearea'] = 'Standard Competence Area';
$string['addcustomgoalformtitle'] = 'Add further goals';
$string['addcustomcompetenceformtitle'] = 'Add further competences';
$string['customlearninggoal'] = 'Additional learning objective';
$string['customgoaldefaulttitle'] = 'My additional goals';
$string['customlearninggoalupdatesuccess'] = 'Learning objective has been updated.';
$string['customlearninggoaldeleted'] = 'Learning objective has been removed.';
$string['customlearninggoalwanttodelete'] = 'Are you sure you want to delete this additional learning objective?';
$string['customgoalsonlyincustomcompetence'] = 'Additional goals can only be added to your own competences. In order to create a new competence, enter its name.';
$string['customgoalalreadyexistsincompetence'] = 'The goal you entered already exists in the selected competence area.';

//Descriptor sets
$string['descriptorsetnotfound'] = 'Could not find requested descriptor set';

//Evaluation
$string['evaluation'] = 'Evaluation';
$string['selfevaluation'] = 'Self-evaluation';
$string['evaluationformtitle'] = '%s – %s';
$string['evaluationnotfound'] = 'The requested evaluation cannot be found.';
$string['overallrating'] = "Overall rating for this competence area on this level";
$string['evaluationtypedescriptor'] = "Switch to detailed evaluation";
$string['evaluationtypecompetencelevel'] = "Switch to overall evaluation";
$string['youarenottheownerofthisevaluation'] = 'You may not view/edit this evaluation, it is owned by someone else';
$string['noevaluationsforuser'] = 'You do not yet have any self-evaluations.';

// Stored Evaluations
$string['storeevaluation'] = "Store";
$string['storedevaluations'] = "Stored Evaluations";
$string['evaluationname'] = "Name for evaluation";
$string['creationtime'] = "Time of creation";
$string['nostoredevaluations'] = "You have not yet stored any evaluations.";
$string['evaluationnamealreadyexists'] = "An evaluation with this name already exists.";
$string['evaluationsuccessfullystored'] = "Successfully stored your evaluation.";
$string['evaluationisnoteditable'] = "This evaluation is final and cannot be edited.";
$string['deleteevaluation'] = "Delete Evaluation";
$string['confirmdeleteevaluation'] = "Do you want to delete the evaluation %s permanently?";

// External Evaluations
$string['externalevaluations'] = "External Evaluations";
$string['evaluator'] = "Evaluator";
$string['requestexternalevaluation'] = "Request External Evaluation";
$string['returnexternalevaluation'] = "Return External Evaluation";
$string['sendrequest'] = "Send Request";
$string['returnrequest'] = "Return Request";
$string['sentrequest'] = "Sent Request";
$string['returnedrequest'] = "Returned Request";
$string['sentmessage'] = "Sent Message";
$string['returnedmessage'] = "Returned Message";
$string['invalidusername'] = "This user does not exist.";
$string['cannotevaluateyourself'] = "You cannot send an evaluation request to yourself. You can evaluate yourself under 'Self-evaluation'.";
$string['invaliddescriptorsetforsubject'] = "This competence grid cannot be used for this subject. Please choose another one.";
$string['successfullysentrequest'] = "Your request has been sent successfully.";
$string['waitingrequests'] = "Requests for Evaluation";
$string['recentoutgoing'] = "Recent Outgoing Requests";
$string['doreturnrequest'] = "Return the evaluation request";
$string['dontreturnrequest'] = "Don't return the evaluation request";
$string['action'] = "Action";
$string['yourenottheevaluator'] = "You are not the evaluator for this evaluation.";
$string['noevaluationtoreturn'] = "You have not done the requested evaluation and thus cannot return an evaluation.";
$string['noevaluationavailable'] = "no evaluation available";
$string['successfullyreturnedrequest'] = "Your evaluation has been sent successfully.";

//Comparison
$string['comparison'] = "Comparison";
$string['compare'] = "Compare";
$string['comparisonof'] = "Comparison of";
$string['nocomparableevaluations'] = "There are no other evaluations you could compare with the currently selected.";
$string['selectotherevaluation'] = "Select another evaluation to compare with";
$string['useincomparison'] = "Use this evaluation in a comparison.";
$string['noevaluationselected'] = "You have not selected any evaluation for comparison. Please select at least two evaluations.";
$string['by'] = "by";
$string['yourself'] = "yourself";

// Evaluation Template Editor
$string['create_selfevaluation_template'] = 'Templates for Self-evaluation';
$string['num_evaluation_levels'] = 'Number of self-evaluation levels';
$string['name_evaluation_grid'] = 'Name of competence grid';
$string['num_rows'] = 'Number of competence areas';
$string['num_cols'] = 'Number of competence level';
$string['evaluationlevel'] = 'Self-evaluation level&nbsp;';
$string['competency_name'] = 'Competence&nbsp;';
$string['competency_level'] = 'Level&nbsp;';
$string['cando_statement'] = 'Can-do statement';
$string['cando_statements'] = 'Can-do statements';
$string['tasklink'] = 'Task link';
$string['learningobjective_checkbox'] = 'Display checkbox for learning objective';
$string['fill_in_learning_objectives'] = 'Fill in can-do statements and task links for the given combination of competence and level.';
$string['combination_of'] = 'Combination of';
$string['and'] = 'and';
$string['printevaluation'] = 'Print';
$string['enablebackgroundprinting'] = 'Make sure to enable printing of background colors in the printing dialog.';
$string['legendthenumbers'] = 'The figures in the bars indicate the number of "Can-Do Statements" rated with the respective evaluation levels. The first figure is the number of statements rated with "%s", the second one refers to "%s" etc.';

//Descriptor Set Management
$string['availabletemplates'] = 'Available competence grids';
$string['loadtemplatefromfile'] = 'Load competence grid from file';
$string['fromxmlfile'] = 'From XML file';
$string['fromcsvfile'] = 'From CSV file';
$string['createnewtemplate'] = 'Create new competence grid';
$string['edittemplate'] = 'Edit competence grid';
$string['saveasnewtemplate'] = 'Save as new competence grid';
$string['activate'] = 'Activate';
$string['deactivate'] = 'Deactivate';
$string['export'] = 'Export';
$string['xmlfile'] = 'XML file';
$string['csvfile'] = 'CSV file';
$string['nameofdescriptorset'] = 'Name of competence grid';
$string['csvinvalid'] = 'Error: The CSV file is not well-formed';
$string['loaddescriptorsetsuccess'] = 'Successfully installed competence grid';
$string['deletedescriptorsetsuccess'] = 'Successfully deleted competence grid';
$string['deletedescriptorsetfailed'] = 'Deleting competence grid failed: Competence grid is being used';
$string['deletesubjectsuccess'] = 'Successfully deleted subject';
$string['deletesubjectfailed'] = 'Deleting subject failed';
$string['importeddescriptorset'] = 'Successfully imported competence grid';
$string['confirmdeletedescriptorset'] = 'Are you sure you want to permanently delete the competence grid "%s"?';
$string['confirmdeletesubject'] = 'Are you sure you want to permanently delete the subject "%s"? All competence grids associated with this subject will become inaccessible.';
$string['nosubjectsconfigured'] = 'There are no subjects configured in "%s". Go to %s to add one.';
$string['subjectsadministration'] = 'Subjects administration';
