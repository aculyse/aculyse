<?php

require_once '../logic/Config.php' ;
require_once "../logic/AccessManager.php" ;
require_once '../logic/Users.php' ;

if(!isset($_POST["action"])) {
    die("EmptyActionException") ;
}

$action = $_POST["action"] ;
$User = new Aculyse\Users() ;

switch($action) {
    /**
     * check username availability
     */
    case "check":
        if(isset($_POST["user"])) {
            $username = $_POST["user"] ;
        }
        else {
            die("EmptyParametersException") ;
        }
        if($User->isAccountTaken($username) !== ACCOUNT_AVAILABLE) {
            echo ACCOUNT_TAKEN ;
        }
        else {
            echo ACCOUNT_AVAILABLE ;
        }
        break ;

    default :

        break ;
}
