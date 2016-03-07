<?php

namespace Aculyse;

use Aculyse\Guardian\Auth\Auth;

require_once "../../vendor/autoload.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>aculyse | guardian invitation handler</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="../assets/css/master.css" rel="stylesheet">
    <link href="../assets/css/signifvn.css" rel="stylesheet">
    <link href="../assets/css/animate.css" rel="stylesheet">
    <link href="../assets/fonts/icons/typicons.min.css" rel="stylesheet">

</head>

<body>
<div class="col-md-12 clear-fix no-float nope full full-progress" id="progress-el">

    <h1 class="centered logo pulse xl">acu<span class="light">lyse</span></a></h1>
    <center>
        <img src="../assets/big_loader.gif"/>

        <h3>Verifying your identity, please wait</h3>
    </center>

</div>
<div class="container" id="login-el">
    <h1 class="centered logo pulse">acu<span class="light">lyse </span>parents</a></h1>
    <?php

    if(!isset($_GET["finish"])):
    ?>

    <form class="form-signin relative clear-fix no-float col-lg-4 col-lg-offset-4" action="executers/signup.php" method="POST">
        <div class="panel panel-primary">
            <div class="panel-heading">Invitation Signup</div>


            <div class="panel-body">

                <div class="absolute">
                    <p>
                    <input type="hidden" value="1" name="stage">
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-phone"></span>
                        <input type="text" class="form-control" name="username" placeholder="Email or Phone number" required  autofocus/>
                    </div>
                    </p>

                    <p>
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-pin"></span>
                        <input type="text" class="form-control" name="invitation_code" placeholder="Invitation code" required/>
                    </div>
                    </p>


                </div>
            </div>

            <div class="panel-footer">
                <input type="submit" class="btn btn-action btn-block bold" name="login" value="Next">
            </div>
        </div>

    </form>


    <?php
    endif;
    if(isset($_GET["finish"])):
    ?>
    <form class="form-signin relative clear-fix no-float col-lg-4 col-lg-offset-4" action="executers/signup_finish.php" method="POST">
        <div class="panel panel-primary">
            <div class="panel-heading">Create account</div>


            <div class="panel-body">

                <div class="absolute">
                    <p>
                        <input type="hidden" value="2" name="stage">
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-phone-outline"></span>
                        <input type="text" class="form-control" name="name" placeholder="Your Fullname" required  autofocus/>
                    </div>
                    </p>

                    <p>
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-lock-closed-outline"></span>
                        <input type="text" class="form-control" name="password" placeholder="Desired Password" required/>
                    </div>
                    </p>

                </div>
            </div>

            <div class="panel-footer">
                <input type="submit" class="btn btn-action btn-block bold" name="login" value="Finish">
            </div>
        </div>

    </form>
    <?php
        endif;
    ?>
</div>


<script src="js/jquery-1.11.0.js"></script>
<script src="ajax/auth.js"></script>
<script src="js/jquery.msgbox.js"></script>
<script src="js/trans.js"></script>
<script src="js/master.js"></script>
</body>
</html>
