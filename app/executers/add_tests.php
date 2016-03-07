<?php

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

$profile_id = $_POST["profile_id"] ;
$new_value = $_POST["new_value"] ;

$Profiler = new Aculyse\Profiler() ;
$response = $Profiler->updateTestNumber($profile_id , $new_value) ;

if($response){
die((json_encode(array("status" => "success"))));
}
die((json_encode(array("status" => "failed"))));