{$evaltable|safe}

<div id="evaluationform_div" class="evaluationform" style="display:none;">
    <h2 id="evaluationform_heading"></h2>
    <a id="toggle_detailed_evaluation" onclick="toggleOverallEvaluation(false)">({get_string 'evaluationtypedescriptor', 'artefact.epos'})</a>
    <a id="toggle_overall_evaluation" onclick="toggleOverallEvaluation(true)">({get_string 'evaluationtypecompetencelevel', 'artefact.epos'})</a>
    {$evaluationform|safe}
</div>
