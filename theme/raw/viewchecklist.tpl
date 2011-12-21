<table id="checklist{$id}" width="100%">
    <thead>
        <tr>
            <th width="30%">{str tag='competence' section='artefact.epos'}</th>
            {foreach $levels item=competence name=getlevels}
                {if $dwoo.foreach.getlevels.first}
                    {loop $competence}
            <th>{str tag='$_key' section='artefact.epos'}</th>
                    {/loop}
                {/if}
            {/foreach}
        </tr>
    </thead>
</table>
<script>
{$JAVASCRIPT|safe}
</script>
