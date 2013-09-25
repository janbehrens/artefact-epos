{include file="header.tpl"}

<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/print.php">
        <input type="submit" class="submit" value="{str tag='printevaluation' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
    <form method="get" action="{$WWWROOT}artefact/epos/comparison/">
        <input type="submit" class="submit" value="{str tag='compare' section='artefact.epos'}">
        <input type="hidden" name="evaluations[]" value="{$id}">
    </form>
</div>

{$evaluationtable|safe}

{include file="footer.tpl"}
