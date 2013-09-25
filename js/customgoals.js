
var oldTA = new Array();
var openToEdit = new Array();

function editCustomGoal(customgoal_id) {
	if(!openToEdit[customgoal_id]) {
		openToEdit[customgoal_id] = true;
		oldTA[customgoal_id] = customgoal_text = document.getElementById('custom_' + customgoal_id).innerHTML;
		if(customgoal_text.substr(0, 5) != "<form") {
			document.getElementById('custom_' + customgoal_id).innerHTML = '<form name="bm" action="javascript: submitEditCustomGoal('+customgoal_id+');">' +
			'<textarea class="customgoalta" id="ta_' + customgoal_id + '">' + customgoal_text + '</textarea>' +
			'<input class="submitcancel submit" type="submit" value="' + strings['save'] + '" />' +
			'<input class="submitcancel cancel" type="reset" value="' + strings['cancel'] + '" onClick="javascript: cancleEditCustomGoalOut('+customgoal_id+');"/>' +
			'</form>';
		}
	}
}

function cancleEditCustomGoalOut(customgoal_id) {
	document.getElementById('custom_' + customgoal_id).innerHTML = oldTA[customgoal_id];
	openToEdit[customgoal_id] = false;
	return true;
}

function submitEditCustomGoal(customgoal_id) {
	ta_id = 'ta_' + customgoal_id;
	customgoal_text = document.getElementById(ta_id).value;
	sendjsonrequest('../customgoalupdate.json.php',
            {'customgoal_id': customgoal_id,
            'customgoal_text': customgoal_text},
            'POST',
            function() {
            	window.location.reload();
            },
            function($args) {
            	alert("Error saving goal, please contact your system administrator.");
            });
   openToEdit[customgoal_id] = false;
}

function deleteCustomGoal(customgoal_id) {
    if (confirm(strings['customlearninggoalwanttodelete'])) {
        sendjsonrequest('customgoaldelete.json.php',
            {'customgoal_id': customgoal_id},
            'GET',
            function(data) {
            	window.location.reload();
            },
            function() {
                // @todo error
            }
        );
    }
}

function customgoalSaveCallback(form, data) {
	tableRenderer.doupdate();
	// Can't reset() the form here, because its values are what were just submitted, 
	// thanks to pieforms 
	forEach(form.elements, function(element) { 
		if (hasElementClass(element, 'text') || hasElementClass(element, 'textarea')) { 
			element.value = ''; 
		} 
	}); 
}
