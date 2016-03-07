<?php
namespace Aculyse;
use Aculyse\Guardian\Auth\Auth;
require_once "../../../vendor/autoload.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $Auth = new Auth();

    if($status = $Auth->login($email, $password)){
        header("location:../dash.php");
        die();
    }
    header("location:../index.php");
}
?>