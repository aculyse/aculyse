<?php

namespace Aculyse;

use Aculyse\Guardian\Auth\Session;
use Aculyse\Helpers\Auth\ActiveSession;
use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";
@session_start();
Auth::isAllowed([
        AccessLevels::LEVEL_READ_ANALYTICS_ONLY,
        AccessLevels::LEVEL_WRITE_ANALYTICS,
        AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
        AccessLevels::LEVEL_SINGLE_MODE,
        AccessLevels::LEVEL_GUARDIAN
    ]
);
HTML::header("Aculyse | Student Report Book");

if (empty($_GET["student"])) {
    include_once INCLUDES_FOLDER . "/no_report_book.php";
    die();
}

//check if its a guardian and that the student is a dependent
if (ActiveSession::isGuardian()) {
    if (ActiveSession::dependent() != $_GET["student"] && ActiveSession::accessLevel() == AccessLevels::LEVEL_GUARDIAN) {
        include_once INCLUDES_FOLDER . "/access_denied.php";
        die();
    }
}


?>
<div class="col-lg-12 no-print">

    <h2 class="text-danger lighter">Report Book</h2>
    <h5>Get all reports of a student in one collection !</h5>

</div>
<div class="col-lg-12  only-print">
    <div class="panel-body">
        <h1 class="centered logo">acu<span class='light'>lyse</span></h1>
        <h4 class="centered"><?php echo $_SESSION["user"]["school info"]["name"] ?></h4>
        <h4 class="text-danger bold centered">Full Student Perfomance Assessment Report (FSPAR)</h4>
        <h5>generated <?php echo date("d M Y H:m:s") ?></h5>
    </div>
</div>

<?php
//get student profile raw data
$StudentReport = new StudentReport();
$Profiler = new Profiler();
$Student = new Students();
$ClassManager = new ClassManager();


$student_id = $_GET["student"];
$grading = NULL;
if (isset($_GET["grading"])) {
    $grading = $_GET["grading"];
}


$student_data = $Student->getStudents(NULL, "SINGLE", $student_id);
$firstname = strtoupper(htmlspecialchars($student_data[0]["firstname"]));
$middle_name = strtoupper(htmlspecialchars($student_data[0]["middle name"]));
$surname = strtoupper(htmlspecialchars($student_data[0]["surname"]));
$sex = strtoupper(htmlspecialchars($student_data[0]["sex"]));
$class_of = strtoupper(htmlspecialchars($student_data[0]["class of"]));

$avatar = $student_data[0]["avatar"];
if ($avatar == "") {
    $avatar = "../avatars/default.png";
}
$status = $student_data[0]["status"];
$class_id = strtoupper(htmlspecialchars($student_data[0]["class_name"]));
$class_name = strtoupper($ClassManager->getClassDetails($class_id)[0]["class_name"]);
?>
<div class="col-lg-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Student Information
        </div>

        <div class="panel-body">
            <table id='student-list-table' class='base-table'>
                <?php
                if ($status == "deleted") {
                    echo "<span class='badge badge-info'>Deleted student record</span>";
                }
                ?>
                <div class='centered' id="avatar-mid">
                    <img src="<?php echo $avatar ?>"/>
                </div>
                <tr>
                    <td class='text-bold'>STUDENT ID</td>
                    <td class='blue xl bold'><?php echo $student_id ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>FULLNAME</td>
                    <td class='blue'><?php echo $firstname . " " . $middle_name . " " . $surname ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>SEX</td>
                    <td class='blue'><?php echo $sex ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>CLASS OF</td>
                    <td class='blue'><?php echo $class_of ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>CURRENT CLASS</td>
                    <td class='blue'><?php echo $class_name ?></td>
                </tr>
            </table>
        </div>

    </div>
</div>
<div class="col-lg-8">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyph-icon flaticon-note24">Report Booklet</span>


            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default btn-sm" onclick=print();>Print Report</button>

            </div>
        </div>

        <div class="panel-body">
            <div class="flot-chart">
                <div class="flot-chart-content">


                    <?php
                    //  $dataset = $Profiler->report($student_id)->has_marks->toArray();
                    $dataset = $StudentReport->getStudentMarks($student_id, NULL, NULL, TRUE);

                    //check if there is a student with the id
                    if (!$dataset) {
                        require_once INCLUDES_FOLDER . '/no_report_book.php';

                    } else {

                        $table_header = "<table id='student-perfomance-table' class='base-table'>";
                        $table_header .= "<thead><th>Year</th>";
                        $table_header .= "<th>Term</th>";
                        $table_header .= "<th>Subject</th>";
                        $table_header .= "<th>Mark (%)</th>";
                        $table_header .= "<th>Grade</th></thead>";


                        $num_of_passes = 0;
                        $num_of_fails = 0;
                        $grand_total_mark = 0;
                        $best_mark = 0;
                        $lowest_mark = 0;
                        $student_marks_arr = array();
                        $full_report_arr = array();

                        for ($i = 0; $i < sizeof($dataset); $i++) {

                            $profile_id = $dataset[$i]["profile id"];
                            // $profile_info = $Profiler->getProfileStatus($profile_id);
                            //dd($profile_id);
                            $year = $dataset[$i]["year"];
                            $term = $dataset[$i]["term"];
                            $mark = $dataset[$i]["mark"];
                            $subject_id = $dataset[$i]["subject"];
                            $grade = $dataset[$i]["grade"];
                            $subject = $Profiler->getSubjectName($subject_id)["title"];

                            if ($i >= 1) {
                                $previous_year = strtoupper(htmlspecialchars($dataset[$i - 1]["year"]));
                                $previous_term = $dataset[$i - 1]["term"];
                                if ($previous_term != $term) {
                                    //echo "<div class ='ui horizontal divider text-info '>year $previous_year: term $previous_term</div>" ;
                                    echo "<tr>";
                                    echo "</tr>";
                                    echo $table_header;
                                }
                            } else {

                                echo $table_header;
                            }

                            echo "<tr>";
                            echo '<td class="text-info bold col-lg-1">' . $year . '</td>';
                            echo '<td class="col-lg-1">' . $term . '</td>';
                            echo "<td class='bold col-lg-6'><a href='single.php?pid=$profile_id&subject=$subject&cn=$student_id'>$subject</a></td>";
                            if ($mark < 50) {
                                echo '<td class="fail col-lg-2">' . $mark . '</td>';
                            } else {
                                echo '<td class="pass col-lg-2">' . $mark . '</td>';
                            }
                            echo '<td class="bold text-info col-lg-1">' . $grade . '</td>';


                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>


</div>

</div>

<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>

</body>
</html>
