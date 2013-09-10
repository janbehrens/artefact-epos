function toggleEvaluationForm(comp, level, type, competence) {
    var formDivId = '#evaluationform_' + comp + '_' + level + '_' + type + '_div';
    var allforms = $j('div[id^=evaluationform_]');
    allforms.addClass('hidden');
    $j(formDivId).removeClass('hidden');
    if (type == 2) {
    	$j('#addcustomgoal_customcompetence').val(competence);
    }
}

function checklistSaveCallback(form, data) {
    window.location.reload();
}

function openPopup(url) {
    $j('<div id=\"example_popup\"></div>').modal({overlayClose:true, closeHTML:''});
    $j('<iframe src=\"' + url + '\">').appendTo('#example_popup');
}