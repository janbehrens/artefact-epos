{include file="header.tpl"}

<p>{$comparison_of|safe}</p>

{if $other}
    <div id="other" class="comparison">{str tag=selectotherevaluation section=artefact.epos}: {$other|safe}</div>
{else}
    <em>({str tag=nocomparableevaluations section=artefact.epos})</em>
{/if}

{$table|safe}

{include file="footer.tpl"}
