<table id="checklist{$id}" width="100%">
    <thead>
        <tr>
            <th width="30%">{str tag='competence' section='artefact.epos'}</th>
            {foreach $levels item=competence name=getlevels}
                {if $dwoo.foreach.getlevels.first}
                    {loop $competence}
            <th>{$_key}</th>
                    {/loop}
                {/if}
            {/foreach}
        </tr>
        <tr>
        </tr>
    </thead>
</table>
<div id="checklistnotvisible{$id}" style="font-size:130%; margin:8px; color:red; text-align:center">{str tag='checklistnotvisible' section='blocktype.epos/checklist'}</div>
<script>
{$JAVASCRIPT|safe}
</script>
