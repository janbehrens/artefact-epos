{include file="header.tpl"}

{$create_evaluation_request_form|safe}

<div class="data" data-search="{str tag='search' section='artefact.epos'}"></div>
<script src="{$WWWROOT}artefact/epos/js/request_external_evaluation.js"></script>

{include file="footer.tpl"}
