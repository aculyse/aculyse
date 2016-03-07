<?php

require_once '../logic/AccessManager.php' ;
require_once '../logic/Validate.php' ;

@session_start() ;
if(!isset($_SESSION["reset"])){
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    die('{"status":"SessionInvalidException"}') ;
}
}
if(empty($_SESSION["user"]["id"]) || empty($_POST["op"]) || empty($_POST["np"]) || empty($_POST["cnp"])) {
    die('{"status":"EmptyParameterException"}') ;
}
$username = $_SESSION["user"]["id"] ;
$old_password = $_POST["op"] ;
$new_password = $_POST["np"] ;
$confirmed_password=$_POST["cnp"];


if(Aculyse\Validate::validatePasswordCriteria($new_password) == FALSE) {
    die('{"status":"PasswordCriteriaNotMet"}') ;
}


if(Aculyse\Validate::validatePasswordMatch($confirmed_password, $new_password)==FALSE) {
    die('{"status":"PasswordMismatch"}') ;
}


if($old_password == $new_password){
	die('{"status":"SamePassword"}') ;
}
$ChangePassword = new Aculyse\AccessManager() ;
$response = $ChangePassword->changePassword($username , $old_password , $new_password) ;
print_r($response) ;
