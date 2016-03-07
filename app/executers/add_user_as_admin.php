<?php

require_once "../logic/AccessManager.php";
@session_start();
if (Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php");
    die();
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(6);
$access_level_num =$_SESSION["user"]["access_level"]["right"];
if(!in_array($access_level_num, $allowed_levels)){
    if($access_level_num==Aculyse\AccessLevels::LEVEL_SINGLE_MODE){
        die(json_encode(array("status"=>"NotAllowedSingleException")));
    }
      die(json_encode(array("status"=>"AcessLevelViolationException")));
}


require_once "../logic/Users.php" ;


$firstname = $_POST["firstname"] ;
$middlename = $_POST["middlename"] ;
$surname = $_POST["surname"] ;
$sex = $_POST["sex"] ;
$contact_num = $_POST["contact_num"] ;
$email = $_POST["email"] ;
$access_level = $_POST["access_level"] ;
$username = $_POST["username"] ;
$password = $_POST["password"] ;
$auto_generate_credentials = $_POST["agc"] ;



$user_data = array(
    "firstname" => $firstname ,
    "middlename" => $middlename ,
    "surname" => $surname ,
    "sex" => $sex ,
    "contact_num" => $contact_num ,
    "email" => $email ,
    "access_level" => $access_level ,
    "username" => $username ,
    "password" => $password ,
    "agc" => $auto_generate_credentials
        ) ;


$UserWriter = new Aculyse\Users() ;
$errors = $UserWriter->validateData($user_data) ;

//check if any errors were founbd in the subject
if(sizeof($errors) > 0) {
    $response = json_encode($errors) ;
    die($response) ;
}

//attempt to save the user data
$response = $UserWriter->saveUser($user_data) ;
echo($response);
