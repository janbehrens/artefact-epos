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
$string['goals'] = 'Learning Objectives';
$string['selfevaluation'] = 'Self-evaluation';
$string['dossier'] = 'Dossier';
$string['diary'] = 'Diary';
$string['biography'] = 'Biography';
$string['mylanguages'] = 'My Languages';
$string['myexperience'] = 'My Experience';
$string['mydiary'] = 'My Diary';
$string['templates'] = 'Templates';

//interaction
$string['add'] = 'Add';
$string['cancel'] = 'Cancel';
$string['del'] = 'Delete';
$string['edit'] = 'Edit';
$string['save'] = 'Save';

//notifications
$string['addedlanguage'] = 'Language has been added.';
$string['confirmdel'] = 'Are you sure you want to delete this language?';
$string['deletedlanguage'] = 'Language has been deleted.';
$string['nolanguageselected1'] = 'You have not selected any languages. Go to "';
$string['nolanguageselected2'] = '" to add one.';
$string['savedchecklist'] = 'Your checklist has been saved.';

//vocabulary
$string['competence'] = 'Competence';
$string['level'] = 'Competence level';
$string['descriptors'] = 'Descriptors';
$string['descriptorset'] = 'Descriptor set';
$string['languages'] = 'Languages';
$string['subject'] = 'Subject';
$string['subjects'] = 'Subjects';
$string['goal'] = 'Goal';

//add subject form
$string['subjectform.subject'] = 'Subject';
$string['subjectform.title'] = 'Title';
$string['subjectform.descriptorset'] = 'Descriptors';

//help text
$string['helpselfevaluation'] = 'Click on one of the bars in order to evaluate your expertise in the selected area of competence and level.';

//custom learning goal
$string['customlearninggoal'] = 'Additional learning objective';
$string['customlearninggoalupdatesuccess'] = "Learning objective has been updated.";
$string['customlearninggoaldeleted'] = 'Learning objective has been removed.';
$string['customlearninggoalwanttodelete'] = 'Are you sure you really want to delete this additional learning objectiv?';

//Selfevaluation Template Editor
$string['create_selfevaluation_template'] = 'Templates for Self-evaluation'; 
$string['num_evaluation_levels'] = 'Number of evaluation levels';
$string['name_evaluation_grid'] = 'Name of evaluation grid';
$string['num_rows'] = 'Number of competences';
$string['num_cols'] = 'Number of levels';
$string['evaluationlevel'] = 'Evaluation level&nbsp;';
$string['competency_name'] = 'Competence&nbsp;';
$string['competency_level'] = 'Level&nbsp;';
$string['cando_statement'] = 'Can-Do statement';
$string['tasklink'] = 'Task link';

//self-evaluation template management
$string['loaddescriptorsetsuccess'] = 'Successfully installed descriptor set';
$string['unloaddescriptorsetsuccess'] = 'Successfully uninstalled descriptor set';
$string['unloaddescriptorsetfailed'] = 'Uninstalling descriptor set failed: Descriptors are in use.';

?>
