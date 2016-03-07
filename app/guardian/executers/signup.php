<?php

require_once "../../../vendor/autoload.php";
use Aculyse\Guardian\Auth\Auth;
use Aculyse\Guardian\Auth\Session;
/**
 * Create guardian account
 */
$stage = $_POST["stage"];

if($stage=1){
//    header("location:../invitation.php?finish");
}


$contact = $_POST['username'];
$code = $_POST['invitation_code'];

$auth = new Auth();
$auth_response = $auth->isInvitationValid($contact,$code);

if ($auth_response->count()==1) {
   Session::startSignupSession($auth_response);
};

if (Session::isSignupSessionValid()) {
  header("location:../invitation.php?finish");
  exit;
} else {
  header("location:../invitation.php");
  exit;
}
