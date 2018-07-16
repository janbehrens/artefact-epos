{include file="header.tpl"}

{$selector|safe}

<table id="subjectslist">
    <thead>
        <tr>
            <th>{str tag='subject' section='artefact.epos'}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$rows item=row}
        <tr class="{cycle values='r0,r1'}">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        {/foreach}
    </tbody>
</table>
<div>
    <div id="subjectform" class="hidden">{$subjectform|safe}</div>
    <button class="btn btn-default" id="addbutton" onclick="toggleForm();">{str tag='add'}</button>
</div>

{include file="footer.tpl"}
