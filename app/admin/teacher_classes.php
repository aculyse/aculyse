<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";

@session_start();
Auth::isAllowed([
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_SINGLE_MODE
]);
HTML::header("Aculyse | Teacher Allocations");


$teacher_id = $_GET["tr_id"];
$school_id = $_SESSION["user"]["school"];

/* getting teacher subjects */
$ClassManager = new ClassManager();
$Subject = new Subject();
$Teacher = new Teacher();
$teacher_subjects = $ClassManager->getTeacherSubject($teacher_id);
$available_subjects = $Subject->getAll();
$classes_available = $ClassManager->getClassesOfferedAtSchool();
$teacher_info = $Teacher->get($teacher_id);
?>

<div class="col-lg-12">
    <h3 class="text-danger lighter">Teacher Class Allocations</h3>
    <h5>Classes and subjects the teacher has access to</h5>
</div>
<div class="col-lg-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Teacher Information
        </div>

        <div class="panel-body">
            <table id='student-list-table' class='base-table'>

                <div class='centered' id="avatar-mid">
                    <img src="../avatars/default.png"/>
                </div>
                <tr><td class='text-bold'>FULLNAME</td><td class='blue'><?php echo $teacher_info->fullname ?></td></tr>
                <tr><td class='text-bold'>EMAIL</td><td class='blue'><?php echo $teacher_info->email ?></td></tr>
                <tr><td class='text-bold'>SEX</td><td class='blue'><?php echo $teacher_info->sex ?></td></tr>

                <tr><td class='text-bold'>STATUS</td><td class='blue'><?php echo $teacher_info->status ?></td></tr>
            </table>
        </div>

    </div>
</div>
<div class="col-lg-8">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Allocations
        </div>
        <div class="panel-body">

            <div class="ui horizontal divider">ADD NEW</div>

            <center>
                <button onclick='toogleAllocBox();' class='power-circle' title='add new subject and class'><span class='typcn typcn-plus'></span></button>
            </center>

            <div id='sub-input-box' class='nope'>
                <div class="input-box col-lg-6 float-none">
                    <label class="labels">Subject</label>
                    <select  class="input selector selecter_1" required="" id="subject-alloc">
                        <?php
                        foreach ($available_subjects as $sub) {
                            $subject_title = htmlspecialchars($sub["title"]);
                            $subjects_id = htmlspecialchars($sub["id"]);
                            echo "<option value='$subjects_id'>$subject_title</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-box col-lg-6 float-none">
                    <label class="labels">Class name</label>
                    <select  class="input selector selecter_1" required="" id="class-alloc">
                        <?php
                        for ($i = 0; $i <= sizeof($classes_available); $i++) {
                            $class_title = htmlspecialchars($classes_available[$i]["class_name"]);
                            $class_id = htmlspecialchars($classes_available[$i]["class_id"]);
                            echo "<option value='$class_id'>$class_title</option>";
                        }
                        echo '</select>';
                        echo '</div>';

                        echo '<div class="panel-heading">';
                        echo '<button class="btn btn-action btn-md margin" onclick="ClassAllocator.saveEntries(' . $teacher_id . ');"><strong>Save Changes</strong></button>';
                        echo '<button class="btn btn-default btn-md" onclick="toogleAllocBox();"><strong>Cancel</strong></button>';
                        echo ' </div></div>';

                        echo '<div class="ui horizontal divider">CLASSES TAUGHT</div>';

                        if ($teacher_subjects == FALSE) {
                            die('<div class="cool-box">
            <h4 class="text-muted text-center">No subject found</h4>
        </div>');
                        }

                        echo '<div class="list-group" id="subject-tags">';

                        foreach ($teacher_subjects as $tr) {

                            $allocation_id = $tr["id"];
                            echo"'<div class='ui image label tr-subs-label' id='allocation-$allocation_id''>";
                            echo '<h6 class="bold"><span>' . strtoupper($tr->subject_info['title']) . '</span></h6>';
                            echo '<h6 class="blue">' . strtoupper($tr->class_info["class_name"]) . '</h6>';
                            // echo "<button class='btn btn-xs btn-default margin'>edit</button>" ;
                            echo "<button class='btn btn-xs btn-danger margin' onclick='ClassAllocator.removeAllocation($allocation_id)';>remove</button>";
                            echo '</div>';
                        }
                        echo '</div>';
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>

<script src="../ajax/allocator.js"></script>
<script>
                    $(function () {
                        $(".selecter_1").selecter();

                    });

                    function toogleAllocBox() {
                        $("#sub-input-box,.power-circle").slideToggle(200);
                    }


</script>

</body>
</html>
