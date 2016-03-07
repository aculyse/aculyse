<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * This page adds a new student
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
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);

HTML::header("Aculyse | Add new student");
$ClassManager = new ClassManager();
?>

<div class="col-lg-12">
    <h3 class="text-danger lighter">Create Student Record</h3>
</div>
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Add new student
        </div>
        <br/>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Tip!</strong> If you have an existing list of student records in Excel format, let us help you in inputing your students. Please contact us on support@aculyse.com for more information
            </div>
        </div>

        <div class="panel-body">

            <div class="flot-chart">
                <div class="flot-chart-content">

                    <div class="medium-float-form">

                        <form id="register-student-form" method="post" action="#" >
                            <div class="col-lg-12">
                                <b class="red">Field marked * are required</b>
                            </div>
                            <div class="col-lg-4">
                                <fieldset>
                                    <legend>Personal Details</legend>

                                    <div class="col-md-12 input-box">
                                        <label class="labels" >Firstname <span class='required'>*</span></label>
                                        <input type="text" maxlength="50" name="reg_firstNameTXT" class="input" placeholder="e.g Blessing" required="" id="firstnameTXT"/>
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Middle name</label>
                                        <input type="text" maxlength="50" name="reg_middlenameTXT" class="input" placeholder="e,g Mashcom if any" id="middlenameTXT">
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Surname <span class='required'>*</span></label>
                                        <input type="text" maxlength="50" name="reg_surnameTXT" class="input" placeholder="e.g Mashoko" required="" id="surnameTXT">
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">SEX <span class='required'>*</span></label>
                                        <select name="reg_sexTXT" class="selecter_1 input" id="sexTXT">
                                            <option>SEX (required)</option>
                                            <option>MALE</option>
                                            <option>FEMALE</option>

                                        </select>
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Date of Birth</label>
                                        <input type="text" maxlength="16"name="reg_idnumTXT" class="input" placeholder="mm/dd/yyyy" required="" id="dobTXT"/>

                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-lg-4">
                                <fieldset>

                                    <legend>Studies</legend>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Student ID # <span class='required'>*</span></label>
                                        <input type="text" maxlength="10" name="reg_collegeNumTXT" class="input" placeholder="generated if left blank" required="" id="college-numberTXT"/>
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Class <span class='required'>*</span></label>
                                        <select name="reg_ms1TXT" class="selecter_1 input" id="classTXT">
                                            <option>--required--</option>
                                            <?php
                                            $classes_arr = $ClassManager->getClassesOfferedAtSchool();
                                            foreach ($classes_arr as $c) {
                                                $class_id = $c["class_id"];
                                                $class_name = $c["class_name"];
                                                echo "<option value='$class_id'>" . strtoupper($class_name) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Class of <span class='required'>*</span></label>
                                        <select class="selecter_1 input" id="class_ofTXT">
                                            <option value="null">--required--</option>
                                            <?php
                                            for ($i = date("Y") + 10; $i >= 2000; $i--) {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </fieldset>
                            </div>

                            <div class="col-lg-4">
                                <fieldset>
                                    <legend>Guardian/Parent Contacts</legend>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Home Address</label>
                                        <textarea type="text" maxlength="100" rows="8" name="reg_homeTXT" class="input" title="" id="home-addressTXT"></textarea>
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Mobile Phone Number</label>
                                        <input type="tel" maxlength="25" name="reg_mobileTXT" class="input" placeholder="eg phonenumber" id="cellTXT" >
                                    </div>

                                    <div class="col-md-12 input-box">
                                        <label class="labels">Email address</label>
                                        <input type="email" maxlength="250" name="reg_emailTXT" class="input" placeholder="eg xxxxx@provider.com" id="emailTXT"/>
                                        </email>

                                </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <div class="list-group" id="errors-box">
                                    </div>
                                </div>


                                    </form>
                            </div>

                    </div>

                </div>
            </div>
            <div class="panel-heading panel-bottom">
                <input type="button" name="reg_submitBTN" value="create account" id="save-studentBTN" class="btn btn-action btn-sm"/>
                <input type="button" value="cancel" id="login" class="btn btn-default btn-sm"/>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php
include_once INCLUDES_FOLDER.'/footer.php';
?>
<script src="../js/jquery-1.11.0.js"></script>
<script src="../ajax/students.js"></script>
<script>
    $("#save-studentBTN").click(function () {
        var _Student = new Student();
        _Student.saveNewStudent();
    });
</script>
<script src="../js/common.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../ajax/student_reader.js"></script>
<script src="../js/master.js"></script>
<script src="../ajax/section_loader.js"></script>
<script src="../js/jquery.msgbox.js"></script>
<script src="../js/Chart.js"></script>
<script src="../js/jquery-ui.min.js"/>
<script src="../js/master.js"></script>
<script src="../js/jquery.fs.stepper.min.js"></script>

<script>
    $(function () {
        $("#dobTXT").datepicker();
        $(".selecter_1").selecter();
    });


</script>


</body>
</html>
