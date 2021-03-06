{include file="header.tpl"}

{if !$accessdenied}
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
    {if $addsubjectset}
    <div id="learnedlanguageform">{$evaluationsform|safe}</div>
    {else}
    <div id="learnedlanguageform" class="hidden">{$evaluationsform|safe}</div>
    <button id="addlearnedlanguagebutton" onclick="toggleLanguageForm();">{str tag='add'}</button>
    {/if}
</div>
{else}No subjects are configured for your institutions! Admins and staff can fix this <a href="templates/subjects.php">here</a>.
{/if}
{else}Wrong subject ID!
{/if}

<script type='text/javascript'>
jQuery('#addlearnedlanguage_subject').attr('onchange', 'refreshDescriptorsets();');
jQuery('#cancel_addlearnedlanguage_submit').attr('onclick', 'toggleLanguageForm(); return false;');
</script>

{include file="footer.tpl"}
