<?php

require_once "../logic/AccessManager.php";
require_once "../logic/ClassManager.php";
@session_start();
if (Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php");
    die();
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(
    Aculyse\AccessLevels::LEVEL_ADMIN_ONLY,
    Aculyse\AccessLevels::LEVEL_WRITE_STUDENTS,
    Aculyse\AccessLevels::LEVEL_SINGLE_MODE
        );

$access_level_num = $_SESSION["user"]["access_level"]["right"];

if (!in_array($access_level_num, $allowed_levels)) {
    die("AcessLevelViolationException");
}

if (!isset($_POST["action"])) {
    die("EmptyActionException");
}

$action = $_POST["action"];

$ClassManager = new \Aculyse\ClassManager();

switch ($action) {
    case 'allocate':
        if (!isset($_POST["tr_id"]) || !isset($_POST["class_id"]) || !isset($_POST["subject_id"])) {
            die("EmptyParamsException");
        }
        $teacher_id = $_POST["tr_id"];
        $class_id = $_POST["class_id"];
        $subject_id = $_POST["subject_id"];

        $request = $ClassManager->allocateClassToTeacher($subject_id, $class_id, $teacher_id);
        print_r($request);

        break;

    case 'remove':
        if (!isset($_POST["id"]) || empty($_POST["id"])) {
            die("EmptyParamsException");
        }
        $id = $_POST["id"];
        $request = $ClassManager->deallocateSubjectToTeacher($id);
        print_r($request);
        break;

    case 'add':
        if (!isset($_POST["class_name"][1]) || !isset($_POST["level"][1])) {
            die("EmptyParamsException");
        }
        $class_name = $_POST["class_name"];
        $class_description = $_POST["class_desc"];
        $level = $_POST["level"];

        $request = $ClassManager->createClass($class_name, $class_description, $level);
        print_r($request);
        break;

    case 'update':
        # code...
        break;

    case 'get':
        $request = $ClassManager->getClassesOfferedAtSchool();

        $classes_ui="";
        if (is_array($request)) {

            for ($i = 0; $i < sizeof($request); $i++) {
                $class_name = strtoupper(htmlspecialchars_decode($request[$i]["class_name"]));
                $class_level = strtoupper(htmlspecialchars_decode($request[$i]["level"]));
                $class_description = htmlspecialchars_decode($request[$i]["desc"]);
                $class_id = $request[$i]["class_id"];
                $classes_ui .= "<div class='col-lg-12 pointer with-divider' onclick='startUpdating(\"e-class-$class_id\",\"class_name\")'>";
                $classes_ui .= "<div class='col-lg-1 padding'><img src='../assets/icons/48/department-48.png'/></div>";
                $classes_ui .= "<div class='col-lg-11'>";
                $classes_ui .= "<h5 class='text-danger bold'>$class_name</h5>";
                if ($class_level == "") {
                    
                } else {
                    $classes_ui .= "<h6 class='bold text-success'>LEVEL-$class_level</h6>";
                }
                $classes_ui .= "<input type='hidden' id='e-class-$class_id-txt'  value='$class_id' />";
                $classes_ui .= "<p class='bold'>$class_description</p>";
                $classes_ui .= "</div>";
                $classes_ui .= "</div>";
            }
            print_r($classes_ui);
        } else {
            echo '<div id="warning" class="col-lg-12">

    <span class="typcn typcn-info"></span>
    <h4>No classes available</h4>
    <p class="filler">No classes available</p>
</div>';
        }
        break;


    default:
        # code...
        break;
}
