<?php

require_once "../logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php") ;
    die() ;
}


$allowed_levels = array(
    Aculyse\AccessLevels::LEVEL_WRITE_STUDENTS ,
    Aculyse\AccessLevels::LEVEL_ADMIN_ONLY,
    Aculyse\AccessLevels::LEVEL_SINGLE_MODE
        ) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    die("AcessLevelViolationException") ;
}

//start loading files here
require_once '../logic/StudentWriter.php' ;

//start removing the account
if(isset($_GET['account_to_remove'])) {
    $account_to_remove = $_GET['account_to_remove'] ;
    $Student = new \Aculyse\StudentsWriter() ;
    $result = $Student->deleteStudent($account_to_remove) ;
    if($result == TRUE) {
        die("0") ;
    }
    else {
        die("1") ;
    }
}
else {
    die("account not specified") ;
}
