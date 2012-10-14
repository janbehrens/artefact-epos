{include file="header.tpl"}

<div id="institutions_list">{$links_institution|safe}</div>

{if !$accessdenied}
<table id="subjectslist">
    <thead>
        <tr>
            <th>{str tag='subject' section='artefact.epos'}</th>
            <th></th>
            <th>{str tag='templates' section='artefact.epos'}</th>
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
    <div id="subjectform" class="hidden">{$subjectform|safe}</div>
    <button id="addbutton" onclick="toggleForm();">{str tag='add'}</button>
</div>
{/if}

{include file="footer.tpl"}
