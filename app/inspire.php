<?php

namespace Aculyse;

require_once '../vendor/autoload.php';
@session_start() ;
if(AccessManager::isSessionValid() == FALSE) {
    header("location:index.php") ;
    die() ;
}

//user home page
$home = $_SESSION["user"]["access_level"]["home"] ;
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

        <title>Aculyse Inspiration</title>
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->

        <link href="assets/css/master.css" rel="stylesheet">
        <link href="assets/css/animate.css" rel="stylesheet">
        <link href="assets/fonts/icons/typicons.min.css" rel="stylesheet">
    </head>

    <body>
        <?php
        require_once './includes/navigation.php' ;
        ?>
        <br/><br/><br/><br/>

        <div id="warning" class="col-lg-12">
            <span class="typcn typcn-support xl freaking-big"></span>
            <h3 class="text-mute"><?php echo Inspire::quote(); ?></h3>
            <br/><br/><br/>


        </div>
    </body>
</html>
