<?php

/*
 * add a new school
 */
require_once '../logic/SchoolManager.php' ;

$fullname = $_POST["fullname"] ;
$email = $_POST["email"] ;
$username = $_POST["username"] ;
$password = $_POST["password"] ;
$school_name = $_POST["school_name"] ;
$school_type = $_POST["school_type"] ;

$data = array(
    "name" => $fullname ,
    "username" => $username ,
    "email" => $email ,
    "pwd" => $password ,
    "school name" => $school_name ,
    "school type" => $school_type
        ) ;

$SchoolManager = new Aculyse\SchoolManager() ;
$response = $SchoolManager->createAccount($data) ;
print_r($response) ;
