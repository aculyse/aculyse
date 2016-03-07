<?php

if(!isset($_POST["description"]) || !isset($_POST["url"])) {
    die("EmptyParameterException") ;
}
require_once '../logic/FeedBackProcessor.php' ;
$description = $_POST["description"] ;
$url = $_POST["url"] ;

$FeedBackProc = new Aculyse\FeedBackProcessor() ;
$response = $FeedBackProc->saveFeedback($description , $url) ;
echo $response ;
