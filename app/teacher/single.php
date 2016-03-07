<?php

namespace Aculyse;

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

HTML::header("Aculyse | Individual Student Perfomance (ISP)");
?>

<div class="col-lg-12 no-print">

    <h2 class="text-danger lighter">Individual Subject Perfomance</h2>
    <h5>**Drill through past perfomance and see neccessary changes required in future</h5>

</div>
<div class="col-lg-12  only-print">
    <div class="panel-body">
        <h1 class="centered logo">acu<span class='light'>lyse</span></h1>
        <h4 class="centered"><?php echo $_SESSION["user"]["school info"]["name"] ?></h4>
        <h4 class="text-danger bold centered">Subject Perfomance Assessment Report (SPAR)</h4>
        <h5>generated <?php echo date("d M Y H:m:s") ?></h5>
    </div>
</div>

<?php
$ClassManager = new ClassManager();
//check if variables are set
if (isset($_GET["cn"]) && isset($_GET["subject"]) && isset($_GET["pid"])) {
    $student_id = $_GET["cn"];
    $subject_param = $_GET["subject"];
    $profile_id = $_GET["pid"];
} else {
    require_once './includes/warning.php';
    die();
}

//check if its a guardian and that the student is a dependent
if(ActiveSession::isGuardian()) {
    if (ActiveSession::dependent() != $student_id && ActiveSession::accessLevel() == AccessLevels::LEVEL_GUARDIAN) {
        include_once INCLUDES_FOLDER . "/access_denied.php";
        die();
    }
}

//get info about profile, we are only interested in the class and subject ids
//so just take the first record only, thats why we are not looping
$Profiler = new Profiler();
$profile_data = $Profiler->getProfileStatus($profile_id);


$subject_id = strtoupper(htmlspecialchars($profile_data["subject"]));
$subject = $Profiler->getSubjectName($subject_id)["title"];
$year = strtoupper(htmlspecialchars($profile_data["year"]));
$term = strtoupper(htmlspecialchars($profile_data["term"]));
$profile_class_of = strtoupper(htmlspecialchars($profile_data["class of"]));
$profiles_arr = array("subject" => $subject_id, "class of" => $profile_class_of);

$profiles_having_student = $Profiler->getSubjectProfiles($subject_id, $profile_class_of)->toArray();


//get student profile raw data
$StudentReport = new StudentReport();

$dataset = array();
for ($i = 0; $i < sizeof($profiles_having_student); $i++) {
    $profile_marks = $StudentReport->getStudentMarks($student_id, $subject_param, $profiles_having_student[$i]["id"]);
    array_push($dataset, $profile_marks);
}
//  print_r(sizeof($profiles_having_student));
if (sizeof($dataset) == 0 || !is_array($dataset) || $profile_data == FALSE) {
    require_once INCLUDES_FOLDER . '/warning.php';
    die();
}

$dataset_json = json_encode($dataset);
$profile_data_json = json_encode($profiles_having_student);
//$student_id = strtoupper(htmlspecialchars($dataset[0][0]["student id"])) ;
//get information about the student
$Student = new Students();
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
<div class="col-lg-12 padding no-print">

    <a href="report_book?student=<?php echo $student_id ?>" class="btn btn-lg btn-danger btn-block">Go to student
        ReportBook</a>

</div>
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
                    <td class='text-danger bold'><?php echo $student_id ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>SUBJECT</td>
                    <td class='text-danger'><?php echo $subject ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>FULLNAME</td>
                    <td class='text-danger'><?php echo $firstname . " " . $middle_name . " " . $surname ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>SEX</td>
                    <td class='text-danger'><?php echo $sex ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>CLASS OF</td>
                    <td class='text-danger'><?php echo $class_of ?></td>
                </tr>
                <tr>
                    <td class='text-bold'>CURRENT CLASS</td>
                    <td class='text-danger bold'><?php echo $class_name ?></td>
                </tr>

            </table>


        </div>

    </div>
</div>
<div class="col-lg-8">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyph-icon flaticon-note24"></span>
            Detailed Student perfomance
            <div class="btn-group float-right">
                <button type="button" class="btn btn-default btn-sm">Export</button>
                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a download="Individual Perfomance for <?php echo $student_id ?>.xls" href="#"
                           onclick="return ExcellentExport.excel(this, 'student-perfomance-table', 'Student marks');">Export
                            to Excel</a>
                    </li>
                    <li><a download="Individual Perfomance for <?php echo $student_id ?>.cvs" href="#"
                           onclick="return ExcellentExport.cvs(this, 'grade-summary-table');">Export to CVS</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="flot-chart">
                <div class="flot-chart-content">

                    <?php
                    echo "<table id='student-perfomance-table' class='base-table'>";
                    echo "<th>Year</th>";
                    echo "<th>Term</th>";
                    echo "<th>Subject</th>";
                    echo "<th>Tests(%)</th>";
                    echo "<th>Exam(%)</th>";
                    echo "<th>Final Mark (%)</th>";


                    $num_of_passes = 0;
                    $num_of_fails = 0;
                    $grand_total_mark = 0;
                    $best_mark = 0;
                    $lowest_mark = 0;
                    $student_marks_arr = array();

                    for ($i = 0; $i < sizeof($dataset); $i++) {

                        $course_work = strtoupper(htmlspecialchars($dataset[$i][0]["weighted course work"]));
                        $exam_mark = strtoupper(htmlspecialchars($dataset[$i][0]["weighted final mark"]));
                        $total_mark = strtoupper(htmlspecialchars($dataset[$i][0]["combined mark"]));

                        if ($i >= 1) {
                            $previous_year = strtoupper(htmlspecialchars($profiles_having_student[$i - 1]["year"]));
                            $current_year = strtoupper(htmlspecialchars($profiles_having_student[$i]["year"]));

                            if ($previous_year != $current_year) {
                                echo "<tr class='xl real-huge'><td></td><td></td><td></td><td>$current_year</td><td></td><td></td></tr>";
                            }
                        }
                        array_push($student_marks_arr, $total_mark);
                        //get stats on number of passes and fails
                        if ($total_mark >= 50) {
                            $num_of_passes += 1;
                        } elseif ($total_mark < 50) {
                            $num_of_fails += 1;
                        }

                        //sum up marks
                        $grand_total_mark += $total_mark;


                        //table rows
                        echo "<tr>";


                        echo '<td>' . $profiles_having_student[$i]["year"] . '</td>';
                        echo '<td>' . $profiles_having_student[$i]["term"] . '</td>';
                        echo '<td>' . $subject . '</td>';

                        if ($course_work < 15) {
                            echo '<td class="fail">' . $course_work . '</td>';
                        } else {
                            echo '<td class="pass">' . $course_work . '</td>';
                        }

                        if ($exam_mark < 35) {
                            echo '<td class="fail">' . $exam_mark . '</td>';
                        } else {
                            echo '<td class="pass">' . $exam_mark . '</td>';
                        }

                        if ($total_mark < 50) {
                            echo '<td class="fail">' . $total_mark . '</td>';
                        } else {
                            echo '<td class="pass">' . $total_mark . '</td>';
                        }

                        echo "</tr>";
                    }
                    //get top amd lowest marks
                    sort($student_marks_arr);
                    $best_mark = $student_marks_arr[sizeof($student_marks_arr) - 1];
                    $lowest_mark = $student_marks_arr[0];


                    //calculate avarage mark
                    $total_test = $i;
                    $average_mark = floor($grand_total_mark / $total_test);
                    $pass_rate = ($num_of_passes / $total_test) * 100;

                    echo "</table>";
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<span id="plot-data" data-plot-points='<?php echo $dataset_json ?>'
      data-profile-data='<?php echo $profile_data_json ?>'></span>

<!--quick stats-->
<div class="col-lg-12 no-print">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyph-icon flaticon-ascendant6"></span>
            Student Quick Statistics
        </div>

        <div class="panel-body">

            <div class="alert alert-default" role="alert">
                <a href="#" class="close" data-dismiss="alert">×</a>
                <strong>Attention!</strong>These statistics are based on final mark
            </div>

            <?php
            $quick_statistics_data = array(
                1 => array("theme" => "info", "icon" => "flaticon-pie28", "heading" => "Exams Taken", "text" => $total_test),
                2 => array("theme" => "success", "icon" => "flaticon-bars11", "heading" => "Passes", "text" => $num_of_passes),
                3 => array("theme" => "danger", "icon" => "flaticon-business58", "heading" => "Fails", "text" => $num_of_fails),
                4 => array("theme" => "info", "icon" => "flaticon-pie31", "heading" => "Pass Rate", "text" => (int)$pass_rate . "%"),
                5 => array("theme" => "info", "icon" => "flaticon-line25", "heading" => "Average Mark", "text" => (int)$average_mark . "%"),
                6 => array("theme" => "info", "icon" => "flaticon-horizontal13", "heading" => "Best Mark", "text" => $best_mark . "%"),
                7 => array("theme" => "info", "icon" => "flaticon-horizontal11", "heading" => "Worst Mark", "text" => $lowest_mark . "%")
            );

            /* start generating quick stats data */

            $full_quick_statistics_ui = null;
            for ($i = 1; $i <= sizeof($quick_statistics_data); $i++) {

                $theme = $quick_statistics_data[$i]["theme"];
                $icon = $quick_statistics_data[$i]["icon"];
                $heading = $quick_statistics_data[$i]["heading"];
                $text = $quick_statistics_data[$i]["text"];

                $quick_statistics_ui = "<div class='col-lg-3 col-md-6'>";
                $quick_statistics_ui .= "<div class='panel panel-$theme'>";
                $quick_statistics_ui .= "<div class='panel-heading'>";
                $quick_statistics_ui .= "<div class='row'>";
                $quick_statistics_ui .= "<div class='col-xs-3'>";
                $quick_statistics_ui .= "<i class='glyph-icon $icon xl big-icon'></i>";
                $quick_statistics_ui .= "</div>";
                $quick_statistics_ui .= "<div class='col-xs-9 text-right'>";

                $quick_statistics_ui .= "<div class='huge xl'>$text</div>";
                $quick_statistics_ui .= "<div>$heading</div>";
                $quick_statistics_ui .= "</div>";
                $quick_statistics_ui .= " </div>";
                $quick_statistics_ui .= "</div>";

                $quick_statistics_ui .= "</div>";
                $quick_statistics_ui .= "</div>";
                $full_quick_statistics_ui .= $quick_statistics_ui;
            }
            //print out the quick stats ui
            print_r($full_quick_statistics_ui);
            ?>

        </div>
    </div>
</div>

<!---student graph-->
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyph-icon flaticon-ascendant6"></span>
            Student Perfomance Visualization
        </div>

        <div class="panel-body">
            <div class="flot-chart">
                <div class="flot-chart-content">

                    <div id="container" style="min-width: 310px; min-height: 400px; margin: 0 auto"></div>


                    <div id="container"></div>
                    <p class="only-print">Powered by acu<strong>lyse</strong> available at www.aculyse.com</p>
                </div>
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
<script type="text/javascript">
    $(function () {
        var user_perfomance = $("#plot-data").data("plot-points");
        var profile_data = $("#plot-data").data("profile-data");


        var obj_len = user_perfomance.length;
        var marks_data = [];
        var period_data = [];
        var course_work_data = [];
        var final_exam_data = [];

        for (var i = obj_len - 1; i >= 0; i--) {
            period_data.push(profile_data[i].year + " term " + profile_data[i].term);
            marks_data.push(parseFloat(user_perfomance[i][0]["combined mark"]));
            course_work_data.push(parseFloat(user_perfomance[i][0]["weighted course work"]));
            final_exam_data.push(parseFloat(user_perfomance[i][0]["weighted final mark"]))
        }

        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: ''
                },
                legend: {
                    layout: 'vertical',
                    align: 'center',
                    verticalAlign: 'bottom',
                    x: 0,
                    y: 0,
                    floating: false,
                    borderWidth: 1,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
                },
                xAxis: {
                    title: {
                        text: 'Period'
                    },
                    categories: period_data,
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 'bold'
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Marks as %'
                    },
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 'bold'
                        }
                    },
                    plotBands: [{
                        from: 0,
                        to: 50,
                        color: 'rgb(242, 222, 222)'
                    }]
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' %'
                },
                credits: {
                    enabled: true,
                },
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.9
                    },
                },
                series: [{
                    name: 'Final Exam Mark',
                    data: marks_data
                }, {
                    name: 'Tests Mark',
                    data: course_work_data
                }]
            });
        })
    });
</script>
</script>
<

<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/exporting.js"></script>


</body>
</html>
