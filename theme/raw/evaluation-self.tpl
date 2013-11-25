{include file="header.tpl"}

{if $id}
<div class="rbuttons{if $GROUP} pagetabs{/if}">
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/print.php">
        <input type="submit" class="submit" value="{str tag='printevaluation' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
    <form method="get" action="{$WWWROOT}artefact/epos/evaluation/store.php">
        <input type="submit" class="submit" value="{str tag='storeevaluation' section='artefact.epos'}">
        <input type="hidden" name="id" value="{$id}">
    </form>
    <form method="get" action="{$WWWROOT}artefact/epos/comparison/">
        <input type="submit" class="submit" value="{str tag='compare' section='artefact.epos'}">
        <input type="hidden" name="evaluations[]" value="{$id}">
    </form>
</div>
{/if}

<div id="subjects_list">{$selectform|safe}</div>

{if $id}
<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

{$selfevaluation|safe}

<div id="customgoalform">
    <hr />
    <h3>{str tag="addcustomcompetenceformtitle" section="artefact.epos"}</h3>
    {$customgoalform|safe}
</div>

{/if}

{include file="footer.tpl"}
