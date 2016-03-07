<?php

/* * ******************************************
  AUTHENTICATION
 * ******************************************* */
require_once "../logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:index.php") ;
    die() ;
}

//session is valid lets check the access level on level 3,4 or 5 is allowed, from more details check AccessLevels class
$allowed_levels = array(
    Aculyse\AccessLevels::LEVEL_WRITE_STUDENTS ,
    Aculyse\AccessLevels::LEVEL_READ_STUDENTS_ONLY ,
    Aculyse\AccessLevels::LEVEL_WRITE_ANALYTICS ,
    Aculyse\AccessLevels::LEVEL_UNIVERSAL_READ_ONLY ,
    Aculyse\AccessLevels::LEVEL_ADMIN_ONLY
        ) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    header("location:index.php") ;
    die() ;
}

/* * ************************************************ */
require_once '../logic/students.php' ;
require_once '../logic/ClassManager.php' ;
$Student = new Aculyse\Students() ;
$ClassManager = new Aculyse\ClassManager() ;
//dont forget to sanitize the post
$class_id = $_POST["class_id"] ;
$class_of = $_POST["class_year"] ;

$class_arr = array("class" => $class_id , "year" => $class_of) ;

if(isset($_POST['q'])) {
    $search_term = $_POST['q'] ;
    $dataset = $Student->getStudents($start_from , "LIST" , NULL , $search_term,null,$class_arr) ;
}
else {
    $dataset = $Student->getStudents(NULL , NULL , NULL , NULL , NULL , $class_arr) ;
}
$dataset_len = sizeof($dataset) ;

if(!$dataset == FALSE) {


    echo '<div class="col-md-12">
        <div class="col-md-6 col-lg-offset-3">
                <div class="input-group form-search">
                  <input type="text" class="form-control search-query" placeholder="search here">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" data-type="last">Search</button>
                  </span>
                </div>
              </div></div><br/></br/><br/><br/>' ;

    for($i = 0 ; $i <= $dataset_len - 1 ; $i++) {
        $id = strtoupper(htmlspecialchars($dataset[$i]["id"])) ;
        $student_id = strtoupper(htmlspecialchars($dataset[$i]["student id"])) ;
        $firstname = strtoupper(htmlspecialchars($dataset[$i]["firstname"])) ;
        $surname = strtoupper(htmlspecialchars($dataset[$i]["surname"])) ;
        $middlename = strtoupper(htmlspecialchars($dataset[$i]["middle name"])) ;
        $sex = strtoupper(htmlspecialchars($dataset[$i]["sex"])) ;
        $class_of = strtoupper(htmlspecialchars($dataset[$i]["class of"])) ;
        $class_id = $dataset[$i]["class_name"] ;

    $avatar = htmlspecialchars($dataset[$i]["avatar"]) ;

        $fullname = $firstname . " " . $middlename . " " . $surname ;

        $class_name = strtoupper($ClassManager->getClassDetails($class_id)[0]["class_name"]) ;
        $status = strtoupper(htmlspecialchars($dataset[$i]["status"])) ;

        $id_year = substr($student_id , 0 , 4) ;
        $id_count = substr($student_id , 3 - 6) ;
        $element_id = "account_$id_year$id_count" ;

        echo "<div class = 'col-md-4 col-sm-6 col-xs-12'>" ;
        echo "<div class = 'info-box'>" ;
        echo "<div class = 'info-box-icon'><img src='$avatar' width=76 height=79/></div>" ;
        echo " <div class = 'info-box-content'>" ;
        echo "<span class = 'info-box-text text-info'>$fullname</span>" ;
        echo "<span class = 'info-box-number text-danger'>$student_id</span>" ;
        echo "</div><!--/.info-box-content -->" ;
        echo " </div><!--/.info-box -->" ;
        echo "</div>" ;
    }
}
else {
    if($_POST["search"] == true) {
        require_once "../includes/no_search_result.php" ;
    }
    else {
        require_once "../includes/no_students.php" ;
    }
}
?>