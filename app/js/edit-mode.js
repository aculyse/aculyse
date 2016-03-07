function StudentEdit(element) {
    this.element = element;
    this.input_el = ["e-college-num", "e-firstname", "e-middlename", "e-surname", "e-national-id-num", "e-sex", "e-dob", "e-ms1", "e-ms2", "e-home-address", "e-cell", "e-email"];

}
StudentEdit.prototype.activateUI = function (is_study) {

    var prepared_el = "#" + this.element;
    var el_data = $(prepared_el).data("current-value");
    var new_ui = null;

    switch (is_study) {

        case  "true":
            new_ui = "<select id='" + this.element + "-txt' class='input' value='" + el_data + "'>";
            new_ui += "<option selected>" + el_data + "</option>";
            new_ui += "<option>ART AND DESIGN</option>";
            new_ui += "<option>CHISHONA</option>";
            new_ui += "<option>COMMERCIALS</option>";
            new_ui += "<option>ENGLISH</option>";
            new_ui += "<option>FRENCH</option>";
            new_ui += "<option>GEOGRAPHY</option>";
            new_ui += "<option>HISTORY</option>";
            new_ui += "<option>ISINDEBELE</option>";
            new_ui += "<option>MATHEMATICS</option>";
            new_ui += "<option>MUSIC</option>";
            new_ui += "<option>PHYSICAL EDUCATION AND SPORT</option>";
            new_ui += "<option>PORTUGUESE</option>";
            new_ui += "<option>SCIENCE</option>";
            new_ui += "</select>";
            break;

        case "classes":
            $.ajax({
                type: 'POST',
                url: "../executers/class_exec.php",
                data: "action=get",
                dataType: 'html',
                success: function (html, textStatus) {
                    $("#change_class_form").remove();
                    var new_ui = '<div id="overlay"></div>';
                    new_ui += '<div class="panel panel-primary dialog col-lg-5 no-padding" id="change_class_form">';

                    new_ui += '<div class="panel-heading">';
                    new_ui += '<h3 class="panel-title">Change Student Class <button class="btn btn-default btn-sm no-margin right" onclick=$("#overlay,.overlay,#change_class_form").fadeOut();>Cancel</button></h3>';
                    new_ui += '</div>';

                    new_ui += '<div class="panel-body">';

                    new_ui += '<div class="alert alert-default alert-dismissable">';
                    new_ui += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                    new_ui += '<strong>Tip!</strong> Select the new class for the student, if you cannot find a class ask the administrator to add them for you';
                    new_ui += '</div>';

                    new_ui += html.toString();
                    new_ui += '</div>';

                    new_ui += '</div>';
                    $("body").append(new_ui);
                    $("#change_class_form,#overlay").fadeIn();
                    return;
                },
                error: function (xhr, textStatus, errorThrown) {
                    $("#loading").hide();
                }
            });
            break;
        case  "sex":
            new_ui = "<select id='" + this.element + "-txt' class='input' value='" + el_data + "'>";
            new_ui += "<option>MALE</option>";
            new_ui += "<option>FEMALE</option>";
            new_ui += "</select>";
            break;

        case  "status":
            new_ui = "<select id='" + this.element + "-txt' class='input' value='" + el_data + "'>";
            new_ui += "<option>activated</option>";
            new_ui += "<option>deactivated</option>";
            new_ui += "<option>suspended</option>";
            new_ui += "<option>graduated</option>";
            new_ui += "<option>deferred</option>";
            new_ui += "<option>drop-out</option>";
            new_ui += "</select>";
            break;

        case "class_of":
            new_ui = "<select id='" + this.element + "-txt' class='input' value='" + el_data + "'>";
            for (var i = 2015; i <= 2030; i++) {
                new_ui += "<option>" + i + "</option>";
            }
            new_ui += "</select>";
            break;

        default:
            new_ui = "<input type='text' id='" + this.element + "-txt' class='input' value='" + el_data + "'/>";
    }

    $(prepared_el).prepend(new_ui);
    //show save and cancel button and hide edit button and original data
    $(prepared_el + " .edit-badge," + prepared_el + " .cval").hide(function () {
        $(prepared_el + " .nope").fadeIn(200);
    });

};

StudentEdit.prototype.resetUI = function () {

    $(".edit-badge,.cval").show(function () {
        $(".nope,.input").fadeOut(200);
    });
}


function resetEditInputUI() {
    var UiManager = new StudentEdit();
    UiManager.resetUI();
}

function startUpdating(el_id, field) {

    var UiManager = new StudentEdit();
    var prepared_el = "#" + el_id;
    var new_value = $(prepared_el + "-txt").val();
    var user = $("#student-profile-meta").data("uid");

    if (new_value === undefined) {
        msgError("Update value could not be processed.Try refreshing this page and try again");
        return;
    }

    $("#progress-report").fadeIn(5);
    $.ajax({
        type: 'POST',
        url: "../executers/update_student_details.php",
        data: "user=" + user + "&value=" + new_value + "&field=" + field,
        dataType: 'html',
        success: function (html, textStatus) {
            $("#progress-report").fadeOut(500);
            switch (html.toString()) {
                case "Success":
                    UiManager.resetUI();
                    $(prepared_el + " .cval").html(new_value.toString().toUpperCase());
                    if (field === "class_name") {
                        location.reload();
                        return;
                    }
                    msgInfo("Update successfull");

                    break;

                case "EmptyParameterException":
                    msgWarning("Something went wrong, Try refreshing and try again, If this persists please report to admin:: Technical details : Empty Parameter Exception");
                    break;

                case "FieldInvalidException":
                    msgWarning("Something went wrong, Try refreshing and try again, If this persists please report to admin:: Technical details :Field Invalid Exception");
                    break;

                case "AcessLevelViolationException":
                    msgWarning("You do not have the right to write to student records.");
                    break;

                case "DataFormatException":
                    msgWarning("The input you provided is considred invalid please enter valid input. Technical details :Data Format Exception");
                    break;

                case "NoUpdate":
                    msgInfo("No changes where made");
                    break;

                default :
                    msgError("Something went wrong, Try refreshing and try again, If this persists please report to admin :: Unknown response");
                    break;
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            msgError("Sorry process terminated because the executor was not found.Try refreshing this page and try again");
            $("#progress-report").fadeOut(50);
        }
    });
}