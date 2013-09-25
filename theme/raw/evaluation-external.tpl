{include file="header.tpl"}

{$create_evaluation_request_form|safe}

<script type='text/javascript'>
function selectSubject() {
    var selected = $j('#create_evaluation_request_subject').attr('value');
    window.location = '?subject=' + selected;   
}
$j('#create_evaluation_request_subject').attr('onchange', 'selectSubject();');
</script>

{include file="footer.tpl"}
