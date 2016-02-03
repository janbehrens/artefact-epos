
var oldText = new Array();
var openToEdit = new Array();

function editCustomGoal(customgoal_id) {
    customGoalNode = document.getElementById('custom_' + customgoal_id);
    customgoal_text = customGoalNode.innerHTML;
    
    //on self-evaluation page: embedded in evaluation pieform
    if (customGoalNode.parentNode.parentNode.parentNode.parentNode.parentNode.nodeName == 'FORM') {
        if (!customGoalNode.parentNode.classList.contains('hidden')) {
            customGoalNode.parentNode.classList.add('hidden');
            customGoalNode.parentNode.parentNode.children[1].classList.remove('hidden');
        }
        else {
            customGoalNode.parentNode.classList.remove('hidden');
            customGoalNode.parentNode.parentNode.children[1].classList.add('hidden');
        }
    }
    //on goals page: extra form for editing
    else {
        if (!openToEdit[customgoal_id]) {
            openToEdit[customgoal_id] = true;
            oldText[customgoal_id] = customgoal_text
            
            if (customgoal_text.substr(0, 5) != "<form") {
                customGoalNode.innerHTML = '<form name="bm" action="javascript: submitEditCustomGoal('+customgoal_id+');">' +
                '<textarea class="customgoalta" id="ta_' + customgoal_id + '">' + customgoal_text + '</textarea>' +
                '<input class="submitcancel submit" type="submit" value="' + strings['save'] + '" />' +
                '<input class="submitcancel cancel" type="reset" value="' + strings['cancel'] + '" onClick="javascript: cancelEditCustomGoalOut('+customgoal_id+');"/>' +
                '</form>';
            }
        }
    }
}

function cancelEditCustomGoalOut(customgoal_id) {
    document.getElementById('custom_' + customgoal_id).innerHTML = oldText[customgoal_id];
    openToEdit[customgoal_id] = false;
    return true;
}

function submitEditCustomGoal(customgoal_id) {
    ta_id = 'ta_' + customgoal_id;
    customgoal_text = document.getElementById(ta_id).value;
    sendjsonrequest(config.wwwroot + 'artefact/epos/customgoalupdate.json.php',
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
        sendjsonrequest(config.wwwroot + 'artefact/epos/customgoaldelete.json.php',
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
