<?php

/* * ******************************************
  AUTHENTICATION
 * ******************************************* */
require_once "../logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(1,Aculyse\AccessLevels::LEVEL_SINGLE_MODE,Aculyse\AccessLevels::LEVEL_ADMIN_ONLY) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}

/* * ************************************************ */
require_once '../logic/StudentWriter.php' ;


if(isset($_POST["account_id"])) {

    $account_id = $_POST['account_id'] ;

    $StudentAccount = new Aculyse\StudentsWriter() ;

    $response = $StudentAccount->changeAccountStatus($account_id) ;

    switch($response) {
        case TRUE:
            print_r("success") ;
            break ;

        case FALSE:
            print_r("NoUpdate") ;
            break ;

        default :
            print_r($response) ;
            break ;
    }
}
else {
    print_r("NoParametersException") ;
}
?>
