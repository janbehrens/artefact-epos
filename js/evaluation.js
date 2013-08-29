function toggleEvaluationForm(comp, level, type) {
    var formDivId = '#evaluationform_' + comp + '_' + level + '_' + type + '_div';
    var allforms = $j('div[id^=evaluationform_]');
    allforms.addClass('hidden');
    $j(formDivId).removeClass('hidden');
    if (type == 0) {
        $j('#customdescriptorform').removeClass('hidden');
    }
    if (type == 1) {
        $j('#customdescriptorform').addClass('hidden');
    }
    $j('#adddescriptor_competence').val(comp);
    $j('#adddescriptor_level').val(level);
}

function checklistSaveCallback(form, data) {
    window.location.reload();
}

function openPopup(url) {
    $j('<div id=\"example_popup\"></div>').modal({overlayClose:true, closeHTML:''});
    $j('<iframe src=\"' + url + '\">').appendTo('#example_popup');
}