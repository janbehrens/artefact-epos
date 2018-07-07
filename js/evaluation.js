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
 * @author     TZI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2013 TZI / Universität Bremen
 *
 */

$j = jQuery;

var args;
var form, formSections, formSectionDescriptor, formSectionComplevel, formSectionCustomgoal, formSectionOverall;
var heading, goalHeader, overallCheckbox, isOverall, toggleDetailedEvaluationLink, toggleOverallEvaluationLink;

function toggleEvaluationForm(competence, level, competenceName, levelName) {
    args = {
        competence: competence,
        level: level,
        competenceName: competenceName,
        levelName: levelName
    };
    form = $j('#evaluationform_div');
    formSections = $j('[id^=evaluationform_item_]').parent('tr');
    formSectionDescriptor = $j('[id^=evaluationform_item_' + competence + '_' + level + '_]').parent('tr');
    formSectionComplevel = $j('#evaluationform_item_' + competence + '_' + level + '_container').parent('tr');
    formSectionCustomgoal = $j('[id^=evaluationform_item_' + competence + '_0_]').parent('tr');
    formSectionOverall = $j('#evaluationform_item_' + competence + '_' + level + '_overall_container').parent('tr');
    heading = $j('#evaluationform_heading');
    goalHeader = $j('#evaluationform_header_goal_container').parent();
    overallCheckbox = $j('#evaluationform_item_' + competence + '_' + level + '_overall');
    isOverall = overallCheckbox.attr('checked');
    toggleDetailedEvaluationLink = $j('#toggle_detailed_evaluation');
    toggleOverallEvaluationLink = $j('#toggle_overall_evaluation');

    form.show();
    formSections.hide();

    if (isOverall) {
        formSectionComplevel.show();
        goalHeader.hide();
        toggleDetailedEvaluationLink.show();
        toggleOverallEvaluationLink.hide();
    }
    else {
        formSectionDescriptor.show();
        formSectionOverall.hide();
        formSectionComplevel.hide();
        goalHeader.show();
        toggleDetailedEvaluationLink.hide();
        toggleOverallEvaluationLink.show();
    }
    // custom competence
    if (level === 0) {
        formSectionCustomgoal.show();
        goalHeader.show();
        toggleDetailedEvaluationLink.hide();
        toggleOverallEvaluationLink.hide();
    }
    heading.html(competenceName + ' – ' + levelName);
    heading.html(level === 0 ? competenceName : competenceName + ' – ' + levelName);
    $j('#addcustomgoal_customcompetence').val(level === 0 ? competenceName : '');
}

function toggleOverallEvaluation(overall) {
    if (!overall) {
        overallCheckbox.attr('checked', false);
        formSectionDescriptor.show();
        formSectionOverall.hide();
        formSectionComplevel.hide();
        goalHeader.show();
        toggleDetailedEvaluationLink.hide();
        toggleOverallEvaluationLink.show();
    }
    else {
        overallCheckbox.attr('checked', true);
        formSectionDescriptor.hide();
        formSectionComplevel.show();
        goalHeader.hide();
        toggleDetailedEvaluationLink.show();
        toggleOverallEvaluationLink.hide();
    }
}

function evaluationSaveCallback(form, data) {
    $j('#evaluationform_div').hide();
    window.location.reload();
}

function openPopup(url) {
    var iframe = $j('#example-popup').children('iframe');
    iframe.attr('src', url);
    iframe.on('load', function () {
        $j('#example-popup-frame').show();
    });
    return false;
}

function toggleCustomGoalFormModal(e) {
    var form = $('#customgoalform .form-body');
    var modal = $('#customgoalformModel');
    modal.find('.modal-body').append(form);
    modal.modal('show');
    // once the modal show it will keep add competence button show
    $('#customgoalform').css({display:'none'});
    $(e.currentTarget).css({display:'block'});
}

function switchLevel (levelId) {
    // var levels = $('#competenceLevelList');
    var table = $('table.evaluation');
    table.find('.level-grid').removeClass('selected');
    table.find('.level-grid.level' + levelId).addClass('selected');
}