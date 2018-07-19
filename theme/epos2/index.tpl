{include file="header.tpl"}

{if $evaluationsform}
<table id="evaluationslist">
    <thead>
        <tr>
            <th>{str tag='label' section='artefact.epos'}</th>
            <th>{str tag='competencegrid' section='artefact.epos'}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$rows item=row}
        <tr class="{cycle values='r0,r1'}">
            <td></td>
            <td></td>
            <td></td>
        </tr>
        {/foreach}
    </tbody>
</table>
<div>
    <div id="learnedlanguageform" class="hidden">{$evaluationsform|safe}</div>
    <button class="btn" id="addlearnedlanguagebutton" onclick="toggleLanguageForm()">{str tag='add'}</button>
</div>
{else}<p>{str tag='nosubjectsconfiguredforuser' section='artefact.epos'}</p>
{/if}

{include file="footer.tpl"}
