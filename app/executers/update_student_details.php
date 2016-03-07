<?php

require_once "../logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(1, Aculyse\AccessLevels::LEVEL_ADMIN_ONLY,Aculyse\AccessLevels::LEVEL_SINGLE_MODE) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}

require_once '../logic/StudentWriter.php' ;
require_once '../logic/Validate.php' ;


//field to update
if(!isset($_POST['field'][1]) || !isset($_POST['user'][1]) || !isset($_POST['value'])) {
    die("EmptyParameterException") ;
}

$field = $_POST["field"] ;
$value = $_POST["value"] ;
$user = $_POST["user"] ;


//lets validate the provided data

switch($field) {

    case "college number":
        if(Aculyse\Validate::validateCollegeNumber($value) === FALSE) {
            die("DataFormatException") ;
        }

    case "firstname":
        if(Aculyse\Validate::validatePersonName($value , TRUE) === FALSE) {
            die("DataFormatException") ;
        }
        break ;

    case "middlename":
        if(Aculyse\Validate::validatePersonName($value , FALSE) === FALSE) {
            die("DataFormatException") ;
        }
        break ;

    case "surname":
        if(Aculyse\Validate::validatePersonName($value , TRUE) === FALSE) {
            die("DataFormatException") ;
        }
        break ;

    case "national id number":
        if(Aculyse\Validate::validateNationalIdNumber($value) === FALSE) {
            die("DataFormatException") ;
        }
        break ;

    case "dob":
        break ;

    case "sex":
        if(Aculyse\Validate::validateSex($value , TRUE) === FALSE) {
            die("DataFormatException") ;
        }

        break ;

    case "cell number":

        if(Aculyse\Validate::validatePhoneNumber($value , FALSE) === FALSE) {
            die("DataFormatException") ;
        }
        break ;

    case "email":

        if(Aculyse\Validate::validateEmail($value , FALSE) === FALSE) {
            die("DataFormatException") ;
        }
        break ;
}

//everything is fine so start the saving process
$StudentUpdater = new Aculyse\StudentsWriter() ;
$response = $StudentUpdater->updateProfile($field , $value , $user) ;
print_r($response) ;
