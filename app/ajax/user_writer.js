var UserWriter = {
    save: function() {

        $("#errors-msgs").remove();

        var user_data = new Object();
        user_data.firstname = $("#fnTXT").val();
        user_data.middlename = $("#mnTXT").val();
        user_data.surname = $("#snTXT").val();
        user_data.nidn = $("#nidnTXT").val();
        user_data.sex = $("#sexTXT").val();
        user_data.contact_num = $("#contact_numTXT").val();
        user_data.email = $("#emailTXT").val();
        user_data.access_level = $("#accessTXT").val();
        user_data.subject1 = $("#subject1TXT").val();
        user_data.subject2 = $("#subject2TXT").val();
        user_data.username = $("#usernameTXT").val();
        user_data.pwd = $("#pwdTXT").val();
        user_data.auto_generate_credentials = $("#auTXT").val();

        $.ajax({
            type: 'POST',
            url: "../executers/add_user_as_admin.php",
            data: "firstname=" + user_data.firstname + "&middlename=" + user_data.middlename + "&surname=" + user_data.surname + "&national_id_num=" + user_data.nidn + "&sex=" + user_data.sex + "&contact_num=" + user_data.contact_num + "&email=" + user_data.email + "&access_level=" + user_data.access_level + "&subject1=" + user_data.subject1 + "&subject2=" + user_data.subject2 + "&username=" + user_data.username + "&password=" + user_data.pwd + "&agc=" + user_data.auto_generate_credentials,
            dataType: 'html',
            success: function(html, textStatus) {
                console.log(html.toString())
                var response = JSON.parse(html.toString());

                switch (response.status) {
                    case "SQLExecutionException":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer")
                        break;

                    case "NotAllowedSingleException":
                         msgInfo("You are using a free account, Collboration capabilities are available to paid accounts .Please upgrade your plan to access this wonderful feature. For more information <a href='#'><b>click here</b></a>, or email to <b>support@aculyse.com</b>" );
                    break;


                    case "taken":
                        msgInfo("Account already taken make sure the username or National ID Number is not registered with another user");
                        break;

                    case "success":
                        var allocated_username = response.username;
                        if (allocated_username === undefined) {
                            allocated_username = "";
                        }
                        msgSuccess("Account created successfully, username is " + allocated_username + " ,please reset the password to obtain the password for the user", "static");
                        break;

                    case "failed":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer")
                        break;

                    case "CredentialsGenerationException":
                        msgError("Credentials generation failed try to add the crdentials manually by choosing the NO option on generation credentials field");

                        break;
                }


                if (response.length > 0) {
                    var errors = '<div class="col-md-12" id="errors-msgs"><br/><br/>';
                    errors += '<div class="list-group">';
                    errors += '<a href="#" class="list-group-item list-group-item-danger">The following errors were found in your submission</a>';

                    for (var i = 0; i <= response.length - 1; i++) {
                        errors += '<a class="list-group-item">' + response[i] + '</a>';
                    }

                    errors += "</div></div>";
                    $("#new-user-div>.panel>.panel-body").append(errors);
                    return;
                }





            },
            error: function(xhr, textStatus, errorThrown) {
                alert('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
            }
        });
    },
    clear:function(){

    },
    editMode: function() {

    }
}
