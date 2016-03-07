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

        <title>Error 403 | Prohibited</title>


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

        <section class="content">

            <div class="error-page">
                <h2 class="headline text-danger"><img src="assets/icons/144/disclaimer-144.png"/></h2>
                <div class="error-content">
                    <h3><i class="fa fa-warning text-red text-justified"></i> Oops! You just hit a road block.</h3>
                    <p>
                        We are sorry but the section you are trying to access is restricted. You may have landed on this section by accident or a broken link. Please click the button below to go back to your home page.
                      </p>
                      <p>
                        <a class="btn btn-action btn-block" href="index.php">return to home page</a>.
                    </p>

                </div>
            </div><!-- /.error-page -->

        </section>
    </body>
</html>
