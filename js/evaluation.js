$j = jQuery;

function toggleEvaluationForm(comp, level, type, competence) {
    var formDivId = '#evaluationform_' + comp + '_' + level + '_' + type + '_div';
    var allforms = $j('div[id^=evaluationform_]');
    allforms.addClass('hidden');
    $j(formDivId).removeClass('hidden');
    $j('th').removeClass('hidden');
    $j('[id$=_description_container]').addClass('hidden');
    if (type == 2) {
    	$j('#addcustomgoal_customcompetence').val(competence);
    }
}

function evaluationSaveCallback(form, data) {
    window.location.reload();
    $j('th').addClass('hidden');
}

function openPopup(url) {
    $j('<div id=\"example_popup\"></div>').modal({overlayClose:true, closeHTML:''});
    $j('<iframe src=\"' + url + '\">').appendTo('#example_popup');
}
