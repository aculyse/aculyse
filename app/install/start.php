<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Aculyse Installer</title>
        <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
        <link href="../assets/css/master.css" rel="stylesheet"/>
        <link href="../assets/dist/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="../assets/fonts/icons/typicons.min.css" rel="stylesheet"/>
        <style>
            .sublime{
                background: #444;
                color: #f9f9f9;

            }
        </style>

    </head>
    <body>
        <h3 class="text-center"><span class="logo"><span style="color:#777">acu</span><span class="light">lyse</span></span></h3>

        <br>
            <div class="col-lg-6 col-lg-offset-3 panel">
                <?php
                require_once "logic/Schema.php";
                require_once "logic/Environment.php";


                if (isset($_POST["installBTN"])) {

                    $server = $_POST["server"];
                    $user = $_POST["db_user"];
                    $password = $_POST["password"];
                    $root_url = $_POST["root_url"];
                    $database = $_POST["database"];

                    $config = [
                        "DB_TYPE" => "mysql",
                        "DB_SERVER" => $server,
                        "DB_USER" => $user,
                        "DB_PASSWORD" => $password,
                        "DB_NAME" => $database,
                        "PORT" => "3306",
                        "DOMAIN_NAME" => $root_url
                    ];

                    //create config file

                    if (!\Aculyse\Install\Environment::create($config) && !\Aculyse\Install\Environment::configFileExists()):
                        ?>
                        <h2>Error creating config.php file</h2>
                        <p>The configuration file could not be created. The following might be the possible cause</p>
                        <ul>
                            <li>The current user has no right to create files</li>
                        </ul>
                        <p>Don't worry though, just create a file with name <code>config.php</code> and paste in the code below and refresh the page:</p>

                        <code class="col-lg-12 well sublime">
                            <?php
                            echo htmlspecialchars("<?php")."<br/><br/>";
                            echo preg_replace("/define/", "<br/>define",(\Aculyse\Install\Environment::parseConfigs($config)));
                            ?>
                        </code>



                        <?php
                        die();
                    endif;
                    //test connection
                    $Schema = new Schema();

                    $can_connect = $Schema->testConnection($server, $user, $password);


                    if (!$can_connect):
                        ?>
                        <p>
                        </p><h2>Error establishing a database connection</h2>
                        <p>This either means that the username and password information is incorrect or we can't contact the database server at <code><?php echo $server ?></code>. This could mean your host's database server is down.</p>
                        <ul>
                            <li>Are you sure you have the correct username and password?</li>
                            <li>Are you sure that you have typed the correct hostname?</li>
                            <li>Are you sure that the database server is running?</li>
                        </ul>
                        <p>If you're unsure what these terms mean you should probably contact your host provider.</p>

                        <p></p><p class="step"><a href="installer.php" onclick="javascript:history.go(-1);
                                        return false;" class="btn btn-lg btn-action lighter btn-block">Try again</a></p>

                        <?php
                        $Schema;
                        die();
                    endif;


                    //test if databse instance is working

                    if (!$Schema->isDatabaseInstanceWorking($server, $user, $password, $database)):
                        ?>
                        <p></p><h2>Can’t select database</h2>
                        <p>We were able to connect to the database server (which means your username and password is okay) but not able to select the <code><?php echo $database ?></code> database.</p>
                        <ul>
                            <li>Are you sure it exists?</li>
                            <li>Does the user <code><?php echo $user; ?></code> have permission to use the <code><?php echo $database ?></code> database?</li>
                            <li>On some systems the name of your database is prefixed with your username, so it would be like <code>username_<?php echo $database; ?></code>. Could that be the problem?</li>
                        </ul>
                        <p>If you don't know how to set up a database you should <strong>contact your host</strong>. </p>


                        <p></p><p class="step"><a href="installer.php" onclick="javascript:history.go(-1);
                                        return false;" class="btn btn-lg btn-action lighter btn-block">Try again</a></p>



                        <?php
                        die();
                    endif;


                    //create tables
                    $Schema->run();

                    //create views
                    $Schema->run(true);

                    if (!$Schema->commitTables()):
                        ?>
                        <p></p><h2>Error creating database tables</h2>
                        <p>We were able to connect to the database server (which means your username , password and database is okay). Try the following:</p>
                        <ul>
                            <li>Make sure the database has no prior aculyse installations.</li>
                            <li>Use a different database</li>
                            <li>Refresh the page, this done usually by pressing F5 or Ctrl+R</li>

                        </ul>
                        <p>This usually solves the problem. If you get stuck on this stage plase check log at <code>logs/install.log</code></p>

                        <?php
                        die();
                    endif;
                }
                ?>

                <p></p><h2>Database Created successfully</h2>
                <p>All right, sparky! You’ve made it through this part of the installation. Aculyse can now communicate with your database. If you are ready, lets finish this installation now</p>
                <a href="key_creator.php" class="btn btn-action btn-block btn-lg lighter">Next Step</a>
                <br/>
                <br/>
                <br/>
                <br/>
            </div>
            <small class="text-bold text-gray text-centered">&copy; Blessing Mashoko</small>
    </body>
</html>
