<?php
if (is_dir("install")) {
    header("location:install");
    die();
}
require_once __DIR__ . "/logic/Config.php" ;
require_once "logic/AccessManager.php" ;
@session_start() ;

if(Aculyse\AccessManager::isSessionValid() == TRUE) {
    $home_page = $_SESSION["user"]["access_level"]["home"] ;
    header("location:$home_page") ;
    die() ;
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

        <title>aculyse | create an account</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->

        <link href="assets/css/master.css" rel="stylesheet">
        <link href="assets/css/signin.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="assets/fonts/icons/typicons.min.css" rel="stylesheet">

    </head>

    <style>
        .logo {
            margin-bottom: 0px;
        }
        .form-signin{
            margin-top: 1%;
        }
    </style>
    <body>
        <div class="col-md-12 clear-fix no-float nope full full-progress" id="progress-el">
            <h1 class="centered logo pulse xl">acu<span class="light">lyse</span></a></h1>
            <center>
                <img src="icons/144/webcam-144.png"/>

                <h3>Creating your account please wait!</h3>
            </center>

        </div>
        <div class="container" id="login-el">

            <h1 class="centered logo pulse">acu<span class="light">lyse</span></a></h1>

            <form class="form-signin relative clear-fix no-float" role="form">
                <section id="signup-el">
                    <p class="text-center bold">Please fill in the details to get started.</p>

                    <div>
                        <div class="ui horizontal divider text-danger bold">personal details</div>

                        <p>
                        <div class="input-group">
                            <span class="input-group-addon typcn typcn-user"></span>
                            <input type="text" class="form-control" id="fullname" placeholder="fullname" required autofocus/>
                        </div>

                        </p>

                        <p>
                        <div class="input-group">
                            <span class="input-group-addon typcn typcn-mail"></span>
                            <input type="email" class="form-control" id="email"  placeholder="email address" required />
                        </div>
                        <p>
                        <p>
                        <div class="input-group ">
                            <span class="input-group-addon typcn typcn-business-card"></span>
                            <input type="email" class="form-control has-success" id="username"  placeholder="desired username" required />
                            <!--<span class="typcn typcn-tick  input-ok"></span>-->
                        </div>
                        <p>
                        <div class="input-group">
                            <span class="input-group-addon typcn typcn-lock-closed"></span>
                            <input type="password" class="form-control" id="password"  placeholder="Password" required />

                        </div>
                        </p>

                        <?php if (!isset($_GET["single"])): ?>


                        <div class="ui horizontal divider text-danger bold">school details</div>

                        <p>
                        <div class="input-group">
                            <span class="input-group-addon typcn typcn-lock-closed"></span>
                            <input type="text" class="form-control" id="sch-name"  placeholder="school name" required />

                        </div>
                        </p>
                        <p>
                        <div class="input-group">
                            <span class="input-group-addon typcn typcn-location-arrow"></span>
                            <select class="form-control" id="sch-type"  required>
                                <option>Primary School</option>
                                <option>High School</option>
                                <option>Private college</option>
                                <option>Training facility</option>
                                <option>other</option>
                            </select>

                        </div>
                        </p>
                        <div class="col-lg-12 no-padding">
                            <div class="list-group" id="errors-box">
                            </div>
                        </div>
                        <?php endif; ?>
                        <br/>
                        <button class="btn btn-danger btn-block" type="button" onclick="School.save();">Create school account</button>
                        <br/>
                        <a href="index.php">Already have an account</a>

                    </div>
                </section>

            </form>

        </div>

        <script src="js/jquery-1.11.0.js"></script>
        <script src="ajax/school_mgr.js"></script>
        <script src="ajax/auth.js"></script>
        <script src="js/jquery.msgbox.js"></script>
        <script src="js/trans.js"></script>
        <script src="js/master.js"></script>
        <script src="js/jquery.msgbox.js"></script>
        <script type="text/javascript">
                            $("#username").blur(function() {
                                School.checkAvailiability();
                            });
        </script>
    </body>
</html>
