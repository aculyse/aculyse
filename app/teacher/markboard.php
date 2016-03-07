<?php

namespace Aculyse;

use Aculyse\UI as UI;
use Aculyse\Helpers\Auth;

require_once "../../vendor/autoload.php";

@session_start();
Auth\Auth::isAllowed([
    AccessLevels::LEVEL_WRITE_ANALYTICS,
    AccessLevels::LEVEL_SINGLE_MODE
]);
UI\HTML::header("Aculyse | Markboard");
?>
<div class="col-lg-12">

    <h2 class="text-danger lighter">Markboard</h2>
    <h5>Record and manage student marks on the go, isnt that great!</h5>
</div>

<div class="col-lg-12">
    <div class="panel panel-primary shadow">

        <div class="panel-body">
            <button class="btn btn-md btn-action" onclick="getProfileForm();"><span class="glyph-icon flaticon-note19"></span>Start A New Profile</button>

        </div>
    </div>
</div>
<?php
$UserIdentifier = new UserIdentifier();
$subjects = $UserIdentifier->lecturerSubjects();
?>
<!-- /.row -->
<div class="col-lg-12" id="preloaded-menu">
    <div class="panel panel-primary">
        <div class="panel-heading">

            <div class = "btn-group centered">
                <button class = 'btn btn-sm btn-info text-danger' onclick = "resetLayout();"><span class = "typcn typcn-arrow-back"></span>Back</button>
                <button class = 'btn btn-sm btn-info' onclick = "addStudentDialog();"><span class = "typcn typcn-user-add"></span>Add student</button>
                <button class = 'btn btn-sm btn-info' onclick = 'compileDialog();'><span class = "typcn typcn-chart-pie"></span>Compile</button>
                <button class = 'btn btn-sm btn-info' onclick = 'addTestsDialog();'><span class = "typcn typcn-plug"></span>Add tests</button>
                <button class = 'btn btn-sm btn-info' id = "profile-meta" data-pid = 20><span class = "typcn typcn-info"></span>Assessment weights</button>
            </div>
            <div class = "btn-group float-right">
                <button type = "button" class = "btn btn-default btn-sm">Export</button>
                <button type = "button" class = "btn btn-default btn-sm dropdown-toggle" data-toggle = "dropdown">
                    <span class = "caret"></span>
                    <span class = "sr-only"></span>
                </button>
                <ul class = "dropdown-menu" role = "menu">
                    <li><a download = "Profile <?php echo md5(rand(0, 100)) ?>.xls" href = "#"onclick = "return ExcellentExport.excel(this, 'current-profile-table', 'Student marks');">Export to Excel</a>
                    </li>
                    <li><a download = "Profile<?php echo md5(rand(0, 100)) ?>.cvs" href = "#"onclick = "return ExcellentExport.cvs(this, 'current-profile-table');">Export to CVS</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <?php
            $profile_id = $_GET["profile_id"];
            $Profiler = new Profiler();
            $profile_data = $Profiler->getProfileStatus($profile_id);

            if ($profile_data->count() == 0) {
                require_once INCLUDES_FOLDER . "/new_profile_not_found.php";
                die();
            }

            $params = array(
                "profile_id" => $profile_id,
                "subject" => $profile_data["subject"],
                "term" => $profile_data["term"],
                "year" => $profile_data["year"],
                "course work" => $profile_data["number of courseworks"],
                "mode" => $profile_data["class_name"],
                "class of" => $profile_data["class of"]
            );


            $profile_status = $Profiler->isProfileNotTaken($params);
            $users = $Profiler->getClassStudents($params);
            $existing_sheet = $Profiler->getProfileMarkList($profile_id);

            require_once VIEWS_FOLDER . "/compile_ui.php";
            UIGenerator::drawSheet($users, $profile_data["number of courseworks"], $existing_sheet);
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
<script>
                                    $(function () {
                                        $(".selecter_1").selecter();
                                        $('#student-list-table').dataTable({
                                            "order": [[6, "desc"]],
                                            'iDisplayLength': 50,
                                            "language": {
                                                "lengthMenu": "Display _MENU_ records per page",
                                                "info": "Showing page _PAGE_ of _PAGES_"
                                            }
                                        });
                                        bootstro.start(".tour");
                                    });
</script>

<script>
    $("#profile-meta").click(function () {
        var pid = $("#profile-meta").data("pid");

        getProfileMetaUI(pid);
    });
</script>
</body>
</html>
