<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once '../../vendor/autoload.php';

$access_level_num = ActiveSession::accessLevel();

Auth::isAllowed([
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_READ_STUDENTS_ONLY,
    AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);

//include the header
HTML::header("Aculyse | Class Viewer");

//get class details
$Student = new Students();
$ClassMgr = new ClassManager();
$class_details = $ClassMgr->getClassDetails($_GET["id"]);
if (is_array($class_details)) {
    $class_name = $class_details[0]["class_name"];
    $class_id = $class_details[0]["class_id"];
    $class_description = $class_details[0]["desc"];
    $class_level = $class_details[0]["level"];
    $classes_of = $ClassMgr->getClassDetails($_GET["id"], TRUE);
    if (is_array($classes_of)) {
        rsort($classes_of);
    }
}


$dataset = FALSE;
if (isset($_GET["id"])) {
    $year = $classes_of[0]["class of"];
    if (isset($_GET["year"])) {
        $year = $_GET["year"];
    }
    $class_and_year = array("year" => $year, "class" => $_GET["id"]);
    $dataset = $Student->getStudents(NULL, NULL, NULL, NULL, NULL, $class_and_year);
}
?>

<span class='hide nope hiden' id="access-pixel" data-access="<?php echo $access_level_num ?>"></span>

<div class="col-lg-12  no-print">
    <h2 class="text-danger lighter">Welcome to class -<span class="bold"><?php echo strtoupper($class_name) ?></span></h2>
    <h5>The following classes are available please choose the list of students below.</h5>
</div>
<?php
if (!is_array($class_details) || (!is_array($classes_of))) {
    include_once INCLUDES_FOLDER ."/no_class_found.php";
    die("");
}
?>
<div class="col-lg-3">
    <div class="bs-component">
        <div class="list-group">

            <?php
            foreach ($classes_of as $key => $value) {
                $class_of = $value["class of"];
                $ui = "";
                if ($class_of == $year) {
                    $ui = "active";
                }
                echo "<a href='?id=$class_id&year=$class_of' class='list-group-item text-bold $ui'>$class_of</a>";
            }
            ?>
        </div>
    </div>
</div>
<div class="col-lg-9">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?php echo "$class_name class of $year"; ?>
        </div>
        <div class="panel-body">
            <?php
            if (!$dataset == FALSE) {
                echo "<table id='student-list-table' class='base-table'>";
                echo "<thead>";
                echo "<th></th>";
                echo "<th>Student ID</th>";
                echo "<th>Fullname</th>";
                /*
                  echo "<th>MIDDLENAME</th>" ;
                  echo "<th>SURNAME</th>" ; */
                echo "<th>Sex</th>";
                echo "<th>Status</th>";
                echo "<th></th>";
                echo "</thead>";

                foreach ($dataset as $key => $value) {
                    $id = strtoupper(htmlspecialchars($value["id"]));
                    $student_id = strtoupper(htmlspecialchars($value["student id"]));
                    $firstname = strtoupper(htmlspecialchars($value["firstname"]));
                    $surname = strtoupper(htmlspecialchars($value["surname"]));
                    $middlename = strtoupper(htmlspecialchars($value["middle name"]));
                    $sex = strtoupper(htmlspecialchars($value["sex"]));
                    $class_of = strtoupper(htmlspecialchars($value["class of"]));
                    $class_id = $value["class_name"];
                    $avatar = $value["avatar"];
                    $class_name = strtoupper($ClassMgr->getClassDetails($class_id)[0]["class_name"]);
                    $status = strtoupper(htmlspecialchars($value["status"]));

                    $id_year = substr($student_id, 0, 4);
                    $id_count = substr($student_id, 3 - 6);
                    $element_id = "account_$id_year$id_count";

                    if (!empty($middlename)) {
                        $fullname = $firstname . " " . $middlename . " " . $surname;
                    } else {
                        $fullname = $firstname . " " . $surname;
                    }


                    echo "<tr id='student-id-$id'>";
                    echo "<td><img src='$avatar' width=30 height=30 class='img-rounded'/></td>";
                    echo "<td class='pointer' title='view full profile of $firstname $surname, student id  $student_id'><a href='student_profile?id=$student_id'><b>$student_id</b></a></td>";
                    echo "<td>$fullname</td>";
                    /* echo "<td>$middlename</td>" ;
                      echo "<td>$surname</td>" ; */
                    echo "<td><strong>$sex</strong></td>";



                    if ($status == "ACTIVATED") {

                        echo "<td><span class='status-badge badge badge-success' onclick='toggleStudentStatus($id)' title='activate or deactivate account'>ACTIVE</span></td>";
                    } else if ($status == "DEACTIVATED") {
                        echo "<td><span class='status-badge badge badge-danger' onclick='toggleStudentStatus($id)' title='activate or deactivate account'>DEACTIVATED</span></td>";
                    } else {

                        echo "<td><span class='status-badge badge badge-normal'>" . $status . "</span></td>";
                    }


                    echo "<td>
                                  <a href='student_profile.php?id=$student_id' class='btn btn-default btn-xs'>view profile</button>
                                  </td>";

                echo '</tr>';
            }
            echo "</table>";
        }
        ?>
        </div>

    </div>

</div>
</div>
</div>

<?php
require_once INCLUDES_FOLDER . '/delete_dialog.php';
include_once INCLUDES_FOLDER . '/footer.php';
?>

</body>
</html>
