<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;
use Aculyse\Billing\Billing;

require_once "../../vendor/autoload.php";
@session_start();
if (AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
    die();
}

Auth::isAllowed([
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_READ_STUDENTS_ONLY,
    AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
]);
HTML::header("Aculyse | Activate License");
?>

<div class="col-lg-12  no-print">
    <h1 class="text-danger lighter">Activate a licence</h1>
</div>


<div class="col-lg-6">


    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
				Enter License keys
            </div>
        </div>

        <div class="panel-body">
            <form id="register-student-form" method="post" action="#">


                    <?php
                    if(isset($_POST["activateBTN"])){

                    $licence_key = $_POST["licence_key"];
                    $pin_code = $_POST["pin_code"];

                    $bill = new Billing();
                    $valid_key = $bill->checkKey($licence_key, $pin_code);

                    if ($valid_key->count() == 1) {
                      if($bill->activate()){
                        echo "<div class='alert alert-success text-bold'>Activation successfully. Check you account for the new expiry date</div>";
                      }
                      else{
                        echo "<div class='alert alert-warning text-bold'>An error happened whilst activating the license keys. Please try again</div>";
                      }

                    }
                    else{
                      echo "<div class='alert alert-danger text-bold'>Activation key not found. Make sure you are entering the correct key combination</div>";
                    }
                  }
                    ?>
                    <div class="col-md-12 input-box">
                        <label class="labels no-padding">Licence Key</label>
                        <input type="text" maxlength="50"  name="licence_key" class="input" placeholder="XXXX-XXXX-XXXX-XXXX-XXXX">
                    <span class="help-block text-info text-bold">A 25 character key given to you through purchase email or installation media</span>
					</div>

					    <div class="col-md-12 input-box">

						</div>
					 <div class="col-md-12 input-box">
                        <label class="labels no-padding">PIN</label>
                        <input type="text" maxlength="4"  name="pin_code" class="input" placeholder="XXXX">
						  <span class="help-block text-info text-bold">A 4 digit PIN given to you through purchase email or installation media</span>

                    </div>






        </div>

		<div class="panel-footer">
		<input type="submit" name="activateBTN" class="btn btn-action btn-block" value="Activate"/>
		<button class="btn btn-default btn-block">Need help activating</button>
      </form>
		</div>


    </div>
</div>
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

</body>
</html>
