{$evaltable|safe}

{foreach $checklistforms item=checklistform}
    {loop $checklistform}
<div id="{$name}_div" class="checklistform hidden">
    <h2>{str tag='evaluationformtitle' section='artefact.epos' arg1=$competence arg2=$_key}</h2>
    {$form|safe}
</div>
    {/loop}
{/foreach}
