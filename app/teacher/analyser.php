<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";

@session_start();

//check if user is allowed
Auth::isAllowed([
    AccessLevels::LEVEL_READ_ANALYTICS_ONLY,
    AccessLevels::LEVEL_WRITE_ANALYTICS,
    AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);

HTML::header("Aculyse | Student Profile Analysis");
?>
<div class="col-lg-12 no-print">
    <h2 class="text-danger lighter">Class Perfomance Report</h2>
    <h5>**Get perfomance metrics per subject and even drill down to individual perfomance...</h5>
</div>



<div class="col-lg-12 no-padding">
    <div id="result-box">
        <?php
        $ClassManager = new ClassManager();
        $Profiler = new Profiler();
        $UserIdentifier = new UserIdentifier();
        $Student = new Students();

        $subjects = $UserIdentifier->lecturerSubjects();

//if the selection criteria is not specified
        if (!isset($_GET['profile_id'])) {
            require_once "includes/warning.php";
            die();
        }
        $profile_id_param = $_GET['profile_id'];

        $mark_list = $Profiler->getProfileMarkList($profile_id_param);
        $profile_data = $Profiler->getProfileStatus($profile_id_param);

        $profile_id = $profile_data->id;
        $class_id = $profile_data->class_name;
        $class_name = strtoupper($ClassManager->getClassDetails($class_id)[0]["class_name"]);
        $class_level = $ClassManager->getClassDetails($class_id)[0]["level"];
        $grading = GradingSystem::chooseDefaultGrading($class_level);
        $year = $profile_data["year"];
        $term = $profile_data["term"];
        $subject_data = $Profiler->getSubjectName($profile_data["subject"]);
        $subject = htmlspecialchars($subject_data["title"]);
        $class_of = $profile_data["class of"];


        //get top and bottom 5 students
        $top_student_dataset = $Profiler->getTopStudents($profile_id);
        $bottom_student_dataset = $Profiler->getBottomStudents($profile_id);

//just in case there are no marks
        if ($mark_list->count() == 0) {
            require_once "../includes/warning.php";
            die();
        }

        $course_work_weight = $mark_list[0]["course work percentage"] . "%";
        $final_exam_weight = $mark_list[0]["final weight percentage"] . "%";

        //choose the grading system to use
        $grades = GradingSystem::getGradingStructure($grading);
        $grading_system = GradingSystem::getLevelName($grading);

        //sum up student in different grades, this data is used to make the dataset used to draw graphs and tables
        for ($i = 0; $i < $mark_list->count(); $i++) {
            $final_mark = $mark_list[$i]["combined mark"];
            $grade_symbol = $mark_list[$i]["grade"];
            $grades[$grade_symbol]+=1;
        }
        $mark_list_json = json_encode($grades);

        echo "<span id='grades' data-grades='$mark_list_json'  data-level='$grading'></span>";

        ?>

        <div class="col-lg-12 only-print">
            <div class="panel panel-primar">
                <div class="panel-body">
                    <h1 class="centered logo">acu<span class='light'>lyse</span></h1>
                    </h1>
                    <h3 class="centered">Students Perfomance Report</h3>
                    <h4 class="centered"><?php echo $_SESSION["user"]["school info"]["name"] ?></h4>

                    <h5>
                        <label class="labels">Subject: <span class="bold text-default"><?php echo $subject ?></span></label>
                    </h5>
                    <h5>
                        <label class="labels">Class Name: <span class="bold text-default"><?php echo $class_name ?></span></label>

                    </h5>
                    <h5>
                        <label class="labels">Year: <span class="bold text-default"><?php echo $year ?></span></label>

                    </h5>
                    <h5>
                        <label class="labels">Term: <span class="bold text-default"><?php echo $term ?></span></label>

                    </h5>
                    <h5>
                        <label class="labels">Class of: <span class="bold text-default"><?php echo $class_of ?></span></label>
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-lg-12 no-print">
            <div class="panel shadow">
                <div class="panel-body">
                    <div class="btn-group centered">
                        <button class="btn btn-sm btn-info" onclick="print();"><span class="typcn typcn-printer"></span>Print</button>
                    </div>
                    <div class="btn-group pull-right">

                        <button type="button" class="btn btn-sm"><span>Grading: </span><?php echo $grading_system ?></button>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 no-padding no-print">

            <!--subject-->
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyph-icon flaticon-edu-shelf xl big-icon"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Subject</div>
                                <div class="huge xl"><?php print_r($subject); ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  class_name-->
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyph-icon flaticon-edu-schoolclass xl big-icon"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Class</div>
                                <div class="huge xl"><?php print_r($class_name); ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--term-->
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyph-icon flaticon-watch10 xl big-icon "></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Term</div>
                                <div class="huge xl"><?php echo $term ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--class of-->
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyph-icon flaticon-sand4 xl big-icon"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Class of</div>
                                <div class="huge xl"><?php echo $class_of ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--year-->
            <div class="col-lg-2 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyph-icon flaticon-weekly3 xl big-icon"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Year</div>
                                <div class="huge xl"><?php echo $year ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 no-padding">

            <div class="col-lg-6 col-md-6 no-pint">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="glyph-icon flaticon-pie32"></span>
                        Mark Distribution Pie Chart
                    </div>

                    <div class="panel-body">
                            <div id='graph-box'>

                            </div>
                    </div>

                </div>
            </div>


            <!-- /.summary -->
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="glyph-icon flaticon-ascendant6"></span>
                        Mark Distribution Graph
                    </div>

                    <div class="panel-body">
                        <div id='bar-graph-box'></div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.panel-body -->


        <?php
        if (sizeof($mark_list) - 1 <= 10):
            ?>
        <div class="col-lg-12">
                <div class="alert alert-warning bold" >
                    Top and Bottom 5 for less thay 10 students can include a student on both categories.
                </div>
            </div>
            <?php
        endif;
        ?>

        <!---top 5-->
        <div class="col-lg-4 no-print">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyph-icon flaticon-horizontal13"></span>Top 5 students</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">

                        <?php
                        //get the top 5 students
                        if ($top_student_dataset->count() == 0) {
                            echo "Calculation aborted";
                        } else {
                            for ($i = 0; $i <= sizeof($top_student_dataset) - 1; $i++) {
                                $top_college_num = htmlspecialchars($top_student_dataset[$i]["student id"]);
                                $top_mark = htmlspecialchars($top_student_dataset[$i]["combined mark"]);

                                $this_student_dataset = $Student->getStudents(NULL, $type = "SINGLE", $top_college_num, NULL, NULL);

                                $top_fullname = htmlspecialchars($this_student_dataset[0]["firstname"] . " " . $this_student_dataset[0]["middle name"] . " " . $this_student_dataset[0]["surname"]);

                                $top_ui = "<a href='single?cn=$top_college_num&subject=$class_id&pid=$profile_id' target='blank' class='list-group-item'>";
                                $top_ui .= "<h6 class='list-group-item-heading'>$top_college_num</h6>";
                                $top_ui .= "<p class='list-group-item-text'>$top_fullname .<span class='badge badge-info float-right bold'>$top_mark %</span></p>";
                                $top_ui .= "</a>";

                                echo $top_ui;
                            }
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>
        <!---bottom 5-->
        <div class="col-lg-4 no-print">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyph-icon flaticon-horizontal11"></span>Bottom 5 students</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">

                        <?php
                        //get the bottom 5 students

                        if ($bottom_student_dataset->count() == 0) {
                            echo "Calculation aborted";
                        } else {
                            for ($i = 0; $i <= sizeof($bottom_student_dataset) - 1; $i++) {
                                $top_college_num = htmlspecialchars($bottom_student_dataset[$i]["student id"]);
                                $top_mark = htmlspecialchars($bottom_student_dataset[$i]["combined mark"]);

                                $this_student_dataset = $Student->getStudents(NULL, $type = "SINGLE", $top_college_num, NULL, NULL);

                                $top_fullname = htmlspecialchars($this_student_dataset[0]["firstname"] . " " . $this_student_dataset[0]["middle name"] . " " . $this_student_dataset[0]["surname"]);

                                $top_ui = "<a href='single?cn=$top_college_num&subject=$class_id&pid=$profile_id' target='blank' class='list-group-item'>";
                                $top_ui .= "<h6 class='list-group-item-heading'>$top_college_num</h6>";
                                $top_ui .= "<p class='list-group-item-text'>$top_fullname .<span class='badge badge-danger float-right bold'>$top_mark %</span></p>";
                                $top_ui .= "</a>";

                                echo $top_ui;
                            }
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>
        <!-- /.summary -->
        <div class="col-lg-4 pb">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyph-icon flaticon-note25"></span>
                    Summary Table
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-default btn-sm">Export</button>
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a download="grade summary <?php echo "$subject year-$year term-$term" ?>.xls" href="#"onclick="return ExcellentExport.excel(this, 'grade-summary-table', 'Student marks');">Export to Excel</a>
                            </li>
                            <li><a download="grade summary <?php echo "$subject year-$year term-$term" ?>.cvs" href="#"onclick="return ExcellentExport.cvs(this, 'grade-summary-table');">Export to CVS</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">

                    <table id='grade-summary-table' class='s-table'>
                        <tr>
                            <th>GRADE</th>
                            <th># of Students</th>
                        </tr>

                        <?php
                        $grade_total_count = 0;
                        for ($g = 0; $g < sizeof($grades); $g++) {
                            $grade_index = array_keys($grades)[$g];
                            $grade_count = $grades["$grade_index"];
                            $grade_total_count+=$grade_count;
                            echo "<tr>";
                            echo "<td class='bold'>$grade_index</td>";
                            echo "<td>$grade_count</td>";
                            echo "</tr>";
                        }
                        ?>

                        <tr>
                            <td class='pass xl'>Total</td>
                            <td class='pass xl'><?php echo $grade_total_count ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- detailed perfomance table-->
<div class="col-lg-12">
    <div class="alert alert-success bold" >
        <strong>Attention!</strong> The marks are shown after calculations using<?php echo " <strong>$course_work_weight</strong> for coursework and <strong>$final_exam_weight</strong> for final exam" ?>

    </div>
</div>

<div class="col-lg-12 pb pb_auto">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyph-icon flaticon-note24"></span>
            Full Student Perfomance
            <div class="btn-group float-right">
                <button type="button" class="btn btn-default btn-sm" onclick="toggleMoreDetails();"><span class="typcn typcn-eye-outline"></span>Raw Marks</button>
                <button type="button" class="btn btn-default btn-sm"><span class="typcn typcn-upload"></span>Export</button>
                <button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown">
                    <span class="typcn typcn-arrow-sorted-down"></span>
                    <span class="sr-only"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a download="student_marks <?php echo "$subject year-$year term-$term" ?>.xls" href="#"onclick="return ExcellentExport.excel(this, 'student-marks-table', 'Student marks');">Export to Excel</a>
                    </li>
                    <li><a download="student_marks <?php echo "$subject year-$year term-$term" ?>.cvs" href="#"onclick="return ExcellentExport.cvs(this, 'student-marks-table');">Export to CVS</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="flot-chart">
                <div class="flot-chart-content">


                    <?php
                    $course_work_num = $profile_data[0]["number of courseworks"];
                    echo "<caption><b>NB**</b> Marks with <b>CAL.</b> prefix are calculated marks</caption>";
                    echo "<table id='student-marks-table' class='base-table'>";


                    echo "<thead><tr class='hidden-more'><th></th><th></th><th></th>";
                    echo "<th>RAW MARKS</th>";
                    for ($i = 1; $i <= $course_work_num; $i++) {
                        echo "<th></th>";
                    }
                    echo "<th>CALCULATED MARKS</th><th></th><th></th><th></th></tr>";
                    echo "<tr><th></th><th>Student ID</th>";
                    echo "<th>FULLNAME</th>";

                    for ($i = 1; $i <= $course_work_num; $i++) {
                        echo "<th class='cwr hidden-more'>TEST $i</th>";
                    }

                    echo "<th class='hidden-more'>EXAM</th>";
                    echo "<th>CAL. TEST MARK</th>";
                    echo "<th>CAL. EXAM MARK</th>";
                    echo "<th>CAL. FINAL MARK</th>";



                    echo '<th>GRADE</th></tr></thead><tbody>';

                    for ($i = 0; $i <= sizeof($mark_list) - 1; $i++) {
                        $student_id = strtoupper(htmlspecialchars($mark_list[$i]["student id"]));

                        $student_data = $Student->getStudents(NULL, "SINGLE", $student_id, NULL, NULL);

                        $subject = $subject_data["title"];
                        $year = strtoupper(htmlspecialchars($profile_data[0]["year"]));
                        $term = strtoupper(htmlspecialchars($profile_data[0]["term"]));
                        $course_work = strtoupper(htmlspecialchars($mark_list[$i]["weighted course work"]));
                        $exam_mark = strtoupper(htmlspecialchars($mark_list[$i]["combined mark"]));
                        $total_mark = strtoupper(htmlspecialchars($mark_list[$i]["weighted final mark"]));
                        $final_exam_raw = strtoupper(htmlspecialchars($mark_list[$i]["final exam"]));
                        $grade = strtoupper(htmlspecialchars($mark_list[$i]["grade"]));

                        $firstname = strtoupper(htmlspecialchars($student_data[0]["firstname"]));
                        $middle_name = strtoupper(htmlspecialchars($student_data[0]["middle name"]));

                        $avatar = $student_data[0]["avatar"];
                        $surname = strtoupper(htmlspecialchars($student_data[0]["surname"]));


                        if ($middle_name == "") {
                            $fullname = $firstname . " " . $surname;
                        } else {
                            $fullname = $firstname . " " . $middle_name . " " . $surname;
                        }


                        $course_work_half = $course_work_weight / 2;

                        //comparing marks to determine increase or descrease
                        if ($i > 0) {
                            $prev_total_mark = strtoupper(htmlspecialchars($mark_list[$i - 1]["weighted final mark"]));
                        } else {
                            $prev_total_mark = 0;
                        }
                        //table rows
                        if ($exam_mark < 50) {
                            echo "<tr class='failed-final'>";
                        } else {
                            echo "<tr>";
                        }
                        echo "<td><img src='$avatar' width=30 height=30 class='img-rounded'/></td>";
                        echo "<td title='Show all student perfomances in this subject'><a href='single?cn=$student_id&subject=$class_id&pid=$profile_id' target='blank'>$student_id</a></td>";

                        echo "<td>$fullname</td>";
                        //generate coursework columns
                        for ($j = 1; $j <= $course_work_num; $j++) {
                            if (!is_null($mark_list)) {
                                $id = strtoupper(htmlspecialchars($mark_list[$i]["id"]));
                                $course_work_val = $mark_list[$i]["course work $j"];
                                if ($course_work_val < 50) {
                                    echo "<td class='fail hidden-more raw-data' id='cw-$j'>$course_work_val</td>";
                                } else {
                                    echo "<td class='pass hidden-more raw-data' id='cw-$j'>$course_work_val</td>";
                                }
                            }
                        }
                        echo "<td class='pass hidden-more raw-data'>$final_exam_raw</td>";

                        if ($course_work < $course_work_half) {
                            echo '<td class="fail">' . $course_work . '</td>';
                        } else {
                            echo '<td class="pass">' . $course_work . '</td>';
                        }

                        if ($total_mark < 50) {
                            echo '<td class="fail">' . $total_mark . '</td>';
                        } else {
                            echo '<td class="pass">' . $total_mark . '</td>';
                        }

                        //this is final percentage
                        if ($exam_mark < 50) {
                            echo '<td class="fail">' . $exam_mark . '</td>';
                        } else {
                            echo '<td class="pass">' . $exam_mark . '</td>';
                        }


                        echo "<td class='bold'>$grade</td>";


                        echo "</tr>";
                    }
                    echo "</tbody></table>";
//end of table
                    ?>
                </div>
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
<!--</div>-->
<script src="../js/analytics.js"></script>
<script src="../ajax/profiler.js"></script>
<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-3d.js"></script>
<script src="../js/exporting.js"></script>
<style type="text/css">
    #container, #sliders {
        min-width: 310px;
        //max-width: 800px;
        margin: 0 auto;
    }
    #container {
        height: auto;
        width:100%;
        margin:3% 0;
    }
</style>

</body>
</html>
