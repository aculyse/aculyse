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
    </head>
    <body>

        <div class="jumbotron help-jumbotron">
        	<h2 class="text-center"><span class="logo"><span>acu</span><span class="light">lyse</span></span></h2>

        </div>
        
        <div class="col-lg-6 col-lg-offset-3 well" style="background: #fff;font-size: 15px;">

            <p>Welcome to Aculyse. Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
            <ol>
                <li>Database name</li>
                <li>Database username</li>
                <li>Database password</li>
                <li>Database host</li>
                <li>Domain or IP address</li>
            </ol>
            <p>
                We’re going to use this information to create a <code>config.php</code> file.	<strong>If for any reason this automatic file creation doesn’t work, don’t worry. All this does is fill in the database information to a configuration file. You may also simply open <code>.env</code> in a text editor, fill in your information, and save it.</strong>
                Need more help? <a href="help/env.html" target="blank">Click here, We got it</a>.</p>
            <p>In all likelihood, these items were supplied to you by your Web Host. If you do not have this information, then you will need to contact them before you can continue. If you’re all ready…</p>

            <a href="installer.php" class="btn btn-action btn-block btn-lg lighter">Start Installing!!</a>
             <br/>
                                    <br/>
                                     <small class="text-bold text-centered">&copy; Blessing Mashoko and Contributors</small>
                        
        </div>
        
    </body>
</html>
