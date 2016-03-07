var School = {
    save: function() {
        var admin_details = Object();
        var school_details = Object();

        admin_details.fullname = $("#fullname").val();
        admin_details.username = $("#username").val();
        admin_details.email = $("#email").val();
        admin_details.pwd = $("#password").val();

        school_details.fullname = $("#sch-name").val();
        school_details.type_of = $("#sch-type").val();

        $.ajax({
            type: 'POST',
            url: "executers/new_school.php",
            data: "fullname=" + admin_details.fullname + "&email=" + admin_details.email + "&username=" + admin_details.username + "&password=" + admin_details.pwd + "&school_name=" + school_details.fullname + "&school_type=" + school_details.type_of,
            dataType: 'html',
            success: function(html, textStatus) {

                var response = JSON.parse(html.toString());

                switch (response.status) {

                    case "success":
                        signIn();
                        break;

                    case "taken":
                        msgWarning("The username <b>" + admin_details.username + "</b> is already taken, try another username of your choice");
                        break;

                    default:
                        $("#errors-box").empty();
                        $("#errors-box").slideDown(250);
                        $("#errors-box").append("<a class='list-group-item active list-group-item-danger'>The following errors were found in your submision</a>")
                        for (var i = 0; i <= response.length - 1; i++) {
                            var offset_correction = i + 1;
                            $("#errors-box").append("<a href='#' class='list-group-item'><span class='label label-danger'>" + offset_correction + "</span>" + response[i] + "</a>");

                        }
                        ;
                        break;
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                alert('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
            }

        });
    },
    checkAvailiability: function() {
        var username = $("#username").val();
        $.ajax({
            type: 'POST',
            url: "executers/check_account.php",
            data: "sign_check&action=check&user=" + username,
            dataType: 'html',
            success: function(html, textStatus) {
                switch (html.toString()) {

                    case "available":

                        break;

                    case "taken":
                        msgWarning("The username <b>" + username + "</b> is already taken, try another username of your choice");
                        break;
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                // alert('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
            }

        });
    }

};
