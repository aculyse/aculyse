<?php
require_once "logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
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

        <title>Resource not found | Error400</title>

                        <!-- Bootstrap core CSS -->
                        <link href="../assets/css/bootstrap.css" rel="stylesheet">
                        <link href="../assets/css/master.css" rel="stylesheet">
                        <link rel="stylesheet" href="../assets/fonts/icons/typicons.min.css"  type="text/css"/>
                        <!-- Custom styles for this template -->
                        <link href="../assets/css/dashboard.css" rel="stylesheet">
        <style type="text/css">
            body{
                background: #fff !important;
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
            <h3>Oops! Aculyse could not handle your request (Bad Request)</h3>
            <br/><br/><br/>
            <div class="col-lg-6 col-lg-offset-3">

                <a href="<?php echo $home ?>" class="btn btn-action btn-md"><span class="typcn typcn-home"></span>Go to Home Page</a>

            </div>
            <div class="col-lg-12">
                <p class="filler">Oops! We could not locate the page you requested</p>
            </div>
        </div>
    </body>
</html>
