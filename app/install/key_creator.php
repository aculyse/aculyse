<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Aculyse Installer</title>
        <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
            <link href="../assets/css/master.css" rel="stylesheet"/>
                <link href="../assets/dist/css/font-awesome.min.css" rel="stylesheet"/>
                    <link href="../assets/fonts/icons/typicons.min.css" rel="stylesheet"/>
                        </head>
                        <body>
                             <h3 class="text-center"><span class="logo"><span style="color:#777">acu</span><span class="light">lyse</span></span></h3>

                            <br>
                                <div class="col-lg-6 col-lg-offset-3 panel">
                                     <?php
                                    require_once "logic/Schema.php";


                                        $Schema = new Schema();
                                        if ($Schema->runKeys()):
                                          ?>
    <p></p><h2>Error creating database keys</h2>
<p>We were able to connect to the database server (which means your username , password and database is okay). Try the following:</p>
<ul>
<li>Refresh the page, this done usually by pressing F5 or Ctrl+R</li>
</ul>
<p>This usually solves the problem. If you get stuck on this stage plase check log at <code>logs/install.log</code></p>

                                    <?php 
                                    die();
                                    endif;
                                    ?>

                                    <p></p><h2>Everything alright!!</h2>
                                    <p>All right, sparky! You’ve made it through the installation. Create your School account and you are good to go!</p>


                                    
                                    ?>
                                    <a href="../finalise_install" class="btn btn-action btn-block btn-lg lighter">Finish</a>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>
                                     <small class="text-bold text-gray text-centered">&copy; Blessing Mashoko and Contributors</small>
                        
                                </div>
                               </body>
</html>
