function loadRegistrationForm() {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'GET',
        url: "views/add_student_form.php",
        dataType: 'html',
        success: function(html, textStatus) {
            var target_el = "#content-container";
            $(target_el).empty();

            $(".page-header").hide();
            $(target_el).append(html.toString());
            $("#loading").fadeOut(500);
            history.pushState("foo", "pages", "?section=new student");

        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}

function loadOverview() {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'GET',
        url: "views/overview.php",
        dataType: 'html',
        success: function(html, textStatus) {
            var target_el = "#content-container";
            $(target_el).empty();
            $(target_el).append(html.toString());
            $("#loading").fadeOut(500);
            history.pushState("foo", "pages", "?section=overview");

        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}

function loadReports() {
    $("#loading").fadeIn(500);
    $.ajax({
        type: 'GET',
        url: "views/report.php",
        dataType: 'html',
        success: function(html, textStatus) {
            var target_el = "#content-container";
            $(target_el).empty();
            $(target_el).append(html.toString());
            $("#loading").fadeOut(500);
            history.pushState("foo", "pages", "?section=overview");

        },
        error: function(xhr, textStatus, errorThrown) {
            $("#loading").fadeOut(500);
            alert('an error just happened and we are embarassed and working on it'); // + (errorThrown ? errorThrown : xhr.status)
        }
    });
}
