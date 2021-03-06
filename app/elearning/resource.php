<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Elearning\Resources;

require_once "../../vendor/autoload.php";

@session_start();
if (AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
    die();
}
$allowed_levels = array(
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_SINGLE_MODE);

$access_level_num = $_SESSION["user"]["access_level"]["right"];
if (!in_array($access_level_num, $allowed_levels)) {
    header("location:index.php");
    die();
}

HTML::header("Aculyse | Student Profile Analysis");
?>
                    <div class="col-lg-12">
                        <h1 class="text-danger lighter">Resource Details</h1>

                    </div>
                    <?php
                    $Resource = new Resources();
                    $resource_details = $Resource->get($_GET["id"]);
                    //  dd($resource_details);
                    ?>

                    <!--list of classes-->
                    <div class="col-lg-12 col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a href="#" class="btn btn-action btn-md">Download</a>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-3">

                                    <img src="../avatars/default.png" class=""/>
                                </div>
                                <div class="col-lg-9">
                                    <table class="table striped bordered">

                                        <tr><td class="text-bold">Name:</td><td><?php echo $resource_details->title ?></td></tr>
                                        <tr><td class="text-bold">Description: </td><td><?php echo $resource_details->description ?></td></tr>
                                        <tr><td class="text-bold">Subject:</td><td><?php echo $resource_details->subject_info->title ?></td></tr>
                                        <tr><td class="text-bold">Level: </td><td><?php echo $resource_details->level ?></td></tr>
                                        <tr><td class="text-bold">Created by: </td><td> <?php echo $resource_details->author_info->fullname ?></td></tr>
                                        <tr><td class="text-bold">Date created: </td><td><?php echo $resource_details->created_at ?></td></tr>
                                        <tr><td class="text-bold">Format: </td><td><?php echo $resource_details->format ?></td></tr>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <?php
            include_once '../includes/footer.php';
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

            <script>
                $(function () {
                    $(".selecter_1").selecter();
                    loadUsers();
                });

                function toogleAllocBox() {
                    $("#sub-input-box,.power-circle").strdeToggle(200);
                }


            </script>


    </body>
</html>
