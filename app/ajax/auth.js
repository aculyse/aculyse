function signIn() {

    var username = $("#username").val();
    var password = $("#password").val();

    startLoginProgress();

    $.ajax({
        type: 'POST',
        url: "executers/auth.php",
        data: "username=" + username + "&pwd=" + password,
        dataType: 'html',
        success: function (html, textStatus) {
            console.log(html.toString());
            var response = JSON.parse(html.toString());

            switch (response.success) {

                case "true":

                    location.href = response.data;
                    location.reload();
                    return;
                    break;

                case "false":
                    msgWarning("Oops! we could not log you in because either your username or password is incorrect, Please try again")
                    resetLoginUI();
                    break;

                case "error":
                    msgWarning("We are a bit inside and feeling ashamed because an eroor just happened. Please tell your systems admin if it persists")
                    resetLoginUI();
                    break;

                case "unknown":
                    msgWarning("To be honest we dont have an idea of what happened, Please tell your systems admin if it persists");
                    resetLoginUI();
                    break;

                case "AccessRevoked":
                    msgWarning("You account has been suspended, please contact your systems admin for more details");
                    resetLoginUI();
                    break;

                default:
                    msgWarning("To be honest we dont have an idea of what happened, Please tell your systems admin if it persists");
                    resetLoginUI();
                    break;

            }

        },
        error: function (xhr, textStatus, errorThrown) {
            msgWarning("To be honest we dont have an idea of what happened, Please tell your systems admin if it persists");
            resetLoginUI();
        }
    });
}

function startLoginProgress() {
    var count;
    $("#progress-msg").html("");
    $("#login-el").fadeOut(200, function () {
        $("#progress-el").slideDown(450);
    });
    setTimeout(function () {
        count += 1;
        if (count = 15000) {
            $("#progress-msg").html("Its taking longer than we thought");
        }
        location.reload();
    }, 20000)

}

function resetLoginUI() {
    $("#login-el").fadeIn(200, function () {
        $("#progress-el").fadeOut(500);
    });
}


function changePassword() {
    $("#errors-el,#progress-el").hide();
    $("#error-msg").html("");

    var old_password = $("#op").val();
    var new_password = $("#np").val();
    var confirmed_password = $("#cnp").val();
    var redirect = $("#rd").val();

    if (new_password != confirmed_password) {
        $("#errors-el").fadeIn();
        $("#error-msg").html("your new password and confirmed password do not match");
        return;
    }

    if (old_password == "" || new_password == "" || confirmed_password == "") {

        $("#errors-el").fadeIn();
        $("#error-msg").html("some data is missing, make sure all the fields are field in and try again");
        return;
    }

    $("#progress-el").fadeIn(40);

    $.ajax({
        type: 'POST',
        url: "../executers/change_password.php",
        data: "op=" + old_password + "&np=" + new_password + "&cnp=" + confirmed_password,
        dataType: 'html',
        success: function (html, textStatus) {

            $("#progress-el").fadeOut(40);
            var response = JSON.parse(html.toString());

            switch (response.status) {

                case "SessionInvalidException":

                    $("#errors-el").fadeIn();
                    $("#error-msg").html("Oops! we could not determine if your session is valid, please refresh the page and try again");
                    break;

                case "EmptyParameterException":
                    $("#errors-el").fadeIn();
                    $("#error-msg").html("Oops! we could change the password due to internal error, please refresh the page and try again");
                    break;

                case "SamePassword":
                    $("#errors-el").fadeIn();
                    $("#error-msg").html("Oops! changes were not made because old and new password are the same");
                    break;

                case "OldPasswordMismatchException":

                    $("#errors-el").fadeIn();
                    $("#error-msg").html("Your old password is incorrect, make sure your typing the correct password and try again. Note * password is case sensitive");

                    break;

                case "PasswordMismatch":

                    $("#errors-el").fadeIn();
                    $("#error-msg").html("your new password and confirmed password do not match");

                    break;

                case "success":
                    if (redirect == 1) {
                        msgInfo("your password was changed successfully, please <a href='index.php'>Click here to login</a>");
                    } else {
                        msgInfo("your password was changed successfully, your password will take effect on your next login");
                    }
                    destroyDialog('security')
                    break;

                case "failed":

                    $("#errors-el").fadeIn();
                    $("#error-msg").html("No changes were made to your password");
                    break;

                case "SQLExecutionException":

                    $("#errors-el").fadeIn();
                    $("#error-msg").html("We are sorry, an internal error disrupted your request, please report this issue if it persists");
                    break;

                default :

                    $("#errors-el").fadeIn();
                    $("#error-msg").html("We are sorry we could evaluate the response from this process")
                    break;

            }

        },
        error: function (xhr, textStatus, errorThrown) {
            $("#progress-el").fadeOut(40);
            $("#errors-el").fadeIn();
            $("#error-msg").html("To be honest we dont have an idea of what happened, Please tell your systems admin if it persists");

        }
    });
}


function signUp() {
    var fullname = $("#fullname").val();
    var email_address = $("#email").val();
    var password = $("#password").val();
    var school = $("#sch-name").val();
    var school_type = $("#sch-type").val();

    $.ajax({
        type: 'POST',
        url: "executers/new_school.php",
        dataType: 'html',
        success: function (html, textStatus) {
            console.log(html.toString());

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });

}
