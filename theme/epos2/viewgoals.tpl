<table id="goals_table_{$bid}_{$id}" class="fullwidth">
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

<script src="{$WWWROOT}/js/tablerenderer.js"></script>
<script>
{$JAVASCRIPT|safe}
</script>