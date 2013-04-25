{include file="header.tpl"}

{if $haslanguages}
<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/checklist-print.php">
        <input type="submit" class="submit" value="{str tag='printchecklist' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
</div>
{/if}

<div id="subjects_list">{$languagelinks|safe}</div>

{if $haslanguages}
<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

<table id="checklist{$id}" style="width: 100%;">
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
{/if}

{foreach $checklistforms item=checklistform}
    {loop $checklistform}
<div id="{$name}_div" class="checklistform hidden">
	<p></p>
    <h2>{$competence} {$_key}</h2>
    {$form|safe}
</div>
    {/loop}
{/foreach}

{include file="footer.tpl"}
