function Profiler() {
    var token = $("#universal-token").data("universal-token");
    url_token_val = "token=" + token;
}

Profiler.prototype.startProfile = function (profile_id, subject, term, year, mode, class_of, course_work_num) {

    $("#loading").fadeIn(500);
    var target_el = "#ajax-master"
    $.ajax({
        type: 'POST',
        url: "../executers/start_profile.php",
        data: "subTXT=" + subject + "&termTXT=" + term + "&yrTXT=" + year + "&modeTXT=" + mode + "&classofTXT=" + class_of + "&cwTXT=" + course_work_num + "&profile_id=" + profile_id + "&" + url_token_val,
        dataType: 'html',
        success: function (html, textStatus) {
            $("#loading").fadeOut(500);
            console.log(html.toString())
            var params = {
                "subject": subject,
                "term": term,
                "year": year,
                "mode": mode,
                "class_of": class_of,
                "course_work_num": course_work_num,
                "profile_id": profile_id
            };
            var response = JSON.parse(html.toString());
            switch (response.status) {

                case "success":
                    var profile_id = response.profile;
                    $Profiler = new Profiler();
                    $Profiler.getUI(profile_id, subject, term, year, mode, class_of, course_work_num);
                    $("#new-profile-menu").remove();
                    $("#overlay,.overlay").hide();
                    msgSuccess("Profile created successfully, wait while we finish up some stuff!s");

                    location.href = "markboard.php?profile_id=" + profile_id;

                    break;

                case "InvalidYearException":
                    msgWarning("<b>The year you are creating the profile for(" + response.year + ") cannot be greater than the year the class is graduating(" + response.class + ") . Please restart the Wizard and try again</b>");

                    break;

                case "available":
                    msgWarning("<b>A profile you specified already exists, please open it on the profiles list</b>");
                    break;
            }

        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(errorThrown);
            $("#loading").fadeOut(500);
        }
    });
}

Profiler.prototype.getUI = function (profile_id, subject, term, year, mode, class_of, course_work_num) {

    $("#loading").fadeIn(500);
    var target_el = "#ajax-master"
    $.ajax({
        type: 'POST',
        url: "../views/draw_sheets_ui.php",
        data: "subTXT=" + subject + "&termTXT=" + term + "&yrTXT=" + year + "&modeTXT=" + mode + "&classofTXT=" + class_of + "&cwTXT=" + course_work_num + "&profile_id=" + profile_id + "&" + url_token_val,
        dataType: 'html',
        success: function (html, textStatus) {

            var params = {
                "subject": subject,
                "term": term,
                "year": year,
                "mode": mode,
                "class_of": class_of,
                "course_work_num": course_work_num,
                "profile_id": profile_id
            };
            $(target_el).empty();
            var progress_bar_ui = '<div class="col-md-12">';
            progress_bar_ui += '<h1 class="centered light-gray">loading please wait...</h1>';
            progress_bar_ui += '</div>';
            $(target_el).append(progress_bar_ui);

            $("#preloaded-menu,#ajax-data-box,#new-profile-menu").slideToggle(400, function () {
                $(target_el).empty();
                $(target_el).append(html.toString());
                $("#loading").fadeOut(100);
                $('#current-profile-table').dataTable({
                    "order": [[0, "desc"]],
                    'iDisplayLength': 100,
                    "language": {
                        "lengthMenu": "Display _MENU_ records per page",
                        "info": "Showing page _PAGE_ of _PAGES_"
                    }
                });

            });


            if (typeof window.localStorage !== undefined) {
                localStorage.clear();
                localStorage.setItem("position", "sheet")
                var position = localStorage.getItem("position");

                if (position === "sheet") {
                    localStorage.removeItem("data_url");
                    localStorage.setItem("data_url", JSON.stringify(params));
                }
            }

        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(errorThrown);
            $("#loading").fadeOut(500);
        }
    });
}

/* make sure mark is int */
Profiler.prototype.updateMarks = function (id, column, value, uid, is_final, profile_id) {

    $("#loading").fadeIn(5);
    $("#loading #text").html("updating...");
    $.ajax({
        type: 'POST',
        url: "../executers/update_marks.php",
        data: "id=" + id + "&column=" + column + "&value=" + value + "&is_final=" + is_final + "&profile_id=" + profile_id + "&" + url_token_val,
        dataType: 'html',
        success: function (html, textStatus) {
            $("#loading").fadeOut(5);
            var response = html.toString();
            console.log(response)
            switch (response) {

                case "updated":
                    break;

                case "sql error":
                    msgError("query execution failed. Please try again, if this persist please contact your system administrator");
                    break;

                case "none affected":
                    msgInfo("No record was updated");
                    break;

                case "AcessLevelViolationException":
                    msgWarning("Access Denied, You do not have the right to edit this record");
                    break;

                case "InvalidTransactionToken":
                    msgWarning("We sorry but this action failed to pass the security check, this is neccessary to prevent unauthorised users from modifying data. However this can be solved by relogging");
                    break;

                default :
                    msgWarning("Response by the server could not be processed, please report this if it persists");
                    break;
            }
            $("#loading #text").html("please wait...");
            $("#loading").fadeOut(5);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(errorThrown);
            $("#loading #text").html("please wait...");
            $("#loading").fadeOut(50);
        }
    });
}

Profiler.prototype.getSheetUI = function (ui, target) {

    var page;
    switch (ui) {
        case "existing":
            this.page = "views/existing_profiles.php";
            break;

        case "new":
            this.page = "views/new_sheet_form.php";
            break;

        default :
            this.page = null;
            break;
    }
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'GET',
        url: this.page,
        dataType: 'html',
        success: function (html, textStatus) {
            $(target).empty();
            $(target).append(html.toString());
            $("#loading").fadeOut(500);

        },
        error: function (xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
        }
    });
}

Profiler.prototype.compileProfile = function (profile_id, course_work_num, course_work_weight, final_exam_weight) {
    var message_el = $('#msg-text');
    if (course_work_weight == 0 && final_exam_weight == 0) {
        message_el.html("At least one field should be field");
        return;
    }
    $("#progress-report").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "../executers/compile_profile.php",
        data: "profile_id=" + profile_id + "&cwTXT=" + course_work_num + "&cw_weightTXT=" + course_work_weight + "&fe_weightTXT=" + final_exam_weight + "&" + url_token_val,
        dataType: 'html',
        success: function (html, textStatus) {
            console.log(html.toString());
            switch (html.toString()) {

                case "InvalidWeightException":
                    message_el.html("your input should be a number between 0 and 100 inclusive");
                    $("#progress-report").fadeOut(500);
                    break;

                case "WeightOverflowException":
                    message_el.html("the total of course work and exam weight should not exceed 100");
                    $("#progress-report").fadeOut(500);
                    $("#loading").fadeOut(500);
                    break;

                case  "DatasetFormatException":
                    message_el.html("Internal error: Data Format Exception");
                    $("#progress-report").fadeOut(500);
                    break;

                case "SQLExecutionExecption":
                    message_el.html("Internal error: Data Execution Exception");
                    $("#progress-report").fadeOut(500);
                    break;

                case "Success":
                    message_el.css({
                        "color": "green"
                    })
                    message_el.html("Profile compiled successfully, I am redirecting you to the report, you can <a href='analyser.php?profile_id=" + profile_id + "'></a>");
                    location.href = "analyser.php?profile_id=" + profile_id;
                    $("#progress-report").fadeOut(500);
                    break;

                case "ProfileUnavailableException":
                    message_el.html("Internal error: Profile Not Found Exception");
                    $("#progress-report").fadeOut(500);
                    break;

                case "ProfileClosureFailure":
                    message_el.html("This profile is closed, so no further editing can be done to it.");
                    $("#progress-report").fadeOut(500);
                    break;
                default:
                    message_el.html("Internal error:Server did not respond");
                    $("#progress-report").fadeOut(500);
                    break;
            }
            $("#progress-report").fadeOut(500);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(errorThrown);
            $("#progress-report").fadeOut(500);
        }
    });
}


Profiler.prototype.getAnalyserUI = function (profile_id, level) {

    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "../views/perfomance_analyser.php",
        data: "profile_id=" + profile_id + "&grading=" + level,
        dataType: 'html',
        success: function (html, textStatus) {
            var list_el = "#profile-list-table";
            var target_el = "#result-box";
            var back_btn = "#back-analytics";

            $("#loading").fadeOut(500);
            var response = html.toString();

            $(target_el).empty();
            $(back_btn).show();
            $(target_el).append(response);


            $(list_el).fadeOut(100);
            $(target_el).hide();
            $(target_el).slideDown(2000);
            history.pushState("foo", "pages", "?" + profile_id + "&" + level);


        },
        error: function (xhr, textStatus, errorThrown) {
            var technical_details = xhr.responseText;
            msgError("<p>Oh snap! Executor not found. Try to refresh this page and try again, if  this persist please <a class='bold pointer' onclick=getDialog(\"feedback_form\");>click here to report it</a> for fixing</p>")
            $("#loading").fadeOut(500);

        }

    });
};

Profiler.prototype.showList = function () {
    var list_el = "#profile-list-table";
    var target_el = "#result-box";
    var back_btn = "#back-analytics";
    $(back_btn).hide();
    $(target_el).empty();
    $(list_el).fadeIn(1000);

};

Profiler.prototype.addStudentManually = function (college_number, profile_id) {
    var error_master = "#add-student #errors-el";
    var message_el = $('#add-student #msg-text');
    $(error_master).hide();
    message_el.html("");

    $.ajax({
        type: 'POST',
        url: "../executers/profiles_manual_add.php",
        data: "cnTXT=" + college_number + "&pid=" + profile_id + "&" + url_token_val,
        dataType: 'html',
        success: function (html, textStatus) {
            console.log(html.toString());
            switch (html.toString()) {
                case "success":
                    $(error_master).fadeIn();
                    $(error_master).removeClass("console-danger");
                    $(error_master).addClass("console-success");
                    message_el.html("User added to Profile, click \"close\" to continue and confirm on the list");
                    $("#progress-report").fadeOut(500);
                    break;


                case "ProfileStatusNotAvailable":

                    $(error_master).fadeIn();
                    message_el.html("CRITICAL ERROR!, Adding student failed because the system could not determine Profile status.");
                    $("#progress-report").fadeOut(500);
                    break;

                case "CollegeNumberInvalidException":
                    $(error_master).fadeIn();
                    message_el.html("The College Number is invalid");
                    $("#progress-report").fadeOut(500);
                    break;

                case "SQLExecutionException":
                    $(error_master).fadeIn();
                    message_el.html("An error happened. Refresh your browser and try again: SQLExec");
                    $("#progress-report").fadeOut(500);
                    break;

                case "ProfileAreadyExistingException":
                    $(error_master).fadeIn();
                    message_el.html("The user you specified already part of this profile");
                    $("#progress-report").fadeOut(500);
                    break;

                case "DataFormatException":
                    $(error_master).fadeIn();
                    message_el.html("Student with this ID not found, please confirm and try gain.If believe this is an error notify the system admin");
                    $("#progress-report").fadeOut(500);
                    break;

                case "StudentDeletedException":
                    $(error_master).fadeIn();
                    message_el.html("Student could not be added because his recorded is either deactivated or suspended. For more details ask the Student Records Personell");
                    $("#progress-report").fadeOut(500);
                    break;

                default :
                    $(error_master).fadeIn();
                    message_el.html("We are not sure whats just happened. Refresh your browser and try again, it if it persist, notify the system admin");
                    $("#progress-report").fadeOut(500);
                    break;
            }

        },
        error: function (xhr, textStatus, errorThrown) {
            $(error_master).fadeIn();
            message_el.html("An error happaned while we were processing your request. Refresh your browser and try again, it if it persist, notify the system admin");
            $("#progress-report").fadeOut(500);
        }
    });
};

$Profiler = new Profiler();
