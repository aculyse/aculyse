<?php

namespace Aculyse;

//require_once "../vendor/autoload.php";

final class UIGenerator
{

    public static function drawSheet($users, $course_work_num, $existing = NULL)
    {
      
        $ClassManager = new ClassManager();
        $Profiler = new Profiler();
        $Students = new students();
        $dataset = $existing;
        

        if ($dataset->count() == 0) {
            require_once "../includes/profile_not_found.php";
        }

        if (sizeof($existing) == 0) {
            return "NoDataException";
        }

        $profile_id = $existing[0]["profile id"];
      
        $profile_details = $Profiler->getProfileStatus($profile_id);


        if (!is_null($profile_details)) {
            $course_work_num = $profile_details["number of courseworks"];
            $subject = $profile_details["subject"];
            $subject_title = $Profiler->getSubjectName($subject)["title"];
            $year = $profile_details["year"];
            $term = $profile_details["term"];
            $mode = $profile_details["class_name"];
            $class_name = strtoupper($ClassManager->getClassDetails($mode)[0]["class_name"]);

            $class_of = $profile_details["class of"];
            $status = $profile_details["status"];
            $number_of_students = sizeof($existing);

        } else {
            echo "An internal error just happened, if this persists please report this to your system administrator";
            return;
        }

        if ($status == "closed") {
            $alert_ui = "<div class='col-md-12'>";
            $alert_ui .= "<div class='alert alert-warning alert-dismissable'>";
            $alert_ui .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
            $alert_ui .= "<strong>Pro tip! </strong> We just wanted to let you know that this profile was CLOSED meaning it was once compiled, if you make changes to the marks make sure you compile again so that analytics are updated and the marks reflected on reports, Happy profiling";
            $alert_ui .= "</div>";
            $alert_ui .= "</div>";

            echo $alert_ui;

            $edit_status = 'readonly';
        }

        $easy_identity_data = array(
            1 => array("theme" => "info", "icon" => "flaticon-edu-shelf", "heading" => "Subject", "text" => $subject_title),
            2 => array("theme" => "info", "icon" => "flaticon-weekly3", "heading" => "Year", "text" => $year),
            3 => array("theme" => "info", "icon" => "flaticon-watch10", "heading" => "Term", "text" => $term),
            4 => array("theme" => "info", "icon" => "flaticon-sand4", "heading" => "Class of", "text" => $class_of),
            5 => array("theme" => "info", "icon" => "flaticon-edu-schoolclass", "heading" => "Class Name", "text" => $class_name),
            6 => array("theme" => "success", "icon" => "flaticon-edu-school6", "heading" => "Tests", "text" => $course_work_num),
            7 => array("theme" => "danger", "icon" => "flaticon-edu-amount", "heading" => "Student(s)", "text" => $number_of_students)
        );
        /* start generating easy identity ui */
        $easy_identity_ui = NULL;
        $full_easy_identity_ui = NULL;
        for ($i = 1; $i <= sizeof($easy_identity_data); $i++) {

            $theme = $easy_identity_data[$i]["theme"];
            $icon = $easy_identity_data[$i]["icon"];
            $heading = $easy_identity_data[$i]["heading"];
            $text = $easy_identity_data[$i]["text"];
            if ($heading == "Subject") {
                $easy_identity_ui = "<div class='col-lg-6 col-md-6'>";
            } else {
                $easy_identity_ui = "<div class='col-lg-3 col-md-6'>";
            }
            $easy_identity_ui .= "<div class='panel panel-$theme'>";
            $easy_identity_ui .= "<div class='panel-heading'>";
            $easy_identity_ui .= "<div class='row'>";
            $easy_identity_ui .= "<div class='col-xs-3'>";
            $easy_identity_ui .= "<i class='glyph-icon $icon xl big-icon'></i>";
            $easy_identity_ui .= "</div>";
            $easy_identity_ui .= "<div class='col-xs-9 text-right'>";

            $easy_identity_ui .= "<div>$heading</div>";
            $easy_identity_ui .= "<div class='huge xl'>$text</div>";

            $easy_identity_ui .= "</div>";
            $easy_identity_ui .= " </div>";
            $easy_identity_ui .= "</div>";

            $easy_identity_ui .= "</div>";
            $easy_identity_ui .= "</div>";
            $full_easy_identity_ui .=$easy_identity_ui;
        }

        print_r($full_easy_identity_ui);

        //start constructing the spreadsheet

        $table_ui = "<div class='col-md-12'>"
                . "<table id='current-profile-table' class='base-table'>";

        $table_ui .= "<thead><th></th><th>Student ID</th>";
        $table_ui .= "<th>Fullname</th>";
//generate coursework columns
        for ($i = 1; $i <= $course_work_num; $i++) {
            $table_ui .= "<th class='cwr'>Test $i</th>";
        }

        $table_ui .= "<th class='cwr'>Exam</th></thead><tbody>";


        for ($i = 0; $i <= sizeof($existing) - 1; $i++) {

            $student_info = $Students->getStudents(NULL, "SINGLE", $existing[$i]["student id"], NULL, NULL);
            $student_marks_id = $existing[$i]["id"];

            $student_id = strtoupper(htmlspecialchars($student_info[0]["student id"]));
            $student_id_stripped = preg_replace("^/^", "", $student_id);

            $student_data = $Profiler->addIndividualInProfile($student_id);
            $avatar = $student_info[0]["avatar"];
            $firstname = strtoupper(htmlspecialchars($student_info[0]["firstname"]));
            $middle_name = strtoupper(htmlspecialchars($student_info[0]["middle name"]));
            $surname = strtoupper(htmlspecialchars($student_info[0]["surname"]));

            if ($middle_name == "") {
                $fullname = $firstname . " " . $surname;
            } else {
                $fullname = $firstname . " " . $middle_name . " " . $surname;
            }

            $table_ui .= "<tr id='st-$student_id_stripped'>";
            $table_ui .= "<td><img src='$avatar' width=30 height=30 class='img-rounded'/></td>";
            if (!is_null($existing)) {
                $table_ui .= "<td class='pass text-bold'><a class='text-bold' href='single?cn=$student_id&subject=$subject&pid=$profile_id'>$student_id</a></td>";
            } else {
                $table_ui .= "<td class='pass text-bold'><a class='text-bold' href='single?cn=$student_id&subject=$subject&pid=$profile_id'>$student_id</a></td>";
            }
            $table_ui .= "<td>$fullname</td>";


            //generate coursework columns
            $course_work_val = 0;
            for ($j = 1; $j <= $course_work_num; $j++) {
                if (!is_null($existing)) {
                    $id = strtoupper(htmlspecialchars($existing[$i]["id"]));
                    $course_work_val = $existing[$i]["course work $j"];
                    if ($course_work_val < 50) {
                        $table_ui .= "<td><span class='hidden'>$course_work_val</span><input type='text' class='input fail' id='cw-$j' value='$course_work_val' onblur='updateMarks($student_marks_id,$j,\"$student_id_stripped\",$course_work_val,\"false\",$profile_id);'/></td>";
                    } else {

                        $table_ui .= "<td><span class='hidden'>$course_work_val</span><input type='text' class='input pass' id='cw-$j' value='$course_work_val' onblur='updateMarks($student_marks_id,$j,\"$student_id_stripped\",$course_work_val,\"false\",$profile_id);'/></td>";
                    }
                }
            }


            if (!is_null($existing)) {
                $exam_mark = htmlspecialchars($existing[$i]["final exam"]);

                if ($exam_mark < 50) {
                    $table_ui .= "<td><span class='hidden'>$course_work_val</span><input type='text' class='input final-mark fail' id='cw-$j' value='$exam_mark' onblur='updateMarks($student_marks_id,$j,\"$student_id_stripped\",$course_work_val,\"true\",$profile_id);'/></td>";
                } else {
                    $table_ui .= "<td><span class='hidden'>$course_work_val</span><input type='text' class='input final-mark pass' id='cw-$j' value='$exam_mark' onblur='updateMarks($student_marks_id,$j,\"$student_id_stripped\",$course_work_val,\"true\",$profile_id);'/></td>";
                }
            } else {
                $table_ui .= "<td><span class='hidden'>$course_work_val</span><input type='text' class='input final-mark ' id='cw-$j' value='0' onblur='updateMarks($student_marks_id,$j,\"$student_id_stripped\",$course_work_val,\"true\",$profile_id);'/></td>";
            }

            $table_ui .= "</tr>";
        }
        $table_ui .= "</tbody></table>"
                . "<input type='hidden' value='$profile_id' id='current-profile-id'/>
    <input type='hidden' value='$course_work_num' id='course-wk-num'/></div>";

        echo $table_ui;
    }

    public static function getProfilesTable($type = NULL)
    {

        $Profiler = new Profiler();
        $ClassManager = new ClassManager();

        $dataset = FALSE;

        if ($type == "markboard") {
            $targe_url = "markboard";
            $dataset = $Profiler->getTeacherProfiles();
        }
        if ($type == "analyser") {
            $targe_url = "analyser";
            $dataset = $Profiler->getClosedProfiles();
        }

        if ($dataset == FALSE || sizeof($dataset)==0) {
            include_once '../includes/no_profile.php';
            return;
        } else {
            $table_ui = "<table id='student-list-table' class='base-table'>";
            $table_ui.= "<thead><th>SUBJECT</th>";
            $table_ui.= "<th>YEAR</th>";
            $table_ui.= "<th>TERM</th>";
            $table_ui.= "<th>CLASS NAME</th>";
            $table_ui.= "<th>CLASS OF</th>";
            $table_ui.= "<th>STATUS</th>";
            $table_ui.= "<th>CREATED</th></thead><tbody>";

            foreach ($dataset as $profile) {
                $status = $profile->status;
                $proccessed_timestamp = TimeConvertor::convertDatetime($profile->created);
                $calculated_ago_time = TimeConvertor::makeAgo($proccessed_timestamp);

                $table_ui.= "<tr>";
                $table_ui.= "<td><a href='$targe_url.php?profile_id=$profile->id' class='bold'>" . strtoupper($profile->for_subject["title"]) . "</a></td>";

                $table_ui.= "<td class='fail'>$profile->year</td>";
                $table_ui.= "<td class='pass'>$profile->term</td>";
                $table_ui.= "<td>" . strtoupper($profile->classes['class_name']) . "</td>";
                $table_ui.= "<td>" . $profile["class of"] . "</td>";

                if ($status == "closed") {
                    $table_ui .= "<td><span class='badge badge-danger'>Closed</span></td>";
                } else if ($status == "in progress") {
                    $table_ui .= "<td><span class='badge badge-info'>In progress</span></td>";
                } else {

                    $table_ui .= "<td><span class='badge badge-info'>Unkown</span></td>";
                }
                $table_ui.= "<td class='text-info'>$calculated_ago_time</td>";
                $table_ui .= "</tr>";
            }

            $table_ui.= "</tbody></table>";

            echo $table_ui;
        }
    }

}
