<?php
/**
 * Switch session for a new school
 */
namespace Aculyse\Guardian;
use Aculyse\Guardian\Auth\Session;

require_once "../../../vendor/autoload.php";
@session_start();

if(isset($_POST["school"]) && isset($_POST["student"])){
    $school=$_POST["school"];
    $student = $_POST["student"];
}


Session::setSchool($school,$student);

//redirect to the report book
header("location:../../teacher/report_book.php?student=$student");

//just incase we have a proplem with the header, use JS

echo "<script>location.href='../../teacher/report_book.php?student=$student'</script>";
