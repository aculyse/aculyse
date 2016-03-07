<?php
/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * This page shows users of the system and some ways to
 * manage the user accounts
 */

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once '../../vendor/autoload.php';

$access_level_num = ActiveSession::accessLevel();
@session_start();
Auth::isAllowed([
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);

HTML::header("Aculyse | Super User Portal")
?>

<div class="col-lg-12">
    <h3 class="text-danger lighter">Admin Portal</h3>
    <h5>You are on top of the food chain, you control the users and what they can access.</h5>
</div>

<div class="col-lg-12" id="user-list-div">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <form method="get" action="">
                    <div id="search-master" class="input-group form-search width-25">
                        <input type="text" class="form-control search-query" id="search-input" name="q" placeholder="search here">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary" data-type="last">Search</button>
                        </span>
                    </div>
                </form>
                <button class="btn btn-sm btn-action right special-hack" onclick=" addUserUI();" id="tour" rel="popover" title="User Management" data-content="add users, headmasters,principals and records personnel here" >Create User Account</button>
            </div>
        </div>

        <!---list of users -->
        <div class="panel-body no-padding">
            <?php
            $UsersList = new Users();
            if (isset($_GET["q"])) {
                $search_term = $_GET["q"];

                $user_dataset = $UsersList->getUsers($search_term);
            } else {
                $user_dataset = $UsersList->getUsers();
            }


            if ($user_dataset == FALSE) {
                require_once INCLUDES_FOLDER . "/warning.php";
                die();
            }


            if (is_array($user_dataset)) {

                $table_ui = "";
                $table_ui = "<table class='base-table'>";
                $table_ui.="<thead>";
                $table_ui.="<th>USERNAME</th>";
                $table_ui.="<th>FULLNAME</th>";
                $table_ui.="<th>STATUS</th>";
                $table_ui.="<th>ACCESS LEVEL</th>";
                $table_ui.="<th>EMAIL</th>";
                $table_ui.="<th>PHONE</th>";
                $table_ui.="<th class='ds'></th>";
                $table_ui.="</thead>";

                for ($i = 0; $i <= sizeof($user_dataset) - 1; $i++) {

                    $teacher_id = htmlspecialchars($user_dataset[$i]["teacher id"]);
                    $username = htmlspecialchars($user_dataset[$i]["username"]);
                    $fullname = strtoupper(htmlspecialchars($user_dataset[$i]["fullname"]));
                    $status = strtoupper(htmlspecialchars($user_dataset[$i]["status"]));
                    $email = htmlspecialchars($user_dataset[$i]["email"]);
                    $phone = strtoupper(htmlspecialchars($user_dataset[$i]["cell number"]));
                    $access_level = strtoupper(htmlspecialchars($user_dataset[$i]["access level"]));

                    switch ($access_level) {

                        case AccessLevels::LECTURER:
                            $access_level = "Teacher";
                            break;

                        case AccessLevels::STUDENT_MANAGER:
                            $access_level = "Student Records";
                            break;

                        case AccessLevels::PRINCIPAL:
                            $access_level = "Principal";
                            break;

                        case AccessLevels::ADMINSTRATOR:
                            $access_level = "Admin";
                            break;

                        case AccessLevels::SINGLE_USER:
                            $access_level = "Single mode";
                            break;

                        default:
                            $access_level = "no access";
                            break;
                    }

                    $table_ui .="<tr id='user_$username'>";
                    $table_ui .="<td class='bold'>$username</td>";
                    $table_ui .="<td>$fullname</td>";

                    if ($access_level != "no access") {
                        $table_ui .="<td><span class='status-badge badge badge-success'>active</span></td>";
                    } else {
                        $table_ui .="<td><span class='status-badge badge badge-danger'>inactive</span></td>";
                    }

                    if ($access_level_num != AccessLevels::LEVEL_SINGLE_MODE) {
                        $table_ui.="<td><div class='btn-group'>
              <button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'><span class='level-txt'>$access_level</span><span class='caret'></span></button>
              <ul class='dropdown-menu' role='menu'>
                <li onclick ='changeAcessLevel(\"$username\", 1);'><a>Teacher</a></li>
                <li onclick ='changeAcessLevel(\"$username\", 2);'><a>Student Records</a></li>
                <li onclick ='changeAcessLevel(\"$username\", 3);'><a>Principal</a></li>
                <li onclick ='changeAcessLevel(\"$username\",4);'><a>Admin</a></li>
                <li onclick ='changeAcessLevel(\"$username\", 0);'><a>Deny Access</a></li>
              </ul>
            </div></td>";
                    }

        if ($access_level == "Teacher" || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {
            $subject_edit_ui = "<li><a href='teacher_classes.php?tr_id=$teacher_id'><span class='typcn typcn-edit'></span>Manage Classes</a></li>";
                    } else {
                        $subject_edit_ui = "";
                    }

                    $table_ui .="<td>$email</td>";
                    $table_ui .="<td>$phone</td>";
                    $table_ui.="<td><div class='btn-group ft'>
              <button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'><span class='typcn typcn-cog cool-cog'><strong>more</strong></span><span class='caret'></span></button>
              <ul class='dropdown-menu' role='menu'>
                
<li onclick='removeUserDialog(\"$username\")'><a><span class='typcn typcn-trash'></span>Remove</a></li>
                <li onclick='resetPassword(\"$username\")'><a><span class='typcn typcn-eject'></span>Reset Password</a></li>";
                    $table_ui.= $subject_edit_ui . "
              </ul>
            </div></td>";
                    $table_ui .="</tr>";
                }

                $table_ui.="</table>";
                echo($table_ui);
            }
            ?>
        </div>
    </div>

</div>
<?php
include_once VIEWS_FOLDER . '/add_user.php';
?>


<!--manage class allocation-->
<div id="overlay" onclick='$("#overlay,#class-mgt").fadeOut(500);'></div>
<div class="panel panel-primary dialog col-lg-11  no-padding nope absolute" id="class-mgt">

    <div class="progress progress-striped active nope" id="class-progress">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        </div>
    </div>

    <div id="working-area">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Class Allocator</strong>
                <button class='btn btn-default btn-sm right' onclick='$("#overlay,#class-mgt").fadeOut(500);'>close</button></h3>

        </div>
        <div class="panel-body">
            <div class="col-lg-12" id="tr-subjects">
                <div class="cool-box">
                    <h4 class="text-muted text-center">No teacher chosen</h4>
                </div>
            </div>
        </div>

        <div class="panel-heading panel-bottom">
            <button class='btn btn-default' onclick='$("#overlay,#class-mgt").fadeOut(500);'>close</button>
        </div>
    </div>


</div>



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
<script src="../ajax/user_writer.js"></script>
<script src="../ajax/allocator.js"></script>

<script>
                $(function () {
                    $(".selecter_1").selecter();

                });
</script>


</body>
</html>
