<?php

namespace Aculyse;
use Aculyse\Elearning\Resources;
use Aculyse\UI\HTML;

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
<style>
h1,h2,h3{
  font-family: Montserrat !important;
}
</style>


                    <div class="col-lg-12">
                        <h1 class="text-danger lighter">Course Resources</h1>
                        <h5>You are allowed to view the following courses</h5>
                    </div>

                    <!--list of classes-->
                    <div class="col-lg-12 col-sm-12 no-padding">


                        <table>
                            <thead>
                            <th>Name</th>
                            <th></th>
                            </thead>
                            <tbody>
                                <?php
                        $Resources= new Resources();
                        $resource_list  = $Resources->getAll();
                                foreach ($resource_list as $item) :
                                    ?>
 <tr>
                                    <td class="bold"><?php  echo $item->title ?></td>
                                    <td><a href="resource.php?id=<?php  echo $item->id ?>" class="btn btn-xs btn-action pull-right">download</a></td>
                                </tr>

                                <?php
                                endforeach;
                                ?>


                            </tbody>
                        </table>
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
                    $("#sub-input-box,.power-circle").slideToggle(200);
                }


            </script>


    </body>
</html>
