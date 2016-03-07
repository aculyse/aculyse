<?php

/**
 * @author Mashoko Blessing <bmashcom@hotmail.com>
 * this file adds students manually into the profile, usually for those repaeting or deviated from original course outline
 * @copyright (c) 2015, Mashcom Softworks
 * @category executors
 */
require_once "../logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(Aculyse\AccessLevels::LEVEL_WRITE_ANALYTICS,Aculyse\AccessLevels::LEVEL_SINGLE_MODE) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}


require_once '../logic/Profiler.php' ;
require_once '../logic/Validate.php' ;

/* get variable for student ID and validate it */
$student_id = $_POST["cnTXT"] ;
$profile_id = $_POST["pid"] ;

$params = array("profile_id" => $profile_id , "student_id" => $student_id) ;

$Profiler = new Aculyse\Profiler() ;
$student_data = $Profiler->addIndividualInProfile($student_id) ;
$profile_status = $Profiler->getProfileStatus($profile_id);

if(!is_array($student_data)) {
    die("UserNotFoundException") ;
}
$status = $student_data[0]["status"];
$existing = $Profiler->getStudentMarks($student_id, $profile_id);

//student is deleted
if($status=="deleted"){
    die("StudentDeletedException");
}
//mark is not available, so add it
if($existing->count()==0){
    $Profiler->generateInitialMarks($student_data , $profile_id) ;
    die("success") ;
}else{
    die("ProfileAreadyExistingException") ;
}

//profile is not available
if(!is_array($profile_status)) {
    die("ProfileStatusNotAvailable") ;
}


