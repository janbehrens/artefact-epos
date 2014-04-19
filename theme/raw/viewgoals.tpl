<table id="goals_table{$id}">
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
        </tr>
        {/foreach}
    </tbody>
</table>
<div id="goalsnotvisible{$id}" style="font-size:130%; margin:8px; color:red; text-align:center">{str tag='goalsnotvisible' section='blocktype.epos/goals'}</div>
<script>
{$JAVASCRIPT|safe}
</script>
