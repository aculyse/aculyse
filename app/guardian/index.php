<?php

namespace Aculyse;

use Aculyse\Guardian\Auth\Auth;

require_once "../../vendor/autoload.php";
@session_start();

if (AccessManager::isSessionValid() == TRUE) {
    $home_page = $_SESSION["user"]["access_level"]["home"];
    if (isset($_GET["first_time"])) {
        header("location:tour/general.php");
        die();
    }
    header("location:$home_page");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>aculyse | awesomeness inside</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="../assets/css/master.css" rel="stylesheet">
    <link href="../assets/css/signin.css" rel="stylesheet">
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
    <h3 class="centered ldogo pulse" style="color:#fff;">acu<span class="light">lyse </span>parents</a></h3>

    <form class="form-signin relative clear-fix no-float col-lg-4" action="executers/auth.php" method="POST">
        <section id="">
            <div id="cool-avatar">
                <center>
                    <img data-src="holder.js/200x200" class="img-thumbnail img-circle" src="../avatars/avatar1.png"
                         style="width: 120px; height: 120px;">
                </center>
            </div>
            <div class="absolute">
                <p>
                <div class="input-group">
                    <span class="input-group-addon typcn typcn-user"></span>
                    <input type="text" class="form-control" name="email" placeholder="Username or Email" required
                           autofocus/>
                </div>
                </p>

                <p>
                <div class="input-group">
                    <span class="input-group-addon typcn typcn-lock-closed"></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" required/>
                </div>
                </p>


                <input type="submit" class="btn btn-action btn-block bold" name="login" value="Sign In">
                <h4 class="text-center">OR</h4>
                <a href="forgot_password" class="btn btn-danger btn-block" role="button">Forgot password</a>

            </div>
        </section>

    </form>
</div>



<script src="js/jquery-1.11.0.js"></script>
<script src="ajax/auth.js"></script>
<script src="js/jquery.msgbox.js"></script>
<script src="js/trans.js"></script>
<script src="js/master.js"></script>
</body>
</html>
