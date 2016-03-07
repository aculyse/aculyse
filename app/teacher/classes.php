<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";

@session_start();

if (AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
    die();
}

//grant immutable subject data
$UserIdentifier = new UserIdentifier();
$subjects = $UserIdentifier->lecturerSubjects();

HTML::header("Aculyse | Classes");
?>

<!--title-->
<section class='class-section' id="classes">
    <div class="col-lg-12">
        <h2 class="text-danger lighter">My Classes</h2>
        <h5>View the classes you teach and the students as well.</h5>
    </div>
    <!--content-->
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body transparent">
                <?php
                $UserIdentifier = new UserIdentifier();
                $ClassManager = new ClassManager();

                //dd($ClassManager->testORM());

                $teacher_subjects = $ClassManager->getTeacherSubject($_SESSION['user']['user_num_id']);

                $tr_classes = $UserIdentifier->getTeacherClasses();


                $class_list_ui = '<div class="listgroup pointer" id="subject-tags">';

                for ($i = 0; $i <= sizeof($teacher_subjects) - 1; $i++) {
                    $subject_name = htmlspecialchars($teacher_subjects[$i]["subject_info"]["title"]);
                    $subject_id = htmlspecialchars($teacher_subjects[$i]["subject"]);
                    $class_id = $teacher_subjects[$i]["class"];
                    $class_details = $ClassManager->getClassDetails($class_id);


                    if (is_array($class_details)) {
                        $class_name = $class_details[0]["class_name"];
                    } else {
                        $class_name = "Unknown class";
                    }
                    $class_list_ui .= "<div class='ui image label tr-subs-label class-widget col-lg-4' id='class-$i' title='Click to get streams for this class' onclick='getClassStreams($class_id,$i);'>";
                    $class_list_ui .= ' <h5 class="bold"><span>' . $subject_name . '</span></h5> ';
                    $class_list_ui .= '<span class="blue">' . $class_name . '</span> ';
                    $class_list_ui .= "<input type='hidden' id='input-class-id' value='$class_id'/>";
                    $class_list_ui .= "<input type='hidden' id='subject-class-id' value='$subject_id'/>";
                    $class_list_ui .= '</div>';
                }
                $class_list_ui .= '</div>';
                echo $class_list_ui;
                ?>
            </div>
        </div>
    </div>
</section>

<!--streams of a class-->
<section class='class-section nope' id="streams">
    <div class="col-lg-12">
        <h1 class="text-danger bold">Streams</h1>
        <h5>View all the subclasses and students</h5>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body transparent" id="streams-list">

            </div>
        </div>
    </div>
</section>

<!--list of students -->
<section class='class-section nope' id="students">
    <div class="col-lg-12">
        <h1 class="text-danger bold">Students</h1>
        <h5>Here are the students in this class</h5>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body transparent" id="students-list">

            </div>
        </div>
    </div>
</section>

</div>
</div>
</div>
<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>

</body>
</html>
