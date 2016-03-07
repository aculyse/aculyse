<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * Student records page
 */

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once "../../vendor/autoload.php";
@session_start();

$access_level_num = ActiveSession::accessLevel();

Auth::isAllowed([
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_READ_STUDENTS_ONLY,
    AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
]);

HTML::header("Aculyse | Student Management");
?>

<span class='hide nope hiden' id="access-pixel" data-access="<?php echo $access_level_num ?>"></span>

<div class="col-lg-12  no-print">
    <h3 class="text-danger lighter">Student Management</h3>
    <h5>Add, update and remove student accounts on the go, as easy as 123</h5>

</div>
<div class="col-lg-12  only-print">
    <h6>generated <?php echo date("d M Y H:m:s") ?></h6>
    <div class="panel panel-primar">
        <div class="panel-body">
            <h1 class="centered logo">acu<span class='light'>lyse</span></h1>
            <h4 class="centered">Student Record</h4>
            <h4 class="centered"><?php echo ActiveSession::schoolName(); //$_SESSION["user"]["school info"]["name"]
                ?></h4>
        </div>
    </div>
</div>

<div class="col-lg-12">


    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <form method="get" action="" class="col-lg-4">
                    <div id="search-master" class="input-group form-search">
                        <input type="text" class="form-control search-query" id="search-input" placeholder="search here"
                               name="q">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-action" data-type="last">Search</button>
                        </span>
                    </div>
                </form>

                <div class="btn-group pull-right">
                    <a href="new" class="btn btn-sm"><i class="fa fa-plus-circle"></i> Add New Student</a>
                    <a href="invite" class="btn btn-sm"><i class="fa fa-envelope-o"></i> Invite Parents</a>
                </div>
            </div>
        </div>


        <div class="panel-body">
            <div class="flot-chart">
                <div class="flot-chart-content" id="flot-line-chart">
                    <div class="col-lg-12">
                        <?php
                        $Student = new Students();
                        $ClassManager = new ClassManager();

                        //determine if pagination is neccessary
                        $page = 0;
                        if (isset($_GET["page"])) {
                            $page = $_GET["page"];
                            if (is_numeric($page) && $page >= 0) {
                                $start_from = $page * 30;
                            } else {
                                $start_from = NULL;
                                $page = 0;
                            }
                        } else {
                            $start_from = NULL;
                            $page = 0;
                        }
                        $next_page = $page + 1;

                        if (isset($_GET['q'])) {
                            $search_term = $_GET['q'];
                            $dataset = $Student->search($search_term);

                        } else {
                            $dataset = $Student->get($page);
                        }

                        $dataset_len = sizeof($dataset);
                        if ($dataset->count() == 0) {
                            require_once INCLUDES_FOLDER . "/no_students.php";
                        }
                        if ($dataset->count() > 0) {

                            echo "<table id='student-list-table' class='base-table'>";
                            echo "<thead>";
                            echo "<th></th>";
                            echo "<th>Student ID</th>";
                            echo "<th>Fullname</th>";
                            echo "<th>Sex</th>";
                            echo "<th>Class of</th>";
                            echo "<th>Class Name</th>";
                            echo "<th>Status</th>";
                            echo "</thead>";

                            foreach ($dataset as $student) {

                                echo "<tr id='student-id-$student->id'>";
                                echo "<td><img src=' " . $Student->getAvatar($student->piclink) . "' width=30 height=30 class='img-rounded'/></td>";
                                echo "<td><a href='student_profile?id=$student->student_id' class='pointer' title='view full profile of $student->firstname $student->surname'><b>$student->student_id</b></a></td>";

                                $fullname = strtoupper("$student->firstname " . $student['middle name'] . "  $student->surname");
                                echo "<td>$fullname</td>";
                                echo "<td><strong>$student->sex</strong></td>";
                                echo "<td><a href='class_full.php?id=" . $student->class_name . "&year=" . $student['class of'] . "'>" . $student['class of'] . "</a></td>";
                                echo "<td><a href='class_full.php?id=" . $student['class_name'] . "'>" . $student->classes["class_name"] . "</a></td>";


                                if ($student->status == "ACTIVATED") {

                                    echo "<td><span class='status-badge badge badge-success' onclick='toggleStudentStatus($student->id)' title='activate or deactivate account'>ACTIVE</span></td>";
                                } else if ($student->status == "DEACTIVATED") {
                                    echo "<td><span class='status-badge badge badge-danger' onclick='toggleStudentStatus($student->id)' title='activate or deactivate account'>DEACTIVATED</span></td>";
                                } else {

                                    echo "<td><span class='status-badge badge badge-normal'>" . $student->status . "</span></td>";
                                }

                                echo '</tr>';
                            }

                            echo "</table>";
                            echo "<a href='?page=$next_page' id='more-rec' class='btn btn-sm btn-default centered'>Load More</a>";
                        } else {
                            if (isset($_POST["search"])) {
                                if ($_POST["search"] == true) {
                                    require_once INCLUDES_FOLDER . "/no_search_result.php";
                                }
                            } else {
                                require_once INCLUDES_FOLDER . "/no_students.php";
                            }
                        }
                        ?>
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
