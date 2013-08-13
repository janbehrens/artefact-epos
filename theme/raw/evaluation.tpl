<table id="checklist{$id}" class="evaluation">
    <thead>
        <tr>
            <th width="30%">{str tag='competence' section='artefact.epos'}</th>
            {foreach $checklistforms item=competence name=getlevels}
                {if $dwoo.foreach.getlevels.first}
                    {loop $competence}
            <th>{$_key}</th>
                    {/loop}
                {/if}
            {/foreach}
        </tr>
    </thead>
</table>

{foreach $checklistforms item=checklistform}
    {loop $checklistform}
<div id="{$name}_div" class="checklistform hidden">
    <h2>{str tag='evaluationformtitle' section='artefact.epos' arg1=$competence arg2=$_key}</h2>
    {$form|safe}
</div>
    {/loop}
{/foreach}
