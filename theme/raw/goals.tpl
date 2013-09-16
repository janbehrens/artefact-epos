{include file="header.tpl"}

<div id="subjects_list">{$languagelinks|safe}</div>

{if $haslanguages}
<table id="goals_table">
    <thead>
        <tr>
            <th>{str tag='goal' section='artefact.epos'}</th>
            <th>{str tag='competence' section='artefact.epos'}</th>
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

<div>

<div id="customgoal">
    <h3>{str tag="addcustomgoalformtitle" section="artefact.epos"}</h3>
    {$custom_goal_form|safe}
</div>

</div>

{include file="footer.tpl"}
