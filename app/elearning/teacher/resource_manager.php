<?php

namespace Aculyse;
use Aculyse\Elearning\Resources;


require_once "../../../vendor/autoload.php";

@session_start();
if (AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
    die();
}
$allowed_levels = array(
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_SINGLE_MODE);

$access_level_num = $_SESSION["user"]["access_level"]["right"];
if (!in_array($access_level_num, $allowed_levels)) {
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
        <link rel="icon" href="../../favicon.ico">

        <title>aculyse | Admin</title>

        <!-- Bootstrap core CSS -->
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/bootstro.css" rel="stylesheet">
        <link href="../../css/master.css" rel="stylesheet">
        <link rel="stylesheet" href="../../fonts/icons/typicons.min.css"  type="text/css"/>
        <!-- Custom styles for this template -->
        <link href="../../css/dashboard.css" rel="stylesheet">

    </head>

    <body>
        <?php
        require_once "../includes/header.php";
        ?>

        <div class="container-fluid">
            <div class="row">
                <?php
                // require_once './includes/side_bar.php' ;
                ?>
                <div class="col-lg-10 col-lg-offset-1 main">

                    <div class="col-lg-12">
                        <h1 class="text-danger lighter">Resource Manager</h1>
                        <h5>Manage learning materials available to students</h5>
                    </div>

                    <!--list of classes-->
                    <div class="col-lg-14 col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">

                     
                            </div>
                            <div class="panel-body no-padding">

                        <table>
                            <thead>
                            <th></th>
                            <th>Name</th>
                            <th></th>
                            </thead>
                            <tbody>
                                <?php
                        $Resources= new Resources();
                        $resource_list  = $Resources->getAll();
                                foreach ($resource_list as $item) :
                                    ?>
 <tr>
                                    <td></td>
                                    <td class="bold"><?php  echo $item->title ?></td>
                                    <td>
                                    	<a href="#editModal" class="btn btn-xs btn-action pull-right margin" data-toggle="modal" >edit</a>
                                    	<a href="resource.php?id=<?php  echo $item->id ?>" class="btn btn-xs btn-danger pull-right margin">delete</a>
                                    	<a href="resource.php?id=<?php  echo $item->id ?>" class="btn btn-xs btn-action pull-right margin">download</a>
                                    </td>
                                </tr>

                                <?php
                                endforeach;
                                ?>
                               
                            
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div id="editModal" class="panel panel-primary modal dialog col-lg-4 no-padding">
    <div class="panel-heading">
        <h3 class="panel-title">About</h3>
    </div>
    <div class="panel-body">
       <form class="form-horizontal">
<div class="control-group">
<label class="control-label" for="inputEmail">Email</label>
<div class="controls">
<input type="text input" id="inputEmail" placeholder="Email">
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword">Password</label>
<div class="controls">
<input type="password" id="inputPassword" placeholder="Password">
</div>
</div>
<div class="control-group">
<div class="controls">
<label class="checkbox">
<input type="checkbox">Remember me
</label>
<button type="submit" class="btn">Sign in</button>
</div>
</div>
</form>
    </div>
    <div class="panel-heading panel-bottom">
        <button class="btn btn-success btn-md bold" onclick="destroyDialog('about')">Close</button>
    </div>
</div>


            <?php
            include_once '../../includes/footer.php';
            ?>
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="../../js/jquery-1.11.0.js"></script>
            <script src="../../js/bootstrap.min.js"></script>
            <script src="../../js/jquery.msgbox.js"></script>
            <script src="../../js/master.js"></script>
            <script src="../../js/jquery.fs.stepper.min.js"></script>

            <script>
                $(function () {
                    $(".selecter_1").selecter();
                });

            </script>


    </body>
</html>
