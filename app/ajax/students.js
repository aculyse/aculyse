function Student() {
}

Student.prototype.getInput = function () {
    var student = new Object();
    student.firstname = $("#firstnameTXT").val();
    student.middlename = $("#middlenameTXT").val();
    student.surname = $("#surnameTXT").val();
    student.sex = $("#sexTXT").val();
    student.college_number = $("#college-numberTXT").val();
    student.class = $("#classTXT").val();
    student.class_of = $("#class_ofTXT").val();
    student.home_address = $("#home-addressTXT").val();
    student.cell = $("#cellTXT").val();
    student.email = $("#emailTXT").val();
    student.dob = $("#dobTXT").val();
    return student;
}

Student.prototype.saveNewStudent = function () {

    var _s = new Student();
    var submitted_data = _s.getInput();

    $("#errors-box list-group-item").remove();
    $("#errors-box").slideUp(500);

    $.ajax({
        type: 'POST',
        url: '../executers/add_student.php',
        data: 'college_number=' + submitted_data.college_number + '&surname=' + submitted_data.surname + '&middlename=' + submitted_data.middlename + '&firstname=' + submitted_data.firstname + '&sex=' + submitted_data.sex + '&class=' + submitted_data.class + '&class_of=' + submitted_data.class_of + '&cell=' + submitted_data.cell + '&email=' + submitted_data.email + '&home=' + submitted_data.home_address + '&dob=' + submitted_data.dob,
        dataType: 'html',
        success: function (html, textStatus) {
            console.log(html.toString());
            var target_el = "#content-container";
            var result = JSON.parse(html.toString());

            switch (result.status) {

                case "CriticalDataMissingException":
                    msgWarning("Some required fields are not filled, Make sure you filled in fields with (*) sign");
                    break;

                case "Error":
                    msgWarning("something unexpected happened whilist trying to save the record, if this persist please notify your system admnistrator");
                    break;


                case "success":
                    msgSuccess("Student with ID " + result.student_id + " added successful ");
                    location.href = "student_profile.php?id=" + result.student_id;
                    break;


                case "account taken":
                    msgWarning("It seems a record already exists with the entered College Number or National ID Number. Make sure College Number or National ID Number is not blank")
                    break;

                default:

                    $("#errors-box").empty();
                    $("#errors-box").slideDown(250);
                    $("#errors-box").append("<a class='list-group-item active list-group-item-danger'>The following errors were found in your submision</a>")
                    var errors = JSON.parse(result);
                    //check for errors
                    for (var i = 0; i <= errors.length - 1; i++) {
                        var offset_correction = i + 1;
                        $("#errors-box").append("<a href='#' class='list-group-item'><span class='label label-danger'>" + offset_correction + " </span>" + errors[i] + "</a>");
                    }
                    break;

            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
        }
    });
}

//deleter
var coll_num;
var _entity;
function showDelDialog(coll_num, entity) {
    _entity = entity;
    $("#outlay").show();
    $("#del_dialog").fadeIn(300);
    $("#del_dialog #rec_to_del").attr("value", coll_num);
}
function closeDelDialog() {
    $("#outlay").fadeOut(300);
    $("#del_dialog").fadeOut(300);
    $("#del_dialog #rec_to_del").html("");
    entity = null;
}

/**
 * 
 * delete student or lec
 */
function deleteStudent() {

    var college_num = $("#student-profile-meta").data("uid");

    $.ajax({
        type: 'GET',
        url: "../executers/delete_student.php?account_to_remove=" + college_num,
        dataType: 'html',
        success: function (html, textStatus) {

            if (html.toString() == "0") {
                $("#progress-msg").html("record deleted successfully");
                $("#outlay").fadeOut(600, function () {
                    $("#del_dialog").slideUp(600);
                    $("#progress-msg").html("");
                    msgSuccess("Student deleted successfully");
                    location.href = "dash.php";
                });
            }
            else {
                console.log(html.toString());
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
        }
    });
}
