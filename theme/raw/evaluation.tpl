{$evaltable|safe}

{foreach $evaluationforms item=competence}
    {foreach $competence item=levelforms}
        {foreach $levelforms.forms item=typeform}
            <div id="{$typeform.name}_div" class="evaluationform hidden">
                <h2>{$levelforms.title}</h2>
                {foreach $typeform.other_types key=type_id item=form_title}
                <a href="#" onclick="toggleEvaluationForm({$levelforms.competence->id}, {$levelforms.level->id}, {$type_id}, null); return false;">({$form_title})</a>
                {/foreach}
            {$typeform.form|safe}
            </div>
        {/foreach}
    {/foreach}
{/foreach}


<div id="customgoalform">
    <hr />
    <h3>{str tag="addcustomgoalformtitle" section="artefact.epos"}</h3>
    {$customgoalform|safe}
</div>