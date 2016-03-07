<?php
namespace Aculyse;
require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";
use Aculyse\Billing\Billing;
use Aculyse\Helpers\Auth\ActiveSession;

@session_start();

/* * ******************************************
  AUTHENTICATION
 * ******************************************* */
if (AccessManager::isSessionValid() == FALSE) {
    header("location:../index.php");
    die();
}

$access_level_num = $_SESSION["user"]["access_level"]["right"];
$user_root_page = $_SESSION["user"]["access_level"]["home"];
$session_token = $_SESSION["user"]["transaction_token"];

//make token string to all javascript and any part site which needs it
echo "<input type='hidden'  id='universal-token' data-universal-token='$session_token' >";
?>
<header class="navbar navbar-inverse navbar-fixed-top main-header" role="navigation">

    <a class="navbar-brad logo" href="<?php echo $user_root_page ?>">
        <span class="logo-mini" class="sidebar-toggle" data-toggle="offcanvas">ACU</span>
        <span class="logo-lg">
        <span class='bold'>acu</span><span class='light'>lyse</span>
        </span>
    </a>

    <nav class="navbar navbar-static-top">

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php
                if ($access_level_num == AccessLevels::LEVEL_ADMIN_ONLY || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {
                    echo '<li><a href="../subscriptions">Subscription</a></li>';
                    echo '<li><a href="'.HOST_URL.'/admin/super?overview">Users</a></li>';
                    echo '<li><a href="subjects">Subjects</a></li>';
                }
                if ($access_level_num == AccessLevels::LEVEL_WRITE_STUDENTS || $access_level_num == AccessLevels::LEVEL_READ_STUDENTS_ONLY || $access_level_num == AccessLevels::LEVEL_UNIVERSAL_READ_ONLY || $access_level_num == AccessLevels::LEVEL_ADMIN_ONLY || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {

                    echo '<li><a href="dash?overview"><span class="typcntypcnn-chart-bar"></span>Students</a></li>';
                    if ($access_level_num == AccessLevels::LEVEL_WRITE_STUDENTS || $access_level_num == AccessLevels::LEVEL_ADMIN_ONLY || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {
                        echo '<li><a href="class_mgr"><span class="typcntypcnn-chart-bar"></span>Classes</a></li>';
                    }

                }
                ?>
                <?php
                if ($access_level_num == AccessLevels::LEVEL_READ_ANALYTICS_ONLY || $access_level_num == AccessLevels::LEVEL_WRITE_ANALYTICS || $access_level_num == AccessLevels::LEVEL_UNIVERSAL_READ_ONLY || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {

                    echo '<li><a href="analytics"><span class="typcntypcnn-chart-bar"></span>Analytics</a></li>';

                    if ($access_level_num == 4 || $access_level_num == AccessLevels::LEVEL_SINGLE_MODE) {

                        echo '<li><a href="profiler"><span class="typcntypcnn-calculator"></span>Profiler</a></li>';
                    }
                }

                //guardian links
                if ($access_level_num == AccessLevels::LEVEL_GUARDIAN):?>
                    <li><a href="index.php">Dependencies</a></li>
                <?php
                endif;

                ?>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                            class='typcntypcn-contacts'></span>Hello! <b><?php echo $_SESSION["user"]["id"] ?></b><span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop">
                        <li onclick="getDialog('security');"><a href="#"><span class="typcntypcnn-lock-open"></span>Security</a>
                        </li>
                        <li><a href="help" target="blank"><span class="typcntypcnn-puzzle"></span>Help</a></li>
                        <li onclick="getDialog('feedback_form');"><a href="#"><span
                                    class="typcntypcnn-flag-outline"></span>Feedback</a>
                        </li>
                        <li onclick="getDialog('about');"><a href="#"><span class="typcntypcnn-info-large"></span>About</a>
                        </li>
                        <li><a href="tc" target="blank"><span class="typcntypcnn-document"></span>Terms and
                                Conditions</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <button type="button" class="btn btn-action bold navbar-btn" onclick="logout();">Sign out</button>
                </li>
            </ul>
        </div>
        <div id="loading">
            <center><img src="../assets/loader.gif"></center>
            <p id="text">Please wait...</p>
        </div>
    </nav>
    <?php
    //check if account is still valid
    if ($access_level_num == AccessLevels::LEVEL_ADMIN_ONLY) {
        $account_type = $_SESSION["user"]["school info"]["account_type"];

        $Billing = new    Billing();
        $active_account = $Billing->getActiveSchoolSubscription();

        if ($active_account->count() == 0) {
            echo "<div class='bg-danger overdue'>Your school account is not registered yet, contact us on email support@aculyse.com</div>";
        }
    }
    ?>
</header>
