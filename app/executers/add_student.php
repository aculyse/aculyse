<?php

require_once "../logic/AccessManager.php" ;
require_once "../logic/Config.php" ;

@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(1 , Aculyse\AccessLevels::LEVEL_ADMIN_ONLY,Aculyse\AccessLevels::LEVEL_SINGLE_MODE) ;

$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}


require_once '../logic/StudentWriter.php' ;


//get input from url
$surname = $_POST["surname"] ;
$middlename = $_POST["middlename"] ;
$firstname = $_POST["firstname"] ;
$sex = $_POST["sex"] ;

$student_id = $_POST["college_number"] ;
$class_id = $_POST["class"] ;
$class_of = $_POST["class_of"] ;
$school = $_SESSION["user"]["school"] ;

$home_address = $_POST['home'] ;
$cell_number = $_POST["cell"] ;
$email_address = $_POST["email"] ;
$dob = $_POST["dob"] ;


$StudentWriter = new Aculyse\StudentsWriter() ;
if(empty($student_id)) {
    $student_id = $StudentWriter->generateStudentNum() ;
}
$account_status = $StudentWriter->isAccountAvailable($student_id) ;

//check if critical data is missing
if (empty($student_id) || empty($firstname) || empty($surname) || empty($sex) || empty($class_id)) {
    print_r(json_encode(array("status" => "CriticalDataMissing")));
    die();
}

if($account_status == ACCOUNT_TAKEN) {
    print_r(json_encode(array("status" => "account taken")));
    die();
    
}

$result = $StudentWriter->addNewStudent($student_id , $class_id , NULL , $firstname , $middlename , $surname , NULL , NULL , $sex , $cell_number , $email_address , $home_address , $dob , $class_id , $class_of , $school) ;

if(is_array($result)) {
    print_r(json_encode($result)) ;
    return ;
}
if($result == TRUE) {
    print_r(json_encode(array("status" => "success", "student_id" => $student_id)));
    die();
}
else {
    print_r($result) ;
    print_r("Error") ;
    die();
}
