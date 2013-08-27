{$evaltable|safe}

{foreach $evaluationforms item=competence}
    {foreach $competence item=levelforms}
        <div id="{$levelforms.container}_div" class="checklistform hidden">
        {foreach $levelforms.forms item=typeform}
            <div id="{$typeform.name}_div" class="checklistform {if not $typeform.is_default}hidden{/if}">
                <h2>{$levelforms.title}</h2>
                {foreach $typeform.other_types key=type_id item=form_title}
                <a href="#" onclick="switchFormType({$levelforms.competence->id}, {$levelforms.level->id}, {$type_id}); return false;">({$form_title})</a>
                {/foreach}
            {$typeform.form|safe}
            </div>
        {/foreach}
        </div>
    {/foreach}
{/foreach}
