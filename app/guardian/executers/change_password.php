<?php

namespace Aculyse\Guardian;

use Aculyse\Helpers\Auth\ActiveSession;
use Aculyse\Guardian\Auth\Auth;
use Aculyse\Validate;

require_once "../../../vendor/autoload.php";

if (!isset($_POST["new_password"]) || !isset($_POST["confirm_new_password"])) {
    header("location:../change_password?code=100");
    die();
}

$new_password = $_POST["new_password"];
$confirm_new_password = $_POST["confirm_new_password"];

if (!Validate::validatePasswordMatch($new_password, $confirm_new_password)) {
    header("location:../change_password?code=101");
    die();
}

if (!Validate::validatePasswordCriteria($new_password)) {
    header("location:../change_password?code=102");
    die();
}

$Auth = new Auth();
if($Auth->changePassword(ActiveSession::id(),$new_password)){
    header("location:../change_password?code=103");
    die();
}
header("location:../change_password?code=104");
die();