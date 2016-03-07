<?php
namespace Aculyse;
require_once '../../vendor/autoload.php';
@session_start() ;
if(AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}
//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(AccessLevels::LEVEL_WRITE_ANALYTICS,AccessLevels::LEVEL_SINGLE_MODE) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}

$profile_id = $_POST["profile_id"] ;
$course_work_num = $_POST["cwTXT"] ;
$course_work_weight = $_POST["cw_weightTXT"] ;
$final_exam_weight = $_POST["fe_weightTXT"] ;

$Profiler = new Profiler();

$profile_details = $Profiler->getProfileStatus($profile_id);
if ($profile_details->count()==0) {
    die();
}

$params = array("profile_id" => $profile_id, "course work" => $course_work_num, "class_name" => $profile_details["class_name"]);

try {
	$response = $Profiler->compileProfile($params , $course_work_weight , $final_exam_weight) ;
	print_r($response) ;
} catch (\Exception $e) {
	echo $e->getMessage();
}
