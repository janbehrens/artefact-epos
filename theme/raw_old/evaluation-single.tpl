{include file="header.tpl"}

{if $id}
{$selfevaluation|safe}

<a href="{$WWWROOT}artefact/epos/evaluation/external.php"><button class="btn evaluation-submit">Finish</button></a>
{/if}

{include file="footer.tpl"}
