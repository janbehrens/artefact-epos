jQuery(document).ready(function() {
	jQuery(".stored_evaluations td .delete-confirmation").click(function() {
		var question = jQuery(this).closest("td").find(".evaluation-title").text();
		var result = confirm(question);
		if(result) {
			var evaluationId  = jQuery(this).closest("td").find(".evaluation-id").text();
			jQuery.ajax({
	            type: "POST",
	            url: "stored-delete.php",
	            data: {
	                id: evaluationId,
	            },
	        })
	        .done(function() {
	       		location.reload();
	        });
		}
	});
});