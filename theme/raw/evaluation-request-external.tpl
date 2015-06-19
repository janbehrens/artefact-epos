{include file="header.tpl"}

{$create_evaluation_request_form|safe}

<script type='text/javascript'>
	function selectSubject() {
	    var selected = $j('#create_evaluation_request_subject').attr('value');
	    window.location = '?subject=' + selected;   
	}
	$j('#create_evaluation_request_subject').attr('onchange', 'selectSubject();');
</script>
<script src="{$WWWROOT}artefact/epos/js/searchuser.js"></script>

{include file="footer.tpl"}
