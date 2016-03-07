<?php

namespace Aculyse;

//require_once "../../vendor/autoload.php";

@session_start();

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
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle nope" onclick="showSideBar();">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand logo"  href="<?php echo $user_root_page ?>">acu<span class='light'>lyse</span><sup>demo</sup></a>
        </div>

        <ul class="nav navbar-nav navbar-right navbar-collapse collapse">

            <li><a href="course_list.php"><span class="typcntypcnn-chart-bar"></span>Courses</a></li>

            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='typcntypcn-contacts'></span>Hello! <b><?php echo $_SESSION["user"]["id"] ?></b><span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="drop">
                    <li  onclick="getDialog('security');"><a href="#"><span class="typcntypcnn-lock-open"></span>Security</a></li>
                    <li><a href="help" target="blank"><span class="typcntypcnn-puzzle"></span>Help</a></li>
                    <li onclick="getDialog('feedback_form');"><a href="#"><span class="typcntypcnn-flag-outline"></span>Feedback</a></li>
                    <li onclick="getDialog('about');"><a href="#"><span class="typcntypcnn-info-large"></span>About</a></li>
                    <li><a href="tc" target="blank"><span class="typcntypcnn-document"></span>Terms and Conditions</a></li>

                </ul>
            </li>

            <li><button type="button" class="btn btn-action bold navbar-btn" onclick="logout();">Sign out</button></li>
        </ul>

        <div id="loading">
            <center><img src="loader.gif"></center>
            <p id="text">Please wait...</p>
        </div>
    </div>
    <?php
//check if account is still valid
    $account_type = $_SESSION["user"]["school info"]["account_type"];

    if ($account_type == 0 && $access_level_num == AccessLevels::LEVEL_ADMIN_ONLY) {
        echo "<div class='bg-danger overdue'>Your school account is not registered yet, contact us on email support@aculyse.com</div>";
    }
    ?>
</div>

<script src="ajax/feedback.js"></script>
