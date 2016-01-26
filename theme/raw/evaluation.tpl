{$evaltable|safe}

<div id="evaluationform_div" class="evaluationform hidden">
    <h2 id="evaluationform_heading"></h2>
    <a id="toggle_detailed_evaluation" onclick="toggleEvaluationForm(args.competence, args.level, 0, args.competenceName, args.levelName, true)">({get_string 'evaluationtypedescriptor', 'artefact.epos'})</a>
    <a id="toggle_overall_evaluation" onclick="toggleEvaluationForm(args.competence, args.level, 1, args.competenceName, args.levelName, true)">({get_string 'evaluationtypecompetencelevel', 'artefact.epos'})</a>
    {$evaluationform|safe}
</div>
