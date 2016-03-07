<?php
namespace Aculyse;

require_once "../../vendor/autoload.php";

@session_start() ;
/* * ******************************************
  AUTHENTICATION
 * ******************************************* */
if(AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(4,AccessLevels::LEVEL_SINGLE_MODE) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}
$transaction_token = $_SESSION["user"]["transaction_token"] ;

$Profiler = new Profiler() ;

$id = $_POST["id"] ;
$column = $_POST["column"] ;
$value = $_POST["value"] ;
$is_final = $_POST["is_final"] ;
$profile_id = $_POST["profile_id"] ;
$passed_token = $_POST["token"] ;

//check if token passed through ajax can be partially trusted
if($passed_token != $transaction_token) {
    die("InvalidTransactionToken") ;
}

$response = $Profiler->updateMark($id , $column , $value , $is_final , $profile_id) ;
if($response){
	die("updated");
}
die("failed");
