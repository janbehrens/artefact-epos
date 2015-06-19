jQuery(document).ready(function() {
    var searchBtn = "<button class=\"userSearchBtn\" style=\"margin-left:10px\">Search</button>"
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
                    var userNumber = msg['message'].length;
                    if(msg['message'][0] == null) {
                        jQuery(".noInstitutionMember").remove();
                        var errorMsg = "There is no other members in your institution, please contact the administrator to add members."
                        errorMsg = "<tr class=\"noInstitutionMember\"><th></th><td style=\"color:red\">" + errorMsg + "</td></tr>"; 
                        jQuery("#create_evaluation_request_evaluator_container").after(errorMsg);
                    } else {
                        for(var i=0; i<userNumber; i++) {
                            var user = "<tr class=\"institutionMember\" style=\"cursor:pointer\">\n" + 
                                            "<th></th>\n" + 
                                            "<td><img src=\"" + config.wwwroot + "/artefact/epos/theme/raw/static/images/no_userphoto16.png\" style=\"padding-right:5px\">" + msg['message'][i] + "</td>\n" +
                                        "</tr>";
                            jQuery("#create_evaluation_request_evaluator_container").after(user);
                        }

                        jQuery("body").on("click", ".institutionMember", function(){
                            var userName = jQuery(this).find("td").text();
                            jQuery("#create_evaluation_request_evaluator").val(userName);
                        });                       
                    }
                }
            }
        });    
    });
});