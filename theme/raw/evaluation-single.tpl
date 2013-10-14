{include file="header.tpl"}

<h2>{$title}</h2>

{if $id}
<p>{str tag='helpselfevaluation' section='artefact.epos'}</p>

{$selfevaluation|safe}

{/if}

{include file="footer.tpl"}
