
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Aculyse Manual Installation Instructions</title>
        <link href="../../assets/css/bootstrap.css" rel="stylesheet"/>
        <link href="../../assets/css/master.css" rel="stylesheet"/>
        <link href="../assets/css/install.css" rel="stylesheet"/>
        <link href="../../assets/dist/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="../../assets/fonts/icons/typicons.min.css" rel="stylesheet"/>
        <style>
            body,html{
                padding: 0 !important;
                margin: 0 !important;
            }
            .jumbotron{
                background: rgb(48, 118, 153) !important;
                margin: 0% -1% -3%;

            }
            .jumbotron *{
                border: none;
            }
        </style>
    </head>
    <body>

        <div class="jumbotron help-jumbotron">
            <h1 class="centered w">Aculyse Manual Installation</h1>

        </div>

        <div class="col-lg-10 col-lg-offset-1 well" style="background: #fff;font-size: 15px;">

            <h1>Getting started</h1>

            <p>Manual setup is not advised as it may create unstable installations as they require someone with some technical knowledge Use this as last resort.</p>
            <p>We believe that security is important for this application to be useful to you. Before installing this application make sure that the following security and environment requirements are met:</p>
            <ol>
                <li>The root folder of the application is <code>{path to application}/app</code> only <b>(VERY IMPORTANT !!!)</b></li>
                <li>At least <b>PHP version 5.6.3 is installed</b></li>
                <li>At least <b>MySQL Server version 5.6.21 is installed</b></li>
                <li>At least 100 MB hard drive space</li>
            </ol>


            <h1>The config.php file</h1>
            <p>The config.php file contains the information required for the application to connect to the database. This information consists
                of the following</p>

            <ol>
                <li>Database Host</li>
                <li>Database Name</li>
                <li>Username</li>
                <li>Password</li>
                <li>Application Host</li>
            </ol>

            <p><b class="text-danger">This information is highly sensitive and can cause an obvious BLEACH OF SECURITY, therefore should not be put in publicly available place. So make sure only the &quot;app &quot; folder is served NOTHING else!!</b></p>

            <h1>Creating config.php file</h1>
            <p>To create a valid config.php file follow these steps</p>
            <ol>
                <li>Find a file called <code>config.php</code></li>
                <li>Fill in the following details:
                    <ul>
                        <li>Database Host</li>
                        <li>Database Name</li>
                        <li>Username</li>
                        <li>Password</li>
                        <li>Application Host</li>
                    </ul>
                </li>
               
                <li>Create database </li>

            </ol>

            <h4>Example::</h4>
            <p>Lets say you want to install having the following required information</p>
            <ul>
                <li>Database Host => "localhost"</li>
                <li>Database Name => "aculyse"</li>
                <li>Username => "root"</li>
                <li>Password => "password"</li>
                <li>Application Host =>"http://school.org</li>
            </ul>

            <p>The config.php file will look as below</p>

            <code class="col-lg-12 well sublime">
                <?php
                    echo htmlspecialchars("<?php");
                ?>
                <br/><br/>
                define("DB_TYPE","mysql");<br/><br/>

                define("DB_SERVER","localhost");<br/>
                define("DB_USER","root");<br/>
                define("DB_PASSWORD","password");<br/>
                define("DB_NAME","aculyse");<br/>
                define("PORT","3306");<br/><br/>

                define("DOMAIN_NAME","http://school.org");<br/>

            </code>


            <!-- create database -->
            <h1>Creating Database Tables</h1>
            <ol>
                <li>Navigate to the folder <code>{path to aculyse}/app/install/database</code></li>
                <li>Go to your MySQL database and create a database with the <u><b>SAME NAME</b></u> as the one you wrote in the config.php file </li>
                <li>Import the database file <code>database.sql</code> found in folder mentioned in step 1 into the database</li>
                <li>Delete the folder <code>{path to aculyse}/app/install</code></li>
                <li>Navigate the URL you specified as your <code>DOMAIN_NAME</code> in the config.php file</li>
                <li>Create school account</li>
                <li>You are good to GO!!</li>

            </ol>

        </div>
        <div class="col-lg-12">
            <h5 class="text-center">Was this helpful please give your feedback on support@aculyse.com</h5>
            <br/><br/><br/>

            <h5 class="text-center text-bold">&copy; Blessing Mashoko and Contributors</h5>
        </div>
    </body>
</html>
