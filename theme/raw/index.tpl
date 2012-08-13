{include file="header.tpl"}

{if $languageform}
<table id="learnedlanguagelist">
    <thead>
        <tr>
            <th>{str tag='language' section='mahara'}</th>
            <th>{str tag='descriptors' section='artefact.epos'}</th>
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
    <div id="learnedlanguageform" class="hidden">{$languageform|safe}</div>
    <button id="addlearnedlanguagebutton" onclick="toggleLanguageForm();">{str tag='add'}</button>
</div>
{else}No descriptorsets installed! Admins and staff can install descriptorsets <a href="templates/selfevaluation.php">here</a>.
{/if}

{include file="footer.tpl"}
