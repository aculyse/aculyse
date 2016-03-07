<?php

//determine environment to decide whether to show errors or not
$environment = "development" ;
/*
switch($environment) {
    case 'development':
        error_reporting("E_ALL") ;
        break ;

    case 'production':
        error_reporting("E_ALL & ~E_DEPRECATED & ~E_STRICT") ;
        break ;
    //for security reasons if no environment is set we assume it is production environment
    default:
        error_reporting("E_ALL & ~E_DEPRECATED & ~E_STRICT") ;
        break ;
}
*/
