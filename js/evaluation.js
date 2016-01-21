$j = jQuery;

var args;

function toggleEvaluationForm(competence, level, type, competenceName, levelName, toggleType) {
    args = {
        competence: competence,
        level: level,
        type: type,
        competenceName,
        levelName: levelName
    };
    var form = $j('#evaluationform_div');
    var formSections = $j('[id^=evaluationform_item_]').parent('tr');
    var formSectionDescriptor = $j('[id^=evaluationform_item_' + competence + '_' + level + '_0_]').parent('tr');
    var formSectionComplevel = $j('[id^=evaluationform_item_' + competence + '_' + level + '_1_]').parent('tr');
    var formSectionCustomgoal = $j('[id^=evaluationform_item_' + competence + '_0_2_]').parent('tr');
    var goalHeader = $j('#evaluationform_header_goal_container').parent();
    var overallHeader = $j('#evaluationform_item_' + competence + '_' + level + '_overall_container').parent();
    var overallCheckbox = $j('#evaluationform_item_' + competence + '_' + level + '_overall');
    var toggleDetailedEvaluation = $j('#toggle_detailed_evaluation');
    var toggleOverallEvaluation = $j('#toggle_overall_evaluation');
    var heading = $j('#evaluationform_heading');

    form.show();
    formSections.hide();
    goalHeader.show();
    if (type === null) {
        type = overallCheckbox.attr('checked') ? 1 : 0;
    }
    if (type === 0) {
        if (toggleType) {
            overallCheckbox.attr('checked', false);
        }
        formSectionDescriptor.show();
        toggleDetailedEvaluation.hide();
        toggleOverallEvaluation.show();
    }
    else if (type === 1) {
        if (toggleType) {
            overallCheckbox.attr('checked', true);
        }
        formSectionComplevel.show();
        goalHeader.hide();
        toggleDetailedEvaluation.show();
        toggleOverallEvaluation.hide();
    }
    else if (type === 2) {
        formSectionCustomgoal.show();
        toggleDetailedEvaluation.hide();
        toggleOverallEvaluation.hide();
    }
    heading.html(type < 2 ? competenceName + ' – ' + levelName : competenceName);
    $j('#addcustomgoal_customcompetence').val(type === 2 ? competenceName : '');
}

function evaluationSaveCallback(form, data) {
    $j('#evaluationform_div').hide();
    window.location.reload();
}

function openPopup(url) {
    $j('<div id=\"example_popup\"></div>').modal({overlayClose:true, closeHTML:''});
    $j('<iframe src=\"' + url + '\">').appendTo('#example_popup');
}
