if (typeof window.localstorage == undefined) {
    promptyBrowserUpgrade()
}

if (localStorage.getItem("sidebar") == "false") {
    $("body").addClass("sidebar-collapse");
}
function toggleSideBar(){
  if(localStorage.getItem("sidebar") == "true"){
    hideSideBar();
  }
  else{
    showSideBar();
  }
}
function hideSideBar() {
    $("body").addClass("sidebar-collapse");
    localStorage.setItem("sidebar", "false");
}

function showSideBar() {
    $("body").removeClass("sidebar-collapse");
    localStorage.setItem("sidebar", "true");
}

function startProfile() {
    var k = undefined;
    var g = $("#subjectTXT").val();
    var f = $("#yearTXT").val();
    var c = $("#termTXT").val();
    var e = $("#classTXT").val();
    var b = $("#modeTXT").val();
    var h = $("#cwTXT").val();
    var j = Array();
    if (g === "null") {
        j.push("The subject is required")
    }
    if (e === "") {
        j.push("Name of class is required")
    }
    if (f === "null") {
        j.push("The year is required")
    }
    if (c === "null") {
        j.push("The term is required")
    }
    if (b === "null") {
        j.push("The year of admission of the class is required")
    }
    if (h === "null") {
        j.push("The number of course works is required")
    }
    var a = "#errors-box";
    $(a).empty();
    var d = 0;
    if (j.length > 0) {
        $(a).append("<a class='list-group-item list-group-item-danger bitter active'>The following errors were found !</a>");
        $(a).fadeIn(100, function () {
            for (d = 0; d <= j.length - 1; d++) {
                $(a).append("<a class='list-group-item txt-danger'>" + j[d] + "</a>")
            }
        });
        return
    }
    $Profiler.startProfile(k, g, c, f, e, b, h)
}
function prof_next(b, e) {
    var d = parseInt($("#current-prof-sect").val());
    if (e == 1) {
        var f = $("#class-" + b + " #input-class-id").val();
        var h = $("#class-" + b + " #subject-class-id").val();
        h = parseInt(h);
        f = parseInt(f);
        $("#subjectTXT").val(h);
        $("#classTXT").val(f);
        getClassYears(f)
    }
    var c = d + 1;
    var a = $("#current-prof-sect").val(c);
    var g = "#new-sheet-form #step-" + c;
    $("#prof-" + d).animate({"margin-left": "130%", display: "none", height: 0, opacity: 0}, {
        duration: 700, complete: function () {
            $("#prof-" + c).slideDown()
        }
    });
    $("#new-sheet-form .steps .step").removeClass("active");
    $(g).addClass("active");
    $(g).animate({height: "100%"});
    $("#prof-" + c).fadeIn(400)
}
function profBack(b) {
    $("#new-profile-menu").remove();
    getProfileForm();
    $("#current-prof-sect").val(1);
    var d = parseInt($("#current-prof-sect").val());
    return;
    var c = d - 1;
    var a = $("#current-prof-sect").val(c);
    var e = "#new-sheet-form #step-" + c;
    $("#prof-" + c).animate({"margin-left": "2%", display: "block", height: "100%", opacity: 1}, {
        duration: 700, complete: function () {
            $("#prof-" + d).hide()
        }
    });
    $("#new-sheet-form .steps .step").removeClass("active");
    $(e).addClass("active");
    $(e).animate({height: "100%"});
    $("#prof-" + c).fadeIn(400)
}
function getClassYears(a) {
    $.ajax({
        type: "POST",
        url: "../executers/get_classes.php",
        data: "class_id=" + a,
        dataType: "html",
        success: function (d, f) {

            var b = JSON.parse(d.toString());
            switch (b.status) {
                case"emptyParamsException":
                    msgInfo("Something went wrong during execution of your command. Technical detail (emptyParamsException)");
                    break;
                case"NoClassesException":
                  
                    $("#new-profile-menu,.overlay").remove();
                    msgWarning("<b>Sorry!</b> No students were found in this class, so the <strong>Profile Creation Wizard</strong> had to stop</p>");
                    $("#msg-box").transition({scale: 0.8});
                    $("#msg-box").transition({scale: 1});
                    break;
                default:
                    var e;
                    for (var c = 0; c < b.length; c++) {
                        e += "<option>";
                        e += b[c];
                        e += "</option>"
                    }
                    $("#modeTXT").append(e);
                    break
            }
        },
        error: function (c, d, b) {
            console.log(b)
        }
    })
}
function updateMarks(h, f, g, e, d, b) {
    var a = "#st-" + g + " #cw-" + f;
    var c = $(a).val();
    if (isNaN(c) == true || (c > 100 || c < 0)) {
        $(a).val(e);
        $(a).focus();
        msgWarning("marks can only be 0-100 inclusive, We have restored the previous value of the cell. NB** marks are expressed as percentages");
        return
    }
    if (c == e) {
        return
    }
    $(a).removeClass("pass");
    $(a).removeClass("fail");
    if (c >= 50) {
        $(a).addClass("pass")
    } else {
        $(a).addClass("fail")
    }
    $Profiler.updateMarks(h, f, c, g, d, b)
}
function fetchUI(a, b) {
    $Profiler.getSheetUI(a, b)
}
function getSheet(a, d, c, f, g, b, e) {
    $Profiler.getUI(a, d, c, f, g, b, e, 2)
}
function compile(d) {
    var b = $("#current-profile-id").val();
    var c = $("#cwwTXT").val();
    var a = $("#fewTXT").val();
    var d = $("#course-wk-num").val();
    $Profiler.compileProfile(b, d, c, a)
}
function compileDialog() {
    $("#overlay,#compile").fadeToggle(250);
    $("#progress-report").hide()
}
function addTestsDialog() {
    $("#overlay,#add-test").fadeToggle(250);
    $("#progress-report").hide()
}
function addStudentDialog() {
    $("#overlay,#add-student").fadeToggle(250)
}
function resetLayout() {
    $("#ajax-data-box").slideUp(500, function () {
        $("#preloaded-menu,#new-profile-menu").fadeIn(200);
        if (typeof window.localStorage !== undefined) {
            var b = localStorage.getItem("sidebar");
            localStorage.clear();
            localStorage.setItem("position", "list");
            localStorage.setItem("sidebar", b);
            var a = localStorage.getItem("position");
            if (a === "list") {
                localStorage.removeItem("data_url")
            }
        } else {
            promptyBrowserUpgrade()
        }
    })
}
function addStudentToProfile(a) {
    var b = $("#cnTXT").val();
    $Profiler.addStudentManually(b, a)
}
function addToSearchField(a) {
    $("#cnTXT").val(a);
    $("#result-el").empty()
}
function getDialog(a) {
    $("#progress-report").fadeIn(5);
    $.ajax({
        type: "GET", url: "../views/" + a + ".php", dataType: "html", success: function (b, c) {
            $("#progress-report").fadeOut(500);
            $("body").css({overflow: "hidden"});
            $("#msg-box").remove();
            $("body").append(b.toString());
            if (a == "feedback_form") {
                $("#current_url").attr("value", location.href.toString())
            }
        }, error: function (c, d, b) {
            console.log(b);
            $("#progress-report").fadeOut(500)
        }
    })
}
function destroyDialog(a) {
    $("#overlay").remove();
    $("#overlay").hide();
    $("body").css({overflow: "scroll"});
    switch (a) {
        case"about":
            $("#about").remove();
            break;
        case"feedback_form":
            $("#report").remove();
            break;
        case"security":
            $("#report").remove();
            break
    }
}
function logout() {
    $.ajax({
        type: "POST", url: "../executers/logout.php", dataType: "html", success: function (b, c) {
            var a = b.toString();
            switch (a) {
                case"success":
                    if (typeof window.localStorage !== undefined) {
                        localStorage.clear()
                    }
                    location.reload();
                    break;
                case"failed":
                    msgInfo("Logging out could not continue. Please refresh the page to lock this session");
                    break;
                default:
                    msgInfo("Ooops !, we could log you out due to a error");
                    break
            }
        }, error: function (b, c, a) {
            msgWarning("To be honest we dont have an idea of what happened, Please tell your systems admin if it persists")
        }
    })
}
function toggleMoreDetails() {
    $(".hidden-more").fadeToggle(1800)
}
function getProfileForm() {
    $("#loading").fadeIn(300);
    $.ajax({
        type: "POST", url: "../views/new_sheet_form.php", dataType: "html", success: function (b, c) {
            $("#loading").fadeOut(300);
            var a = b.toString();

            $("body").append(a);
            $("#overlay").show()
        }, error: function (b, c, a) {
            $("#loading").fadeOut(300);
            msgWarning("To be honest we dont have an idea of what happened, Please tell your systems admin if it persists")
        }
    })
}
function promptyBrowserUpgrade() {
    var a = "<div class='overlay' id='up-overlay'></div>";
    a += '<div class="modal" id="upgrade-prompt">';
    a += '<div class="modal-dialog">';
    a += '<div class="modal-content">';
    a += '<div class="modal-header">';
    a += '<h4 class="modal-title">Ooops! Please Upgrade your browser</h4>';
    a += "</div>";
    a += '<div class="modal-body">';
    a += '<div id="warning" class="col-lg-12">';
    a += '<span class="typcn typcnlightbulb xl"><img src="../assets/icons/144/idea-144.png"/></span>';
    a += "<p>We believe that you deserve the best, for us to do that we need to use the browsers' cutting edge technologies and capabilities. Please upgrade your browser to the newest version to unlock the magic that makes this app awesome.</p>";
    a += "<p>If you choose to ignore you can still use the app but some features may not work properly.</p>";
    a += "</div>";
    a += "</div>";
    a += '<div class="modal-footer">';
    a += "</div></div></div></div>";
    $("body").append(a)
}
function updateTests(a) {
    $("#loading").fadeIn(500);
    var b = $("#tuTXT").val();
    if (b == undefined) {
        msgError("New value could not be allocated, please report this if it persists: ClientException");
        return
    }
    $.ajax({
        type: "POST",
        url: "../executers/add_tests.php",
        data: "profile_id=" + a + "&new_value=" + b + "&" + url_token_val,
        dataType: "html",
        success: function (d, e) {
            var c = JSON.parse(d.toString());
            switch (c.status) {
                case"success":
                    msgInfo("The number of tests have been updated, your browser will refresh automatically, if it doesnt refresh please refresh the browser to start using the updated profile");
                    setTimeout(function () {
                        location.reload()
                    }, 1000);
                    break;
                case"failed":
                    msgInfo("Ooops, sorry the update failed probably because the profile is closed");
                    break;
                default:
                    msgInfo("Ooops, sorry response could not be handled by the app, please report this if it persists");
                    break
            }
        },
        error: function (d, e, c) {
            console.log(c);
            $("#loading").fadeOut(500)
        }
    })
}

function getProfileMetaUI(profile_id) {
    $.ajax({
        type: "POST",
        url: "profile_meta.php",
        data: "pid=" + profile_id,
        dataType: "html",
        success: function (data, textStatus, jqXHR) {
            $("body").prepend(data);
            $("#overlay").show();
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    });
}
/*Size: 14666->8899Bytes
 Saved 39.32224%*/
