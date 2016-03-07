<?php

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";
@session_start();
if (Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php");
    die();
}

$allowed_levels = array(
    Aculyse\AccessLevels::LEVEL_ADMIN_ONLY,
    Aculyse\AccessLevels::LEVEL_SINGLE_MODE
);
$access_level_num = $_SESSION["user"]["access_level"]["right"];
if (!in_array($access_level_num, $allowed_levels)) {
    die("AcessLevelViolationException");
}

//change access level

if (!isset($_POST["action"])) {
    die("EmptyActionException");
}

$action = $_POST["action"];
$User = new Aculyse\Users();

switch ($action) {
    /**
     * change user access level
     */
    case "cal":
        if (isset($_POST["user"]) && isset($_POST["new_level"])) {
            $account = $_POST["user"];
            $new_access_level = $_POST["new_level"];
        } else {
            die("EmptyParametersException");
        }
        $response = $User->updateAccessLevel($account, $new_access_level);
        print_r($response);
        break;


    /**
     * reset user password
     */
    case "rp":
        if (isset($_POST["user"])) {
            $account = $_POST["user"];
        } else {
            die("EmptyParametersException");
        }
        $response = $User->resetPassword($account);
        print_r($response);
        break;

    /**
     * remove user account
     */
    case "remove":
        if (isset($_POST["user"])) {
            $account = $_POST["user"];
        } else {
            die("EmptyParametersException");
        }
        $response = $User->deleteAccount($account);
        print_r($response);
        break;

    /**
     * check username availability
     */
    case "check":
        if (isset($_POST["user"])) {
            $username = $_POST["user"];
        } else {
            die("EmptyParametersException");
        }
        if ($User->isAccountTaken($username) !== ACCOUNT_AVAILABLE) {
            return ACCOUNT_TAKEN;
        } else {
            return ACCOUNT_AVAILABLE;
        }
        break;

    case "change_subject":
        if (isset($_POST["user"]) || isset($_POST["subject1"]) || isset($_POST["subject2"])) {
            $user = $_POST["user"];
            $subject1 = $_POST["subject1"];
            $subject2 = $_POST["subject2"];
        } else {
            die("EmptyParametersException");
        }
        $response = $User->changeSubjects($user, $subject1, $subject2);
        print_r($response);
        break;


    default :
        break;
}
