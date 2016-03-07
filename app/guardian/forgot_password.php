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
<div class="container" id="login-el">
    <h1 class="centered logo pulse text-navy">acu<span class="light">lyse </span>parents</a></h1>

        <form class="form-signin relative clear-fix no-float col-lg-4 col-lg-offset-4" action="executers/signup.php" method="POST">
            <div class="panel panel-primary">
                <div class="panel-heading">Forgot Password</div>


                <div class="panel-body">

                    <div class="absolute">
                        <p>
                        <div class="input-group">
                            <span class="input-group-addon typcn typcn-phone"></span>
                            <input type="text" class="form-control" name="username" placeholder="Email or Phone number" required  autofocus/>
                        </div>
                        </p>


                    </div>
                </div>

                <div class="panel-footer">
                    <input type="submit" class="btn btn-action btn-block bold" name="login" value="Get password">
                </div>
            </div>

        </form>
</div>


<script src="js/jquery-1.11.0.js"></script>
<script src="ajax/auth.js"></script>
<script src="js/jquery.msgbox.js"></script>
<script src="js/trans.js"></script>
<script src="js/master.js"></script>
</body>
</html>
