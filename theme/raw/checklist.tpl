{include file="header.tpl"}

<div id="subjects_list">{$languagelinks|safe}</div>

{if $haslanguages}
<table id="checklist" width="100%">
    <thead>
        <tr>
            <th width="35%">{str tag='competence' section='artefact.epos'}</th>
            {foreach $checklistforms item=competence name=getlevels}
                {if $dwoo.foreach.getlevels.first}
                    {loop $competence}
            <th>{str tag='$_key' section='artefact.epos'}</th>
                    {/loop}
                {/if}
            {/foreach}
        </tr>
    </thead>
</table>
{/if}

{foreach $checklistforms item=checklistform}
    {loop $checklistform}
<div id="{$name}_div" class="hidden">
	<p></p>
    <h2>{str tag='$competence' section='artefact.epos'} {str tag='$_key' section='artefact.epos'}</h2>
    {$form|safe}
</div>
    {/loop}
{/foreach}


{include file="footer.tpl"}
