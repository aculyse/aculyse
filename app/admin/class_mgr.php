<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once '../../vendor/autoload.php';

$access_level_num = ActiveSession::accessLevel();
@session_start();
Auth::isAllowed([
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_WRITE_ANALYTICS,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);

HTML::header("Aculyse | Class Management Portal")
?>

<div class="col-lg-12">
    <h3 class="text-danger lighter">Class Management</h3>
    <h5>Manage classes on the go! pure awesomeness.</h5>
</div>

<!--list of classes-->
<div class="col-lg-7 col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <form method="get" action="">
                <div id="search-master" class="input-group form-search col-lg-6 col-md-6 col-sm-12">
                    <input type="text" class="form-control search-query" name="query" id="search-input" placeholder="search here">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-action" data-type="last" onclick="searchStudent()">Search</button>
                    </span>
            </form>
        </div>
    </div>
    <div class="panel-body">
        <table class="table">
            <thead>
            <th>Name</th>
            <th>Level</th>
            </thead>


            <?php
            $ClassManager = new ClassManager();
            $query = NULL;
            if (isset($_GET["query"])) {
                $query = $_GET["query"];
            }
            $request = $ClassManager->getClassesOfferedAtSchool($query);
            $classes_ui = "";
            if (is_array($request)) {
                for ($i = 0; $i < sizeof($request); $i++) {
                    $class_name = strtoupper(htmlspecialchars_decode($request[$i]["class_name"]));
                    $class_level = strtoupper(htmlspecialchars_decode($request[$i]["level"]));
                    $class_description = htmlspecialchars_decode($request[$i]["desc"]);
                    $class_id = $request[$i]["class_id"];

                    $classes_ui .="<tr>";
                    $classes_ui .="<td><a href='class_full.php?id=$class_id' class='bold' title='view class details'>$class_name</a></td>";
                    $classes_ui .="<td><span class='label label-success btn btn-xs'>$class_level</span></td>";
                    $classes_ui .="</tr>";
                }
                print_r($classes_ui);
            } else {
                echo '<div id="warning" class="col-lg-12">

    <span class="typcn typcn-info"></span>
    <h4>No classes available</h4>
    <p class="filler">No classes available</p>
</div>';
}
?>
        </table>
    </div>
</div>
</div>
<?php

require_once VIEWS_FOLDER . "/class_manager_ui.php";
?>


</div>

</div>

<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-1.11.0.js"></script>
<script src="../ajax/users.js"></script>
<script src="../ajax/allocator.js"></script>
<script src="../ajax/user_writer.js"></script>
<script src="../js/print.js"></script>
<script src="../js/common.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../ajax/add_student.js"></script>
<script src="../ajax/section_loader.js"></script>
<script src="../js/jquery.msgbox.js"></script>
<script src="../js/Chart.js"></script>
<script src="../js/master.js"></script>
<script src="../js/jquery.fs.stepper.min.js"></script>
<script src="../js/bootstro.js"></script>

<script>
                            $(function () {
                                $(".selecter_1").selecter();
                                loadUsers();
                            });

                            function toogleAllocBox() {
                                $("#sub-input-box,.power-circle").slideToggle(200);
                            }


</script>


</body>
</html>
