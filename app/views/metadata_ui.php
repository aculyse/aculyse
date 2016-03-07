<?php
require_once "../logic/AccessManager.php" ;
@session_start() ;
if(Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:index.php") ;
    die() ;
}

//session is valid lets check the access level on level 4 is allowed, from more details check AccessLevels class
if($_SESSION["user"]["access_level"]["right"] != Aculyse\AccessLevels::LEVEL_WRITE_ANALYTICS) {
    header("location:index.php") ;
    die() ;
}
//grant immutable subject data
require_once '../logic/UserIdentifier.php' ;
$UserIdentifier = new Aculyse\UserIdentifier() ;
$subjects = $UserIdentifier->lecturerSubjects() ;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Aculyse | Profiler Metadata</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstro.css" rel="stylesheet">
        <link href="css/master.css" rel="stylesheet">

        <link rel="stylesheet" href="fonts/simpleicon-education/flaticon.css" type="text/css"/>
        <link rel="stylesheet" href="fonts/simpleicon-business/flaticon.css" type="text/css"/>
        <link rel="stylesheet" href="fonts/icons/typicons.min.css"  type="text/css"/>
        <!-- Custom styles for this template -->
        <link href="css/dashboard.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.11.0.js"></script>


    </head>

    <body>
        <?php
       require_once './includes/navigation.php' ;
        require_once "logic/ProfileMetadata.php";
        ?>


        <div class="container-fluid">
            <div class="row">
                <?php
               require_once './includes/side_bar.php' ;
                require_once './logic/Report.php' ;
                ?>

                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <?php

                    $ProfileMetadata = new \Aculyse\ProfileMetadata();

                    $profile_id = $_GET["pid"];
                    $profile_hash = $_GET["phash"];
                    $secret_hash = sha1(SALT.$profile_id);


                    if($secret_hash !== $profile_hash){

                        require_once "includes/no_metadata.php";
                        die();
                    }

                    $result = $ProfileMetadata->get($profile_id);
                    



                    if(is_array($result)){
                        $table = "<table>";
                        $table .= "<thead>";
                        $table .= "<th class='col-lg-1'>Test #</th>";
                        $table .= "<th class='col-lg-2'>Title</th>";
                        $table .= "<th class='col-lg-5'>Description</th>";
                        $table .= "<th class='col-lg-4'>Scope</th>";
                        $table .= "</thead>";
                        $table .= "<tbody>";
                        
                        for ($i=0; $i < sizeof($result); $i++) { 

                            $test_num = $result[$i]["test_num"];
                            $title =  $result[$i]["name"];
                            $description = $result[$i]["description"];
                            $scope = $result[$i]["scope"];
                            $comment = $result[$i]["comment"];

                            
                            $table .= "<tr>";
                            $table .= "<td>$test_num</td>";
                            $table .= "<td>$title</td>";
                            $table .= "<td>$description</td>";
                            $table .= "<td>$scope</td>";
                            $table .= "</tr>";
                        }
                        $table .= "</tbody>";
                        $table .= "</table>";

                        print_r($table);
                    }
                    else{
                        require_once "includes/no_metadata.php";
                    }

                ?>
                </div>
            </div>
        </div>
        <?php
        include_once 'includes/footer.php' ;
        ?>

        <script src="ajax/profiler.js"></script>
        <script src="js/common.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="ajax/student_reader.js"></script>
        <script src="ajax/section_loader.js"></script>
        <script src="js/jquery.msgbox.js"></script>
        <script src="js/master.js"></script>
        <script src="js/jquery.fs.stepper.min.js"></script>
        <script src="js/trans.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/excellentexport.min.js"></script>
        <script src="js/bootstro.js"></script>
        <script>
                                            $(function() {
                                                $(".selecter_1").selecter();
                                                $('#student-list-table').dataTable({
                                                    "order": [[6, "desc"]],
                                                    'iDisplayLength': 50,
                                                    "language": {
                                                        "lengthMenu": "Display _MENU_ records per page",
                                                        "info": "Showing page _PAGE_ of _PAGES_"
                                                    }
                                                });
                                                bootstro.start(".tour");
                                            });
        </script>


        
    </body>
</html>

