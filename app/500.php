<?php
require_once "logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:index.php") ;
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
        <link rel="icon" href="../../favicon.ico">

        <title>500 | Server Internal Error </title>

                        <!-- Bootstrap core CSS -->
                        <link href="../assets/css/bootstrap.css" rel="stylesheet">
                        <link href="../assets/css/master.css" rel="stylesheet">
                        <link rel="stylesheet" href="../assets/fonts/icons/typicons.min.css"  type="text/css"/>
                        <!-- Custom styles for this template -->
                        <link href="../assets/css/dashboard.css" rel="stylesheet">
        <style type="text/css">
            body{
                background: #fff !important;
                //font-family: '28 Days Later' !important;
            }

            #warning .btn .typcn{
                font-size: 12px !important;
            }
        </style>
    </head>

    <body>
        <?php
        require_once './includes/navigation.php' ;
        ?>
        <br/><br/><br/><br/>

        <div id="warning" class="col-lg-12">
            <span class="typcn typcn-info xl freaking-big"></span>
            <h1>Oops! Aculyse could not process your request because there was a problem with the server configuration but we are looking into it.</h1>

            <br/><br/><br/>
            <div class="col-lg-6 col-lg-offset-3">
                <button class="btn btn-danger btn-md"><span class="typcn typcn-arrow-back"></span>Go to previous page</button>
                <button class="btn btn-action btn-md"><span class="typcn typcn-home"></span>Go to Home Page</button>
                <button class="btn btn-warning btn-md"><span class="typcn typcn-home"></span>Report this as error</button>

            </div>
            <div class="col-lg-12">

                <p class="filler">Oops! Aculyse could not process your request because there was a problem with the server configuration but we are looking into it.</p>
            </div>
        </div>
    </body>
</html>
