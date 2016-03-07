<?php

/**
 * search through students
 */
require_once '../logic/students.php' ;

if(!isset($_POST['q'])) {
    die('ParameterNullException') ;
}
$query = $_POST['q'] ;

$Students = new Aculyse\Students() ;
$dataset = $Students->getStudents($start_from = NULL , 'LIST' , $user_account = NULL , $search = $query , $sql = NULL) ;

//check for result set
if($dataset == FALSE) {
    die("No result Found") ;
}

//check if result is an array
if(!is_array($dataset)) {
    die("DataFormatException") ;
}

echo "<div class='list-group'>" ;

for($i = 0 ; $i <= sizeof($dataset) - 1 ; $i++) {
    $student_id = htmlspecialchars($dataset[$i]["student id"]) ;
    $fullname = htmlspecialchars(strtoupper($dataset[$i]["firstname"] . " " . $dataset[$i]["middle name"] . " " . $dataset[$i]["surname"])) ;
    echo "<a class = 'list-group-item' onclick='addToSearchField(\"$student_id\");'>" ;
    echo "<h4 class = 'list-group-item-heading text-danger'>$student_id</h4>" ;
    echo "<p class = 'list-group-item-text'>$fullname</p>" ;
    echo "</a>" ;

    //exit if loop reached 30
    if($i == 30) {
        return ;
    }
}
echo "</div>" ;

