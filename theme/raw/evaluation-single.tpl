{include file="header.tpl"}

<h2>{$title}</h2>

{if $id}
<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

{$selfevaluation|safe}

<a href="{$WWWROOT}artefact/epos/evaluation/external.php"><button class="btn evaluation-submit">Finish</button></a>

{/if}

{include file="footer.tpl"}
