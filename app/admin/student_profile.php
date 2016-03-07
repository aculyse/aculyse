<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * This page shows the details of an individual student
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

UI\HTML::header("Aculyse | Profiler");
?>

<span class='hide nope hiden' id="access-pixel" data-access="<?php echo $access_level_num ?>"></span>

<div class="col-lg-12  no-print">
    <h3 class="text-danger lighter">Student Profile</h3>

</div>
<div class="col-lg-12  only-print">
    <h6>generated <?php echo date("d M Y H:m:s") ?></h6>
    <div class="panel panel-primar">
        <div class="panel-body">
            <h1 class="centered logo">acu<span class='light'>lyse</span></h1>
            <h4 class="centered">Student Record</h4>
            <h4 class="centered"><?php echo ActiveSession::schoolName(); //$_SESSION["user"]["school info"]["name"]                                                 ?></h4>
        </div>
    </div>
</div>

<div class="col-lg-12">

            <?php
            $Student = new Students();
            $ClassManager = new ClassManager();

            $user_account = $_GET['id'] or die("student account not specified");

            $dataset = $Student->getStudents(NULL, "SINGLE", $user_account);
            $dataset_len = sizeof($dataset);
            //dd($dataset);

            if (!$dataset == FALSE) {
                $id = strtoupper(htmlspecialchars($dataset[0]["id"]));
                $student_id = strtoupper(htmlspecialchars($dataset[0]["student id"]));
                $firstname = strtoupper(htmlspecialchars($dataset[0]["firstname"]));
                $surname = strtoupper(htmlspecialchars($dataset[0]["surname"]));
                $middlename = strtoupper(htmlspecialchars($dataset[0]["middle name"]));
                $sex = strtoupper(htmlspecialchars($dataset[0]["sex"]));
                $dob = strtoupper(htmlspecialchars($dataset[0]["dob"]));
                $home_address = strtoupper(htmlspecialchars($dataset[0]["home"]));
                $cell = strtoupper(htmlspecialchars($dataset[0]["cell number"]));
                $email = strtoupper(htmlspecialchars($dataset[0]["email"]));
                $avatar = htmlspecialchars($dataset[0]["avatar"]);
                $class_id = htmlspecialchars($dataset[0]["class_name"]);
                $status = htmlspecialchars($dataset[0]["status"]);
                $class_name = strtoupper($ClassManager->getClassDetails($class_id)[0]["class_name"]);
                $class_of = htmlspecialchars($dataset[0]["class of"]);
                ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                              <div class="btn-group centered">

                                  <?php
                                  if ($access_level_num == AccessLevels::LEVEL_WRITE_STUDENTS || $access_level_num == AccessLevels::LEVEL_ADMIN_ONLY || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {
                                      echo ' <button class="btn btn-danger" onclick="showDelDialog()"><span class="fa fa-trashed"></span>Delete</button>';
                                  } else {
                                      echo "<style>.edit-badge{display:none !important;}</style>";
                                  }
                                  ?>

                                      <button class="btn" onclick=print();><span class="fa fa-print"></span> Print</button>
                              </div>
                            </div>
                        </div>

                        <div class="panel-body">
            <div id='student-profile' class='clear-fix'>
                    <div class="col-lg-12">
                        <div class="panel panel-primary no-print no-border">

                                    <div class="panel-body">


                                    </div>
                            </div>
                        </div>

                            <div class="col-lg-4">
                            <div class="panel panel-primary no-border">
                                <div class="panel-body">
                                    <div class='profile-pic'>
                                        <img src='<?php echo $avatar ?>' class="img-circle"  alt='no image'/>
                                        <div id="tr-upload" class="change-pic" title="change profile picture"><span class="typcn typcn-camera"></span></div>
                                        <div class="upload-box" id="upload_wrapper">
                                            <form action="../executers/uploader.php" method="post" enctype="multipart/form-data">
                                                    <input type="file" id="upload-pic" name="image">
                                                <input type="text" name="student_id" value="<?php echo $student_id ?>">
                                                <input type="submit" id="submit_btn" value="Upload">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                            <div class="col-lg-8">
                            <div class="panel panel-primary no-border">

                                    <div class="panel-body">
                                    <div class="flot-chart">
                                        <div class="flot-chart-content">
                                        </div>

                                        <?php
                                        //render student details
                                        if ($cell == 0 || empty($cell)) {
                                            $cell = NULL;
                                        }

                                        echo "<table id='student-details-table' class='' data-user-uid='$student_id'>";

                                        echo '<tr>';
                                        echo "<td>Student ID</td>";
                                        echo "<td id='e-college-num' data-current-value='$student_id' class='yep xl text-danger bold'><span class='cval'>$student_id</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-college-num\")>edit</span>"
                                        . "</td>";
                                        echo '</tr>';

                                        echo '<tr>';
                                        echo "<td>Current Class</td>";
                                        echo "<td  class='yep xl  bold' id='e-class' data-current-value='$class_name'>"
                                        . "<span class='cval'>$class_name</span> "
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-firstname\",\"classes\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-firstname\",\"firstname\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo '</tr>';

                                        echo '<tr>';
                                        echo "<td>Class of</td>";
                                        echo "<td  class='yep xl  bold' id='e-class-of' data-current-value='$class_of'>"
                                        . "<span class='cval'>$class_of</span> "
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-class-of\",\"class_of\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-class-of\",\"class of\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo '</tr>';

                                        echo '<tr>';
                                        echo "<td>Status</td>";
                                        echo "<td  class='yep xl  bold' id='e-status' data-current-value='$status'>"
                                        . "<span class='cval'>$status</span> "
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-status\",\"status\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-status\",\"status\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo '</tr>';

                                        echo "<tr class='shaddy'><td>PERSONAL DETAILS</td><td></td></tr>";

                                        echo '<tr>';
                                        echo "<td>Firstname</td>";
                                        echo "<td id='e-firstname' data-current-value='$firstname'>"
                                        . "<span class='cval'>$firstname</span> "
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-firstname\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-firstname\",\"firstname\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo '<tr>';
                                        echo "<td>Middle Name</td>";
                                        echo "<td id='e-middlename' data-current-value='$middlename'><span class='cval'>$middlename</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-middlename\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-middlename\",\"middle name\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo '<tr>';
                                        echo "<td>Surname</td>";
                                        echo "<td id='e-surname' data-current-value='$surname'><span class='cval'>$surname</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-surname\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-surname\",\"surname\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo '<tr>';
                                        echo "<td>Sex</td>";
                                        echo "<td id='e-sex' data-current-value='$sex'><span class='cval'>$sex</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-sex\",\"sex\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-sex\",\"sex\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo "<td>Date of Birth</td>";
                                        echo "<td id='e-dob' data-current-value='$dob'><span class='cval'>$dob</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-dob\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-dob\",\"dob\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";


                                        echo "<tr class='shaddy'><td>GUARDIAN</td><td></td></tr>";

                                        echo '<tr>';
                                        echo "<td>Home Address</td>";
                                        echo "<td id='e-home-address' data-current-value='$home_address'><span class='cval'>" . nl2br($home_address) . "</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-home-address\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-home-address\",\"home\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo '<tr>';
                                        echo "<td>Contact Number</td>";
                                        echo "<td id='e-cell' data-current-value='$cell'><span class='cval'>$cell</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-cell\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-cell\",\"cell number\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer' onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo '<tr>';
                                        echo "<td>Email Address</td>";
                                        echo "<td id='e-email' data-current-value='$email'><span class='cval'>$email</span>"
                                        . "<span class='badge badge-default yep pointer float-right edit-badge bold' onclick=getEdit(\"e-email\")>edit</span>"
                                        . "<button class='default-btn nope pointer' onclick='startUpdating(\"e-email\",\"email\");'>update</button>"
                                        . "<button class='default-btn bitter nope pointer'  onclick='resetEditInputUI();'>cancel</button>"
                                        . "</td>";
                                        echo "</tr>";

                                        echo "</table>";

                                        echo "<span id='student-profile-meta' data-uid='$student_id'><span>";
                                    }
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
</div>
</div>

<?php
require_once INCLUDES_FOLDER . '/delete_dialog.php';
include_once INCLUDES_FOLDER . '/footer.php';
?>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-1.11.0.js"></script>
<script src="../js/edit-mode.js"></script>

<script type="text/javascript">
                                    function getEdit(el, is_study) {
                                        var _edit = new StudentEdit(el);
                                        _edit.activateUI(is_study);
                                    }

                                    function getUpdatedData() {

                                        var _edit = new StudentEdit();
                                        _edit.getUpdateInput();
                                    }

                                    function resetEditUI() {
                                        var _edit = new StudentEdit(el);
                                        _edit.resetUI();
                                    }

</script>
<script src="../js/print.js"></script>
<script src="../js/jquery-ui.min.js"/>
<script src="../ajax/allocator.js"></script>
<script src="../js/common.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../ajax/student_reader.js"></script>
<script src="../ajax/students.js"></script>
<script src="../ajax/section_loader.js"></script>
<script src="../js/jquery.msgbox.js"></script>
<script src="../js/Chart.js"></script>
<script src="../js/master.js"></script>
<script src="../js/jquery.fs.stepper.min.js"></script>
<script type="text/javascript">
                                    $(document).ready(function () {

                                        $(".selecter_1").selecter();
                                    });




</script>

<script type="text/javascript">

    //trigger file button
    $("#tr-upload").on('click', function (e) {
        e.preventDefault();
        $("#upload-pic").trigger('click');
    });
    //submit pic
    $("#upload-pic").on('change', function (e) {
        e.preventDefault();
        $("#submit_btn").trigger('click');
    });
    $("#e-dob-txt").datepicker();


</script>


</body>
</html>
