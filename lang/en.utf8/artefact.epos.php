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
 * @copyright  (C) 2011 Jan Behrens, jb3@informatik.uni-bremen.de
 *
 */

defined('INTERNAL') || die();

//general
$string['pluginname'] = 'epos';
$string['goals'] = 'Learning objectives';
$string['selfevaluation'] = 'Self-evaluation';
$string['dossier'] = 'Dossier';
$string['diary'] = 'Diary';
$string['biography'] = 'Biography';
$string['languages'] = 'Subjects';
$string['mylanguages'] = 'My subjects';
$string['mylanguage'] = 'My subject';
$string['myexperience'] = 'My experience';
$string['mydiary'] = 'My diary';
$string['templates'] = 'Templates';

//interaction
$string['add'] = 'Add';
$string['cancel'] = 'Cancel';
$string['del'] = 'Delete';
$string['edit'] = 'Edit';
$string['save'] = 'Save';

//notifications
$string['addedlanguage'] = 'Subject has been added.';
$string['confirmdel'] = 'Are you sure you want to delete this subject?';
$string['deletedlanguage'] = 'Subject has been deleted.';
$string['nolanguageselected1'] = 'You have not selected any subjects. Go to "';
$string['nolanguageselected2'] = '" to add one.';
$string['savedchecklist'] = 'Your checklist has been saved.';
$string['titlenotvalid'] = 'Title is not valid.';
$string['descriptorsetnotvalid'] = 'Competence grid is not valid.';
$string['pleasechoosesubject'] = 'Please choose a subject first';

//vocabulary
$string['competence'] = 'Competence';
$string['level'] = 'Competence level';
$string['descriptors'] = 'Descriptors';
$string['descriptorset'] = 'Competence grid';
$string['subject'] = 'Subject';
$string['subjects'] = 'Subjects';
$string['competencegrid'] = 'Competence grid';
$string['goal'] = 'Goal';
$string['institution'] = 'Institution';
$string['exampletask'] = 'example/task';

//add subject form
$string['subjectform.subject'] = 'Subject';
$string['subjectform.title'] = 'Title';
$string['subjectform.descriptorset'] = 'Competence grid';

//biography
$string['biography'] = 'Biography';
$string['biographies'] = 'Biographies';
$string['youarenottheownerofthisbiography'] = 'You are not the owner of this biography';
$string['biographysettings'] = 'Biography Settings';
$string['deletebiography?'] = 'Are you sure you want to delete this biography?';
$string['compositedeleteconfirm'] = 'Are you sure you want to delete this?';
$string['moveup'] = 'Move Up';
$string['movedown'] = 'Move Down';
$string['educationhistory'] = 'Learning experience and qualifications';
$string['biographyform.name'] = 'Label for the experience';
$string['biographyform.startdate'] = 'Start date';
$string['biographyform.enddate'] = 'End date (if already finished)';
$string['biographyform.place'] = 'Place of experience (school, course, job, leisure etc.)';
$string['biographyform.subject'] = 'Subject';
$string['biographyform.level'] = 'Level (A1...C2 or low, medium, high or similar)';
$string['biographyform.description'] = 'Description of the learning experience and learning outcome';
$string['compositesaved'] = 'Saved successfully';
$string['compositesavefailed'] = 'Save failed';
$string['biographydeleted'] = 'Biography deleted';
$string['newbiography'] = 'New Biography';
$string['biographytitle'] = 'Title';
$string['biographytitledesc'] = 'e.g., ‘School education’.';
$string['biographydesc'] = 'Description';
$string['biographydescdesc'] = '';
$string['createbiography'] = 'Create Biography';
$string['savesettings'] = 'Save Settings';
$string['viewbiography'] = 'View Biography';
$string['youhavenobiographies'] = 'You have no biographies.';
$string['addbiography'] = 'Create Biography';
$string['startdate'] = 'Start date';
$string['enddate'] = 'End date';
$string['qualification'] = 'Qualification';

//help text
$string['helpselfevaluation'] = 'Click on one of the bars in order to evaluate your expertise in the selected area of competence and level.';

//custom learning goal
$string['customlearninggoal'] = 'Additional learning objective';
$string['customlearninggoalupdatesuccess'] = 'Learning objective has been updated.';
$string['customlearninggoaldeleted'] = 'Learning objective has been removed.';
$string['customlearninggoalwanttodelete'] = 'Are you sure you want to delete this additional learning objective?';

//Selfevaluation Template Editor
$string['create_selfevaluation_template'] = 'Templates for Self-evaluation'; 
$string['num_evaluation_levels'] = 'Number of self-evaluation levels';
$string['name_evaluation_grid'] = 'Name of competence grid';
$string['num_rows'] = 'Number of competences';
$string['num_cols'] = 'Number of competence level areas';
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

//self-evaluation template management
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
$string['importeddescriptorset'] = 'Successfully imported competence grid';
$string['confirmdeletedescriptorset1'] = 'Are you sure you want to permanently delete the competence grid ';
$string['confirmdeletedescriptorset2'] = '';
$string['nosubjectsconfigured1'] = 'There are no subjects configured in ';
$string['nosubjectsconfigured2'] = '. Go to ';
$string['nosubjectsconfigured3'] = ' to add one.';
$string['subjectsadministration'] = 'Subjects administration';

?>
