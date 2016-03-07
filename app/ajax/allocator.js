ClassAllocator = {
    getEntries: function() {

    },
    saveEntries: function(tr_id) {
        var subject_id, class_id;

        subject_id = $("#subject-alloc").val();
        class_id = $("#class-alloc").val();

        $("#class-progress").show();
        $.ajax({
            type: 'POST',
            url: "../executers/class_exec.php",
            data: "action=allocate&tr_id=" + tr_id + "&class_id=" + class_id + "&subject_id=" + subject_id,
            dataType: 'html',
            success: function(html, textStatus) {
                $("#class-progress").hide();
                console.log(html.toString());
                var response = JSON.parse(html.toString());
                
                switch (response.status) {

                    case "TAKEN":
                        msgWarning("Class you are trying to allocate is already allocated to this teacher");
                        break;

                    case "SQLExecutionException":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer");
                        break;

                    case "success":
                        $("#subject-tags").removeClass(",active-tag");
                        var subject = response.subject;
                        var class_name = response.class;
                        var class_id = response.class_id;
                        
                        var new_tag_ui;

                        new_tag_ui = '<div class="ui image label tr-subs-label active-tag">';
                        new_tag_ui += '<h6 class="bold"><span>' + subject + '</span></h6>';
                        new_tag_ui += '<h6 class="bold"><span>' + class_name + '</span></h6>';
                        new_tag_ui +="<button class='btn btn-xs btn-danger margin' disabled>remove</button>" ;
                        new_tag_ui += '</div>';

                        $("#subject-tags").append(new_tag_ui);
                        $("#subject-tags .active-tag").slideDown(400);
                        msgSuccess("allocation of subject <span class='bold text-info'>"+ subject +"</span> and class <span class='bold text-info'>"+ class_name +"</span> was successful");
                        break;

                    case "failed":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer");
                        break;

                    default:
                        msgWarning("Unknown response");

                        break;
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                $("#class-progress").hide();
                msgError('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
            }
        });

    },
    addClass: function() {
        var class_name, class_desc, class_level;

        class_name = $("#new-class-name").val();
        class_desc = $("#new-class-desc").val();
        class_level = $("#new-class-level").val();

        $("#class-progress").show();

        $.ajax({
            type: 'POST',
            url: "../executers/class_exec.php",
            data: "action=add&class_name=" + class_name + "&class_desc=" + class_desc + "&level=" + class_level,
            dataType: 'html',
            success: function(html, textStatus) {
                $("#class-progress").hide();
                var response = html.toString();

                switch (response) {

                    case "EmptyParamsException":
                        msgWarning("please fill in all fields, they are required");
                        break;

                    case "taken":
                        msgWarning("Class already exists");
                        break;

                    case "SQLExecutionException":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer");
                        break;

                    case "success":
                        var class_ui = "<a href='#' class='list-group-item'>";
                        class_ui += "<span class='typcn typcn-tags'></span>";
                        class_ui += "<span><span class='text-danger bold'>" + class_name + "</span>";
                        class_ui += "<p class='list-group-item-text'>" + class_desc + "</p></a>";

                        $("#classes-list").prepend(class_ui);
                        //  $("#overlay,#class-creator").fadeOut(500);
                        msgSuccess("Class <span class='text-danger bold'>" + class_name + "</span> successfully added");
                        break;

                    case "failed":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer");
                        break;

                    default:
                        msgWarning("Unknown response");

                        break;
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                $("#class-progress").hide();
                msgError('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
            }
        });

    },
    removeAllocation: function(id) {

        $("#class-progress").show();

        $.ajax({
            type: 'POST',
            url: "../executers/class_exec.php",
            data: "action=remove&id=" + id,
            dataType: 'html',
            success: function(html, textStatus) {
                $("#class-progress").hide();
                var response = html.toString();

                switch (response) {

                    case "EmptyParamsException":
                        msgWarning("please fill in all fields, they are required");
                        break;

                    case "SQLExecutionException":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer");
                        break;

                    case "success":
                        $("#allocation-" + id).fadeOut(300);
                        msgSuccess("Class <span class='text-danger bold'>" + class_name + "</span> successfully added");
                        break;

                    case "failed":
                        msgError("Oops! an internal error just happened, refresh the page and try again. If this persists please notify the developer");
                        break;

                    default:
                        msgWarning("Unknown response");
                        break;
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                $("#class-progress").hide();
                msgError('an error just happened and we are embarassed and working on it');// + (errorThrown ? errorThrown : xhr.status)
            }
        });

    }
};
