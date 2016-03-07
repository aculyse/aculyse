<?php

namespace Aculyse;

require_once '../../vendor/autoload.php';

@session_start();
if (AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
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

        <title>Aculyse | Help Center</title>

        <!-- Bootstrap core CSS -->
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="../assets/fonts/icons/typicons.min.css"  type="text/css"/>
        <link href="../assets/css/master.css" rel="stylesheet">
        <link href="../assets/css/dashboard.css" rel="stylesheet">

        <style type="text/css">

            .sidebar{
                width:300px !important;
                position: relative;
                top:0px;
            }
            #copy{
                position: relative;
            }
            .list-group{
                font-size: 14px;
            }
            .panel-group .panel-heading .panel-title
            {
                color:#555;
                font-weight: bold !important;
            }
        </style>

    </head>

    <body>
        <?php
        require_once INCLUDES_FOLDER .  '/navigation.php';
        ?>

        <div class="jumbotron help-jumbotron">
            <h1 class="centered w">Aculyse Help Center</h1>
            <p class="centered w">Get the help you need here with these FAQs</p>

        </div>

        <div class="container-fluid">

            <div class="row col-lg-3 col-md-offset-1 ">
                <?php
                require_once INCLUDES_FOLDER .  './help_side_bar.php';
                ?>
            </div>

            <div class="row col-lg-8">
                <div>
                    <div id="content-container">
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once INCLUDES_FOLDER . '/footer.php';
        ?>
        <script src="../js/jquery-1.11.0.js"></script>
        <script src="../js/help.js"></script>
        <script src="../js/master.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
            loadHelpSection('help_views/profiling_tips.php')
        </script>



    </body>
</html>
