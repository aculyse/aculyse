<?php

namespace Aculyse;

require_once '../../vendor/autoload.php';

$profile_id = $_POST["profile_id"];
$subject = $_POST["subTXT"];
$term = $_POST["termTXT"];
$year = $_POST["yrTXT"];
$mode = $_POST["modeTXT"];
$class_of = $_POST["classofTXT"];
$course_work_num = $_POST["cwTXT"];

if ($year > $class_of) {
    die(json_encode(array("status" => "InvalidYearException", "year" => $year, "class" => $class_of)));
}

$params = array("profile_id" => $profile_id, "subject" => $subject, "term" => $term, "year" => $year, "course work" => $course_work_num, "mode" => $mode, "class of" => $class_of);

$Profiler = new Profiler();

if ($Profiler->isProfileNotTaken($params) == TRUE) {

    $users = $Profiler->getClassStudents($params);

    if (is_array($users)) {
        $response = $Profiler->initializeProfile($users, $params);
        print_r($response);
    } else {
        require_once "../includes/new_profile_not_found.php  ";
        die();
    }
} else {
    print_r(json_encode(array("status" => "available")));
}