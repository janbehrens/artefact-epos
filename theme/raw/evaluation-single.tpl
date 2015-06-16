{include file="header.tpl"}

<h2>{$title}</h2>

{if $id}
<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

{$selfevaluation|safe}

<div style="padding-top:15px">
	<a href="{$WWWROOT}artefact/epos/evaluation/external.php"><button class="btn">Finish</button></a>
</div>

{/if}

{include file="footer.tpl"}
