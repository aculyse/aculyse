
function loadStudents(page_offset) {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'POST',
        url: "views/student_list.php",
        data: "page=" + page_offset,
        dataType: 'html',
        success: function(html, textStatus) {
          //alert(html.toString())
            history.pushState("foo", "pages", "?overview");
            $("#loading").fadeOut(500);
            var target_el = "#content-container";

            if (page_offset > 0) {
                $("#more-rec").replaceWith("<center><span class='typcn typcn-tabs-outline large light-gray table-sep'><span></center>");
                $(target_el).append(html.toString());
                $("#loading").fadeOut(500);
            }
            else {
                $(target_el).empty();
                $(target_el).append(html.toString());
                $(target_el).hide();
                $(target_el).fadeIn(1500);

            }
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}


function searchStudent() {
    var search_term = $("#search-input").val();
    if (search_term.length < 3 && search_term.length !== 0) {
        return;
    }
    if (search_term.length === 0) {
        loadStudents();
    }
    $("#loading").fadeIn(50);
    $.ajax({
        type: 'POST',
        url: "views/student_list.php",
        data: "search=true&q=" + search_term,
        dataType: 'html',
        success: function(html, textStatus) {
            var container_el = "#content-container";
            var target_el = "#student-list-table";
            $(target_el).remove();
            $(container_el).empty();
            $(container_el).append(html.toString());
            $("#loading").fadeOut(50);
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(50);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}


function loadStudentProfile(id) {

    $.ajax({
        type: 'POST',
        url: "views/student_profile.php",
        data: "account=" + id,
        dataType: 'html',
        beforeSend: function() {
            $("#loading").fadeIn(200);
        },
        success: function(html, textStatus) {
           // alert(id)
            $("#loading").fadeOut(5);
            var target_el = "#content-container";
            $("#student-profile").empty();
            $("#student-list-table,#more-rec,.table-sep").hide();
            $(target_el).append(html.toString());
            $(target_el).hide();

            history.pushState("foo", "pages", "?" + id);
            $(target_el).fadeIn(600);
            $("#search-master").fadeOut(5);
            $("#backBTN").fadeIn(100);
            history.pushState("foo", "pages", "?" + id);
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}

function backToList() {

    history.pushState("foo", "pages", "?overview");
    loadStudents();
    $(".top-cover, #student-profile").remove();
    var target_el = "#content-container";
    $("#student-list-table,#more-rec,.table-sep").fadeIn(1500);
    $("#search-master").fadeIn(200);
    $("#backBTN").fadeOut(5);
}

function toggleStudentStatus(account_id) {
    $("#loading").fadeIn(5);
    $.ajax({
        type: 'POST',
        url: "../executers/status_toggler.php",
        data: "account_id=" + account_id,
        dataType: 'html',
        success: function(html, textStatus) {
            $("#loading").fadeOut(3);
            var badge_el = "#student-id-" + account_id + " .status-badge";
            var badge = $(badge_el).html();

            switch (html.toString()) {
                case "success":
                    if (badge == "active") {
                        $(badge_el).html("inactive");
                        $(badge_el).removeClass("badge-success");
                        $(badge_el).addClass("badge-danger");
                    }
                    else if (badge == "inactive") {
                        $(badge_el).html("active");
                        $(badge_el).addClass("badge-success");
                        $(badge_el).removeClass("badge-danger");
                    }
                    $(badge_el).hide();
                    $(badge_el).fadeIn(1500);
                    break;
                case "NoUpdate":
                    msgWarning("Status update could not be done because no secure connection was found");
                    break;

                case "AcessLevelViolationException":
                    msgWarning("Access Denied, You do not have the right to edit this record");
                    break;
                default :
                    msgWarning("Sorry,something unsually just happened. If this persists please report the issue");
                    break;
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(3);
            msgError('Error 404: Page Not Found');
        }
    });
}

function searchStudent4ManualAdd() {
    var search_term = $("#cnTXT").val();
    $.ajax({
        type: 'POST',
        url: "../views/student_search.php",
        data: "q=" + search_term,
        dataType: 'html',
        beforeSend: function() {
            $("#loading").fadeIn(200);
        },
        success: function(html, textStatus) {
            $("#result-el").empty();
            /* make the cases dont forget */
            $("#result-el").append(html.toString());
            $("#loading").fadeOut(20);

        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(20);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}
