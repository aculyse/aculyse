<?php

use Aculyse\Install;
use Aculyse\Install\Environment;

require_once dirname(dirname((__DIR__))) . "/vendor/autoload.php";
?>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Aculyse Installer</title>
        <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
        <link href="../assets/css/master.css" rel="stylesheet"/>

        <link href="assets/css/install.css" rel="stylesheet"/>
        <link href="../assets/dist/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="../assets/fonts/icons/typicons.min.css" rel="stylesheet"/>
        <style>
            .logo, .logo *{
                font-size: 60px;
            }
        </style>
    </head>
    <body>
        <?php
        //set the application root url
       $roots = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"];

        $ex = explode('/', $_SERVER['REQUEST_URI']);
    
        $url_paths="";
        for ($i=0; $i < sizeof($ex)-2 ; $i++) { 
                $url_paths = "/".$ex[$i];
        }

        $application_url = $roots.$url_paths;
        
        ?>
        <div class="jumbotron help-jumbotron">
            <h2 class="text-center"><span class="logo"><span>acu</span><span class="light">lyse</span></span></h2>

        </div>
         <form class="form-signin relative clear-fix no-float col-lg-6 col-lg-offset-3" action="start.php" method="POST">
            
            <div class="panel panel-primary">

                <div class="panel-body">
                    <div class="alert alert-default text-bold">
                Below you should enter your database connection details. If you’re not sure about these, contact your host
            </div>
                    <?php
                    if (!Environment::isPhpVersionOk()) {
                        die("<div class='alert alert-warning text-bold'>PHP version should be at least " . Install\MINIMUM_PHP_VERSION . "</div>");
                    }
                    ?>
                    <label>Database Host</label>
                    <div class="input-group">

                        <span class="input-group-addon typcn typcn-device-laptop"></span>
                        <input type="text" class="form-control " name="server" placeholder="Database Address" required autofocus value="127.0.0.1"/>
                    </div>
                    <p></p>

                    <label for="address">Username</label>
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-user"></span>
                        <input type="text" class="form-control " name="db_user" placeholder="Database User" required autocomplete="off"/>
                    </div>
                    <p></p>

                    <label for="address">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-pin"></span>
                        <input type="password" class="form-control " name="password" placeholder="Database Password" required autocomplete="off"/>
                    </div>
                    <p></p>

                    <label for="address">Database Name</label>
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-database"></span>
                        <input type="text" class="form-control " name="database" placeholder="Database Name" required value="aculyse"/>

                    </div>
                    <p></p>

                    <label for="address">Application Domain</label>
                    <div class="input-group">
                        <span class="input-group-addon typcn typcn-link"></span>
                        <input type="url" class="form-control " name="root_url" value="<?php echo $application_url; ?>" placeholder="Domain e.g IP address or domain name"
                               required/>

                    </div>
                    <p></p><br/>
                    <input type="submit" class="btn btn-action bold" name="installBTN" value="Install">

                </div>


            </div>

        </form>
        <center>
            <h5 class="text-center ">Copyright &copy; Blessing Mashoko and Contributors</h5>
        </center>
    </body>
</html>
