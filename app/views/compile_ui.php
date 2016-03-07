<?php
if ($existing_sheet->count() == 0) {
    require_once INCLUDES_FOLDER . "/profile_not_found.php";
    die() ;
}

$course_work_percentage = $existing_sheet[0]["course work percentage"] ;
$final_weight_percentage = $existing_sheet[0]["final weight percentage"] ;

$profile_id = $params["profile_id"];
$course_work_count = $params["course work"];
?>
<div class="col-md-12">
    <div class="panel-body">
    </div>
</div>

<div id="overlay"></div>

<!--compile ui-->
<div class="panel panel-primary dialog" id='compile'>
    <div class="panel-heading">
        <h3 class="panel-title">Compile Profile</h3>
    </div>
    <div class="panel-body">

        <?php
        if($final_weight_percentage > 0 || $course_work_percentage > 0) {
            $ui = '<div class="alert alert-default">' ;
            $ui.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' ;
            $ui.="<strong>Hey! </strong> This profile is closed, so no further editing can be done to it anymore. If you need to reopen it please contact support@aculyse.com" ;
            $ui.='</div>' ;
            print_r($ui) ;
        }
        ?>


        <div class="input-box col-lg-12">
            <label class="labels">Course Work Weight (%)</label>
            <div class="input-group form-search">
                <input type="text" class="form-control search-query" id="cwwTXT" placeholder="course work weight" value='<?php echo $course_work_percentage ?>'>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" data-type="last">%</button>
                </span>
            </div>
        </div>

        <div class="input-box col-lg-12">
            <label class="labels">Final Exam Weight (%)</label>
            <div class="input-group form-search">
                <input type="text" class="form-control search-query" id="fewTXT"  placeholder="final exam weight" value='<?php echo $final_weight_percentage ?>'>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" data-type="last">%</button>
                </span>
            </div>
        </div>

        <div class="input-box col-lg-12" id="progress-report">
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                </div>
            </div>
        </div>
        <p id='msg-error'><span id='msg-text'></span></p>

    </div>
    <div class="panel-heading panel-bottom">
        <?php
        echo "<button class='btn btn-action  btn-md' onclick='compile(\"$course_work_count\")'>Compile</button>";
?>
        <button class='btn btn-default btn-md' onclick=compileDialog();>Close</button>

    </div>
</div>

<!--add tests to profile-->
<div class="panel panel-primary dialog" id='add-test'>
    <div class="panel-heading">
        <h3 class="panel-title">Add Tests to profile</h3>
    </div>
    <div class="panel-body">

        <?php
        if($final_weight_percentage > 0 || $course_work_percentage > 0) {
            $ui = '<div class="alert alert-default">' ;
            $ui.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' ;
            $ui.="<strong>Hey! </strong> This profile is closed, so no further editing can be done to it anymore. If you need to reopen it please contact support@aculyse.com" ;
            $ui.='</div>' ;
            print_r($ui) ;
            // die() ;
        }
        ?>


        <div class="input-box col-lg-12">
            <label class = "labels">Increase tests to</label>
            <select id="tuTXT" class="input selector selecter">
                <?php
                for($i = $profile_data["number of courseworks"] + 1 ; $i <= 10 ; $i++) {
                    echo "<option>$i</option>" ;
                }
                ?>
            </select>
        </div>

        <div class = "input-box col-lg-12" id = "progress-report">
            <div class = "progress progress-striped active">
                <div class = "progress-bar progress-bar-info" role = "progressbar" aria-valuenow = "100" aria-valuemin = "0" aria-valuemax = "100" style = "width: 100%">
                </div>
            </div>
        </div>
        <p id = 'msg-error'><span id = 'msg-text'></span></p>

    </div>
    <div class = "panel-heading panel-bottom">
        <?php
        echo "<button class='btn btn-action  btn-md' onclick='updateTests(\"$profile_id\")'>Update profile</button>" ;
        ?>
        <button class='btn btn-default btn-md' onclick=addTestsDialog();>Cancel</button>

    </div>
</div>

<!--add student-->
<div class="panel panel-primary dialog" id='add-student'>
    <div class="panel-heading">
        <h3 class="panel-title">Add student</h3>
    </div>
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="input-group form-search">
                <input type="text" class="form-control search-query" id="cnTXT" placeholder="search student" onkeyup="searchStudent4ManualAdd();">
                <span class="input-group-btn">
                    <button type="submit" id="cnTXT" class="btn btn-primary" data-type="last" onclick="searchStudent4ManualAdd();">search</button>
                </span>
            </div>

        </div>
        <div id="result-el" class="col-lg-12">

        </div>
        <div class="input-box" id="progress-report">
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                </div>
            </div>
        </div>
        <!--errors-->
        <div class="alert alert-danger clear-fix no-float nope" id="errors-el">
            <strong id="msg-text"></strong>
        </div>
        <!--<p id='msg-error'><span id='msg-text'></span></p>-->
    </div>
    <div class="panel-heading panel-bottom">

        <?php
        $profile_id = $existing_sheet[0]["profile id"] ;
        echo "<button class='btn btn-action btn-sm' onclick='addStudentToProfile(\"$profile_id\" )'>Add Student</button>" ;
        ?>
        <button class='btn btn-default btn-sm' onclick='addStudentDialog();'>Cancel</button>
    </div>
</div>
