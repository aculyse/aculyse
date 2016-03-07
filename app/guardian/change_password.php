<?php

namespace Aculyse;

use Aculyse\Guardian\Auth\Session;
use Aculyse\UI\HTML;
use Aculyse\Guardian\Guardian;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once "../../vendor/autoload.php";

@session_start();

//check if user is allowed
Auth::isAllowed([
    AccessLevels::LEVEL_GUARDIAN
], TRUE
);

HTML::header("Aculyse | Student Profile Analysis");
?>
<div class="col-lg-12 no-print">
    <h1 class="text-danger lighter">Security</h1>
    <h5>Change your password regularly, to make it more secure</h5>
</div>
<form method="POST" action="executers/change_password.php">
    <div class="panel panel-primary col-lg-4 col-lg-offset-1 no-padding" style="margin-left: 1% !important;">
        <div class="panel-heading">
            <h3 class="panel-title">Change Password</h3>
        </div>
        <div class="panel-body">

            <?php
            if (isset($_GET["code"])) {
                $message = "";
                switch ($_GET["code"]) {

                    case "100":
                        $message = "Fill in all the fields";
                        $type = "danger";
                        break;

                    case "101":
                        $message = "Passwords do not match!";
                        $type = "danger";
                        break;

                    case "102":
                        $message = "Password length should be at least characters!";
                        $type = "danger";
                        break;

                    case "103":
                        $message = "Password changed successfully";
                        $type = "success";
                        break;

                    case "104":
                        $message = "Unknown response";
                        $type = "warning";
                        break;
                }

                echo "<div class='alert alert-$type text-bold'>$message</div>";
            }
            ?>

            <div class="input-box col-lg-12">
                <label class="labels">New Password</label>
                <input type="password" class="input" name="new_password" placeholder="new password"/>
            </div>
            <div class="input-box col-lg-12">
                <label class="labels">Confirm New Password</label>
                <input type="password" class="input" name="confirm_new_password" placeholder="confirm new password"/>
            </div>

        </div>
        <div class="panel-heading panel-bottom">
            <input type="submit" class="btn btn-action btn-block" value="Change Password"/>
        </div>
</form>
</div>


<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>

</body>
</html>
