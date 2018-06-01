{include file="header.tpl"}

{if $create_evaluation_request_form}
    {$create_evaluation_request_form|safe}
{else}
    <p>{str tag='noevaluationtorequest' section='artefact.epos'}</p>
{/if}

<div class="data" data-search="{str tag='search' section='artefact.epos'}"></div>
<script src="{$WWWROOT}artefact/epos/js/request_external_evaluation.js"></script>

{include file="footer.tpl"}
