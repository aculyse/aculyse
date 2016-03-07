function loadUsers() {

    var search = $("#search-input").val();

    $("#loading").show();
    $.ajax({
        type: 'GET',
        url: "../views/users_list.php",
        data: "q=" + search,
        dataType: 'html',
        success: function(html, textStatus) {
            $("#loading").hide();
            $("#user-list").empty();
            $("#user-list").append(html.toString());

            if (search.length >= 1) {
                history.pushState("foo", "pages", "?search_mode");
            } else {
                history.pushState("foo", "pages", "?overview");
            }
        },
        error: function(xhr, textStatus, errorThrown) {

            $("#loading").hide();
        }
    });
}
function loadClasses() {

    $("#loading").show();
    $.ajax({
        type: 'POST',
        url: "../executers/class_exec.php",
        data: "action=get",
        dataType: 'html',
        success: function(html, textStatus) {
            $("#loading").hide();
            $("#classes-list").empty();
            $("#classes-list").append(html.toString());
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").hide();
        }
    });
}

function changeAcessLevel(user, new_level) {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "../executers/user_exec.php",
        data: "action=cal&user=" + user + "&new_level=" + new_level,
        dataType: 'html',
        success: function(html, textStatus) {
            $("#loading").fadeOut(200);
            var response = html.toString();
          
            switch (response) {
                case "Success":
                    var level_text = null;
                    if (new_level == 1) {
                        level_text = "Teacher";
                    } else if (new_level == 2) {
                        level_text = "Student Records";
                    }
                    else if (new_level == 3) {
                        level_text = "Principals";

                    }
                    else if (new_level == 4) {
                        level_text = "Admin";

                    }
                    else {
                        level_text = "Pending Refresh"
                    }
                    var display_el = "#user_" + user + " .level-txt";
                    $(display_el).fadeOut(200, function() {
                        $(display_el).html(level_text);
                        $(display_el).fadeIn(200);
                    });

                    break;
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
        }
    });
}

function removeUserDialog(user) {
    msg_ui = "<div id='msg-box' class='panel panel-warning'>";
    msg_ui += "<div class='panel-heading'>";
    msg_ui += "<h3 class='panel-title'>Confirm Delete!</h3>";
    msg_ui += "</div>";
    msg_ui += "<div class='panel-body'>";
    msg_ui += "Are you sure you want to delete this user"
    msg_ui += "</div>";
    msg_ui += "<div class='panel-heading panel-bottom'>";

    msg_ui += "<button class='btn btn-action btn-sm' onclick='removeUser(\"" + user + "\");'>Yes, Proceed</button>";
    msg_ui += "<button class='btn btn-default btn-sm' onclick='closeMsg();'>Cancel</button>";
    msg_ui += "</div>";
    msg_ui += "</div>";
    $("body").append(msg_ui);
}

function removeUser(user) {

    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "../executers/user_exec.php",
        data: "action=remove&user=" + user,
        dataType: 'html',
        success: function(html, textStatus) {

            $("#loading").fadeOut(200);
            var response = JSON.parse(html.toString());

            switch (response.status) {
                case "success":
                    $("#user_" + user).fadeOut(350, function() {
                        msgSuccess("User removed successfully");
                    });
                    break;

                case "failed":
                    msgWarning("Action could not complete. If this persists please notify the developer");
                    break;

                case "SQLExecutionException":
                    msgError("An internal error happened, please refresh the page and try again. If this persists please notify the develope")
                    break;

                default :
                    msgInfo("Unknown response. If this persists please notify the develope");
                    break;
            }
        },
        error: function(xhr, textStatus, errorThrown) {

            $("#loading").fadeOut(500);
        }
    });
}

function changeSubject(user) {
    var s1 = $("#sub1TXT .new-sub").val();
    var s2 = $("#sub2TXT .new-sub").val();

    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "../executers/user_exec.php",
        data: "action=change_subject&user=" + user + "&subject1=" + s1 + "&subject2=" + s2,
        dataType: 'html',
        success: function(html, textStatus) {

            $("#loading").fadeOut(200);
            var response = JSON.parse(html.toString());

            switch (response.status) {
                case "success":
                    $("#user_" + user).fadeOut(350, function() {
                        msgSuccess("Subjects updated successfully, changes will be shown on next refresh");
                    });
                    break;

                case "failed":
                    alert("Action could not complete. Please try again");
                    break;

                case "SQLExecutionException":
                    msgError("An internal error happened, please refresh the page and try again. If this persists please notify the develope")
                    break;

                default :
                    msgInfo("Unknown response. If this persists please notify the develope");
                    break;
            }
        },
        error: function(xhr, textStatus, errorThrown) {

            $("#loading").fadeOut(500);
        }
    });
}


function resetPassword(user) {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "../executers/user_exec.php",
        data: "action=rp&user=" + user,
        dataType: 'html',
        success: function(html, textStatus) {
            $("#loading").fadeOut(200);
            var response = JSON.parse(html.toString());
            switch (response.status) {
                case "success":
                    var new_pwd = response.data;
                    msgInfo("Password reset successful, new password is " + new_pwd);
                    break;

                case "failed":
                    msgWarning("Password reset could not complete. If this persists please notify the developer");
                    break;

                case "SQLExecutionException":
                    msgError("An internal error happened, please refresh the page and try again. If this persists please notify the develope")
                    break;

                default :
                    msgInfo("Unknown response. If this persists please notify the develope");
                    break;
            }
        },
        error: function(xhr, textStatus, errorThrown) {

            $("#loading").fadeOut(500);
        }
    });
}



function toggleAccessLevelUI() {
    var level_el = "#accessTXT";
    var choosen_level = $(level_el).val();

    if (choosen_level == 1) {
        $(".access-trigger").slideDown(300);
    }
    else {
        $(".access-trigger").fadeOut(200);
    }
}

function toggleAutoLoadCredentialsUI() {
    var au_el = "#auTXT";
    var choosen_level = $(au_el).val();

    if (choosen_level == 0) {
        $(".au-trigger").slideDown(300);
    }
    else {
        $(".au-trigger").fadeOut(200);
    }
}

function backToUserList() {

    $("#user-list-div").fadeIn(200, function() {
        $("#new-user-div").fadeOut(100);
    })
}

function addUserUI() {

    $("#user-list-div").fadeOut(200, function() {
        $("#new-user-div").fadeIn(100);
    })
}

function toogleSubjectUpdateUI(id) {

     $.ajax({
        type: 'POST',
        url: "../views/teacher_subjects.php",
        data: "tr_id="+id,
        dataType: 'html',
        success: function(html, textStatus) {
            $("#overlay,#class-mgt").show();
           $("#tr-subjects").empty();
           $("#tr-subjects").append(html.toString());
        },
        error: function(xhr, textStatus, errorThrown) {
   msgError("An internal error happened, please refresh the page and try again. If this persists please notify the developer")

        }
    });
}
