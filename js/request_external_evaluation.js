jQuery(document).ready(function() {

    //the DOM structure of having only one descriptor and more than one of them are different. Here to unified them.
    var descriptorSetContainerTd = jQuery("#create_evaluation_request_descriptorset_container").find("td");
    if(descriptorSetContainerTd.find("select").length == 0) {
        var descID = descriptorSetContainerTd.find("input").attr("value");
        var desc = descriptorSetContainerTd.text();
        descriptorSetContainerTd.text("");
        descriptorSetContainerTd.append("<select class=\"required select\" id=\"create_evaluation_request_descriptorset\" name=\"descriptorset\" tabindex=\"1\" style=\"\"><option value=\"" + descID + "\" selected=\"selected\">" + desc + "</option></select>");
    }

    jQuery("#create_evaluation_request_subject").change(function() {
        var subjectID = parseInt(jQuery(this).val());
        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            url: config.wwwroot + "artefact/epos/changeDescriptorSet.php",
            data: {
                subjectID: subjectID,
            },
        })
        .done(function(msg) {
            if(!msg['error']) {
                var descriptorSetSelector = jQuery("#create_evaluation_request_descriptorset");
                descriptorSetSelector.find("option").remove();
                for(var i=0; i<msg['message']['descriptorSetIDs'].length; i++) {
                    descriptorSetSelector.append("<option value=\"" + msg['message']['descriptorSetIDs'][i] + "\">" + msg['message']['descriptorSets'][i] + "</option>");
                }
                descriptorSetSelector.find("option").first().attr("selected", "selected"); // by default select the first option
            }
        });    
    });

    var searchText = jQuery(".data").data("search");
    var searchBtn = "<button class=\"userSearchBtn\" style=\"margin-left:10px\">" + searchText + "</button>";
    jQuery("#create_evaluation_request_evaluator_container").find("td").append(searchBtn);

    jQuery("body").on("click", ".userSearchBtn", function(e) {
        e.preventDefault();
        var keyword = jQuery("#create_evaluation_request_evaluator").val();

        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            url: config.wwwroot + "artefact/epos/searchinstituteusers.php",
            data: {
                keyword: keyword,
            },
        })
        .done(function(msg) {
            if(!msg['error']) {
                if(msg['message']['status'] == "institutionNull") {    
                    jQuery(".institutionNull").remove();
                    var errorMsg = "<tr class=\"institutionNull\"><th></th><td style=\"color:red\">" + msg['message']['msg'] + "</td></tr>"; 
                    jQuery("#create_evaluation_request_evaluator_container").after(errorMsg);
                } else {
                    if(msg['message']['status'] == "noUserFound") { //no user found
                        jQuery(".noInstitutionMember").remove();
                        jQuery(".institutionMember").remove();

                        var errorMsg;
                        if(jQuery("#create_evaluation_request_evaluator").val() == "") {
                            errorMsg = msg['message']['noMemberInInstitution'];
                        } else {
                            errorMsg = msg['message']['noUserFoundBasedOnEntered'];
                        }
                        errorMsg = "<tr class=\"noInstitutionMember\"><th></th><td style=\"color:red\">" + errorMsg + "</td></tr>"; 
                        jQuery("#create_evaluation_request_evaluator_container").after(errorMsg);
                    } else {
                        var userNumber = msg['message']['usernames'].length;
                    
                        jQuery(".noInstitutionMember").remove();
                        jQuery(".institutionMember").remove();
                        for(var i=0; i<userNumber; i++) {
                            var nameDisplay = msg['message']['firstnames'][i] + " " + msg['message']['lastnames'][i] + " (" + msg['message']['usernames'][i] + ")";
                            var user = "<tr class=\"institutionMember\" style=\"cursor:pointer\">\n" + 
                                            "<th></th>\n" + 
                                            "<td><img src=\"" + config.wwwroot + "/artefact/epos/theme/raw/static/images/no_userphoto16.png\" style=\"padding-right:5px\">" + nameDisplay + "</td>\n" +
                                        "</tr>";
                            jQuery("#create_evaluation_request_evaluator_container").after(user);
                        }

                        jQuery("body").on("click", ".institutionMember", function(){
                            var userName = jQuery(this).find("td").text();
                            userName = userName.split(" ").pop();
                            userName = userName.substr(1, userName.length - 2);
                            jQuery("#create_evaluation_request_evaluator").val(userName);
                        });                       
                    }
                }
            }
        });    
    });
});