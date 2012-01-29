{include file="header.tpl"}

<div id="subjects_list">{$languagelinks|safe}</div>

{if $haslanguages}
<table id="goals_table">
    <thead>
        <tr>
            <th>{str tag='goal' section='artefact.epos'}</th>
            <th>{str tag='competence' section='artefact.epos'}</th>
            <th>{str tag='descriptorset' section='artefact.epos'}</th>
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
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}

<div id="customgoal">
    {$custom_goal_form|safe}
</div>

{include file="footer.tpl"}
