<?php

require_once "../logic/ProfileMetadata.php" ;

$ProfileMetadata = new \Aculyse\ProfileMetadata() ;

$profile_id = $_POST["profile_id"] ;
$test_num = $_POST["test_num"] ;
$description = $_POST["desc"] ;

$data = array("profile_id" => 2 , "test_num" => 3 , "name" => 1 , "desc" => "This test is just a test") ;

$response = $ProfileMetadata->add($data) ;
print_r($response) ;
