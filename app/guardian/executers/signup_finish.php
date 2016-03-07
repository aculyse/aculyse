<?php
/**
* Create guardian account
*/
require_once "../../../vendor/autoload.php";
use Aculyse\Guardian\Auth\Auth;
use Aculyse\Guardian\Auth\Session;

@session_start();

$password = $_POST['password'];
$fullname = $_POST['name'];

$email = $_SESSION['aculyse_signup'][0]['email'];
$phone = $_SESSION['aculyse_signup'][0]['phone'];

$guardian = new Auth();

if ($guardian->createAccount($email,$phone,$fullname,$password)) {
  header("location:../");
  exit;
}
header("location:../?failed");
exit;
