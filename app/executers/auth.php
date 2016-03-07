<?php

namespace Aculyse;

require_once '../../vendor/autoload.php';

if ((!isset($_POST["username"]) || !isset($_POST["pwd"])) && (!isset($_GET["veri_code"]))) {
    die("EmptyParameterException");
}
//before we authenticate lets destroy previous sessions
//AccessManager::destroySession();
$AccessManager = new AccessManager();
$auth_response = FALSE;

if (isset($_POST["username"]) && isset($_POST["pwd"])) {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $password_hash = $AccessManager->encryptPassword($pwd);
    $auth_response = $AccessManager->isUserCredentialsValid($username, $password_hash);
}

//if a verification code is provide use that insteady of the password
if (isset($_GET["veri_code"])) {
    if (empty($_GET["veri_code"]) || $_GET["veri_code"] == "") {
        print_r('{"success":"false","data":"Failed"}');
        die();
    }
    $auth_response = $AccessManager->isUserCredentialsValid(NULL, NULL, $_GET["veri_code"]);
}

if(is_null($auth_response)){
    die('{"success":"false","data":"Failed"}');
}

if (is_object($auth_response)) {

    $user_access_level = $auth_response["access level"];
    $school = $auth_response["school"];
    $user_num_id = $auth_response["teacher id"];
    $school_details = $AccessManager->getSchoolDetails($school);

    $AccessManager = new AccessManager();
    $AccessManager->startSession($username, $user_access_level, $school, $user_num_id, $school_details);

    //check if a valid session was created and validate the token
    if (AccessManager::isSessionValid() === TRUE) {
        if (isset($_GET["veri_code"])) {
            header("location:../index.php?first_time");
        }
        die('{"success":"true","data":"' . $_SESSION["user"]["access_level"]["home"] . '"}');

    } elseif ($user_access_level == 0) {
        die('{"success":"AccessRevoked"}');
    } else {
        die('{"success":"false","data":"Failed"}');
    }
}
?>
