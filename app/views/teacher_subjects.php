<?php

require "../logic/ClassManager.php" ;
require "../logic/Subject.php" ;
require_once "../logic/AccessManager.php" ;



/********************************************
  AUTHENTICATION
*********************************************/
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:index.php") ;
    die() ;
}

$allowed_levels = array(6,Aculyse\AccessLevels::LEVEL_SINGLE_MODE) ;
$access_level_num = $_SESSION["user"]["access_level"]["right"] ;
if(!in_array($access_level_num , $allowed_levels)) {
    header("location:index.php") ;
    die() ;
}

if(!isset($_POST["tr_id"])) {
    die("TeacherIdNotSpecifiedException") ;
}

$teacher_id = $_POST["tr_id"] ;
$school_id = $_SESSION["user"]["school"] ;

/* getting teacher subjects */
$ClassManager = new \Aculyse\ClassManager() ;
$Subject = new \Aculyse\Subject();
$teacher_subjects = $ClassManager->getTeacherSubject($teacher_id) ;
$available_subjects = $Subject->getAll() ;
$classes_available = $ClassManager->getClassesOfferedAtSchool() ;

echo '<div class="ui horizontal divider">ADD NEW</div>' ;

echo "<button onclick='toogleAllocBox();' class='power-circle' title='add new subject and class'><span class='typcn typcn-plus'></span></button>" ;

echo "<div id='sub-input-box' class='nope'>" ;
echo '<div class="input-box col-lg-6 float-none">' ;
echo '<label class="labels">Subject</label>' ;
echo '<select  class="input selector selecter_1" required="" id="subject-alloc">' ;

foreach ($available_subjects as $sub) {
    $subject_title = htmlspecialchars($sub["title"]) ;
    $subjects_id = htmlspecialchars($sub["id"]) ;
    echo "<option value='$subjects_id'>$subject_title</option>" ;
}
echo '</select>' ;
echo ' </div>' ;

echo '<div class="input-box col-lg-6 float-none">' ;
echo '<label class="labels">Class name</label>' ;
echo '<select  class="input selector selefcter_1" required="" id="class-alloc">' ;

for($i = 0 ; $i <= sizeof($classes_available) ; $i++) {
    $class_title = htmlspecialchars($classes_available[$i]["class_name"]) ;
    $class_id = htmlspecialchars($classes_available[$i]["class_id"]) ;
    echo "<option value='$class_id'>$class_title</option>" ;
}
echo '</select>' ;
echo '</div>' ;

echo '<div class="panel-heading">' ;
echo '<button class="btn btn-action btn-md margin" onclick="ClassAllocator.saveEntries(' . $teacher_id . ');"><strong>Save Changes</strong></button>' ;
echo '<button class="btn btn-default btn-md" onclick="toogleAllocBox();"><strong>Cancel</strong></button>' ;
echo ' </div></div>' ;

echo '<div class="ui horizontal divider">CLASSES TAUGHT</div>' ;

if($teacher_subjects == FALSE) {
    die('<div class="cool-box">
            <h4 class="text-muted text-center">No subject found</h4>
        </div>') ;
}

echo '<div class="list-group" id="subject-tags">' ;

for($i = 0 ; $i <= sizeof($teacher_subjects) - 1 ; $i++) {

    $allocation_id = $teacher_subjects[$i]["id"] ;
    $subject_name = htmlspecialchars($teacher_subjects[$i]["title"]) ;
    $subject_id = htmlspecialchars($teacher_subjects[$i]["subject"]) ;
    $class_id = $teacher_subjects[$i]["class"] ;

    $class_details = $ClassManager->getClassDetails($class_id) ;

    if(is_array($class_details)) {
        $class_name = $class_details[0]["class_name"] ;
    }
    else {
        $class_name = "Unknown class" ;
    }
    echo"'<div class='ui image label tr-subs-label' id='allocation-$allocation_id''>" ;
    echo '<h6 class="bold"><span>' . $subject_name . '</span></h6>' ;
    echo '<h6 class="blue">' . strtoupper($class_name) . '</h6>' ;
    // echo "<button class='btn btn-xs btn-default margin'>edit</button>" ;
    echo "<button class='btn btn-xs btn-danger margin' onclick='ClassAllocator.removeAllocation($allocation_id)';>remove</button>" ;
    echo '</div>' ;
}
echo '</div>' ;
