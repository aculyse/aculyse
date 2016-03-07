function getClassStreams(class_id,el_id) {
    $.ajax({
        type: 'POST',
        url: "executers/get_classes.php",
        data: "class_id=" + class_id,
        dataType: 'html',
        success: function(html, textStatus) {
            var response = JSON.parse(html.toString());

            switch (response.status) {

                case "emptyParamsException":
                    break;

                case "NoClassesException":
                    $("#new-profile-menu,.overlay").transition({scale: 0});
                    $("#new-profile-menu,.overlay").remove();
                    msgWarning("<b>Ooops!</b> No students were found in your class.</p>");
                    $("#msg-box").transition({scale: 0.8});
                    $("#msg-box").transition({scale: 1});
                    break;

                default:
                    var select_ui;
                    var year;
                    $("#class-"+el_id).css({
                        "border-left":"solid 6px #FFCE54"
                    });

                    select_ui += '<div class="listgroup pointer" id="subject-tags">';
                    for (var i = 0; i < response.length; i++) {
                        year = response[i];
                        select_ui += '<div class="ui image label tr-subs-label col-lg-4" id="class" onclick="getClassStudents('+ class_id +','+ year +')"> ';
                        select_ui += ' <h5 class="bold"><span>' + year + '</span></h5> ';
                        select_ui += "<input type='hidden' id='input-class-id' value='" + class_id + "'/>";
                        select_ui += "<input type='hidden' id='input-year' value='" + year + "'/>";
                        select_ui += '</div>';
                    }
                    select_ui += '</div>';
                    $("#students").hide();
                    $("#streams-list").empty();
                    $("#streams-list").append(select_ui);
                    $("#streams").fadeIn(1400);

                    break;
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
}
function getClassStudents(class_id,class_year,search) {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "views/class_students.php",
        data: "class_id=" + class_id + "&class_year=" + class_year,
        dataType: 'html',
        success: function(html, textStatus) {
           $("#students-list").empty();
           $("#students-list").append(html.toString());
           $("#students").fadeIn(1400);
        $("#loading").fadeOut(500);
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}
