{include file="header.tpl"}

{if $haslanguages}
<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/checklist-print.php">
        <input type="submit" class="submit" value="{str tag='printchecklist' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
    <form method="get" action="{$WWWROOT}artefact/epos/comparison/">
        <input type="submit" class="submit" value="{str tag='compare' section='artefact.epos'}">
        <input type="hidden" name="evaluations[]" value="{$id}">
    </form>
</div>
{/if}

<div id="subjects_list">{$languagelinks|safe}</div>

{if $haslanguages}
<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

{$selfevaluation|safe}

{/if}

{include file="footer.tpl"}
