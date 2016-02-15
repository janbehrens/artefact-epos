$j = jQuery;

var args;
var form, formSections, formSectionDescriptor, formSectionComplevel, formSectionCustomgoal, formSectionOverall;
var heading, goalHeader, overallCheckbox, isOverall, toggleDetailedEvaluationLink, toggleOverallEvaluationLink;

function toggleEvaluationForm(competence, level, competenceName, levelName) {
    args = {
        competence: competence,
        level: level,
        competenceName,
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
    $j('<div id=\"example_popup\"></div>').modal({overlayClose:true, closeHTML:''});
    $j('<iframe src=\"' + url + '\">').appendTo('#example_popup');
}
