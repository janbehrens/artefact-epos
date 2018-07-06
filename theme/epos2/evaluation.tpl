<!-- Adapt the table to a mobile screen -->
<div class="table-sm">
    <div class="levels">
        {foreach $levels key=level_id item=level}
        <a class="btn btn-default" href="#{$level_id}">{$level}</a>
        {/foreach}        
    </div>
    <div class="results"></div>
</div>

<div class="table-lg">
    {$evaltable|safe}
</div>

<div id="evaluationform_div" class="evaluationform" style="display:none;">
    <h2 id="evaluationform_heading"></h2>
    <a id="toggle_detailed_evaluation" onclick="toggleOverallEvaluation(false)">({get_string 'evaluationtypedescriptor', 'artefact.epos'})</a>
    <a id="toggle_overall_evaluation" onclick="toggleOverallEvaluation(true)">({get_string 'evaluationtypecompetencelevel', 'artefact.epos'})</a>
    {$evaluationform|safe}
</div>
