<?php
namespace Aculyse;

require_once '../../vendor/autoload.php';

if(empty($_POST["class_id"])) {
    die('{"status"."emptyParamsException"}') ;
}
$class_id = $_POST["class_id"] ;
$ClassManager = new ClassManager() ;
$response = $ClassManager->getClassDetails($class_id , TRUE) ;
if(is_array($response)) {
    $classes_arr = array() ;
    for($i = 0 ; $i < sizeof($response) ; $i++) {
        array_push($classes_arr , $response[$i]["class of"]) ;
    }
    $response_json = json_encode($classes_arr) ;
    die($response_json) ;
}
else {
    die('{"status":"NoClassesException"}') ;
}