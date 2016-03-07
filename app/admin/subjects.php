<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * This page is for managing subjects
 */

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";

@session_start();
Auth::isAllowed([
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_SINGLE_MODE
]);
HTML::header("Aculyse | Subject Management");
?>

<div class="col-lg-12">
    <h3 class="text-danger lighter">Subject Management</h3>
    <h5>Manage subjects available to a school</h5>
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
        <center>
            <div class="btn-group">
                <a href="?only=all" class="btn btn-sm">All</a>
                <a href="?only=custom" class="btn btn-sm">Custom Subjects</a>
                <a href="?only=builtin" class="btn btn-sm">Built in</a>
            </div>
        </center>

        <table class="table">
            <thead>
            <th>Name</th>
            <th>Type</th>
            </thead>


            <?php
            $Subject = new Subject();
            $query = NULL;
            if (isset($_GET["query"])) {
                $query = $_GET["query"];
                $request = $Subject->search($query);
            } else {
                $request = $Subject->getAll();
            }
            if (isset($_GET["only"])) {
                switch ($_GET["only"]) {
                    case "custom":
                        $request = $Subject->getAll(TRUE);
                        break;

                    case "all":
                        $request = $Subject->getAll();
                        break;

                    case "builtin":
                        $request = $Subject->getBuiltIn();
                        break;

                    default:
                        $request = $Subject->getAll();
                        break;
                }
            }

            $classes_ui = "";
            if (is_array($request)) {
                for ($i = 0; $i < sizeof($request); $i++) {
                    $subject_name = strtoupper(htmlspecialchars_decode($request[$i]["title"]));
                    $subject_school = strtoupper(htmlspecialchars_decode($request[$i]["school"]));
                    $subject_id = $request[$i]["id"];

                    $classes_ui .="<tr>";
                    $classes_ui .="<td><a href='#' class='bold' title='view class details'>$subject_name</a></td>";
                    if ($subject_school == 0) {
                        $classes_ui .="<td><span class='label label-default btn btn-xs'>built in</span></td>";
                    } else {
                        $classes_ui .="<td><span class='label label-success btn btn-xs'>custom</span></td>";
                    }
                    $classes_ui .="</tr>";
                }
                print_r($classes_ui);
            }
            ?>
        </table>
    </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Add new subject
        </div>
        <form method="POST" action="../executers/add_subject.php">
            <div class="panel-body">
                <input class="input" placeholder="Subject name" name="subject"/>
            </div>
            <div class="panel-footer">
                <button class="btn btn-action btn-md">Save subject</button>
            </div>

        </form>
    </div>

</div>

</div>

</div>

<?php
include_once INCLUDES_FOLDER.'/footer.php';
?>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.11.0.js"></script>
<script src="ajax/users.js"></script>
<script src="ajax/allocator.js"></script>
<script src="ajax/user_writer.js"></script>
<script src="js/print.js"></script>
<script src="js/common.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="ajax/add_student.js"></script>
<script src="ajax/section_loader.js"></script>
<script src="js/jquery.msgbox.js"></script>
<script src="js/Chart.js"></script>
<script src="js/master.js"></script>
<script src="js/jquery.fs.stepper.min.js"></script>
<script src="js/bootstro.js"></script>

</body>
</html>
