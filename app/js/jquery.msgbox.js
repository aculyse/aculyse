/**
 * @author Mashoko Blessing <bmashcom@hotmail,com>
 * @copyright 2014
 * you are free to modify or distribute...
 */

var error;
var msg;
var time;
var msg_ui;
var icon;
var icon_font;
var coloring = null;
var type, heading;

function messageBox(icon, msg, mode) {

//destroy previous boxes before proceeding
    $("#msg-box").remove();
    //decide the icon to use
    switch (icon) {
        case "error":
            icon_font = '<span class="typcn typcn-times"></span>';
            coloring = "color-2";
            type = "danger";

            break;

        case "success":
            icon_font = '<span class="typcn typcn-tick"></span>';
            coloring = "color-7";
            type = "success";
            break;

        case "warning":
            icon_font = '<span class="typcn typcn-warning"></span>';
            coloring = "color-3";
            type = "warning";
            break;

        case "info":
            icon_font = '<span class="typcn typcn-info"></span>';
            coloring = "color-6";
            type = "info";
            break;

        default:
            icon_font = '<span class="typcn typcn-document-text"></span>';
            break;
    }
    msg_ui = "<div id='msg-box' class='panel panel-" + type + "'>";
    msg_ui += "<div class='panel-heading'>";
    msg_ui += "<h3 class='panel-title text-bold'>"  + icon + "</h3>";
    msg_ui += "</div>";
    msg_ui += "<div class='panel-body'>";
    msg_ui += msg
    msg_ui += "</div>";
    msg_ui += "<div class='panel-heading panel-bottom'>";
    msg_ui += "<button class='btn btn-default bold text-bold' onclick='closeMsg();'>Close</button>";
    msg_ui += "</div>";
    msg_ui += "</div>";
    $("body").append(msg_ui);

    if (mode !== "static") {
        setTimeout(function() {
            $("#msg-box").animate({
                "top": "0",
                "opacity": "0"
            })
        }, 3000);
    }



}

function msgError(msg, mode) {
    icon = "error";
    mode = "static";
    this.messageBox(icon, msg, mode);
}

function msgSuccess(msg, mode) {
    icon = "success";
    this.messageBox(icon, msg, mode);
}

function msgWarning(msg, mode) {
    icon = "warning";
    mode = "static";
    this.messageBox(icon, msg, mode);
}
function msgInfo(msg, mode) {
    icon = "info";
    mode = "static";
    this.messageBox(icon, msg, mode);
}

//force dialog closing
function closeMsg() {
    $("#overlay,.overlay").hide();
    $("#msg-box").slideDown(200,function(){
        $("#msg-box").remove();
    })
    
}

