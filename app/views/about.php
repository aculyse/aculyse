<?php
@session_start();
require_once "../logic/Config.php";
?>

<div id="overlay"></div>
<div class="panel panel-primary dialog" id="about">
    <div class="panel-heading">
        <h3 class="panel-title">About</h3>
    </div>
    <div class="panel-body">
        <h3 id="title" class="text-danger">acu<span class='light'>lyse</span></h3>
        <p id="description"><?php echo DESCRIPTION ?></p>
        <p class="text-danger bold">Edition : <?php echo EDITION ?></p>
        <p class="text-info bold">version <?php echo THIS_VERSION ?></p>
        <p class="text-info bold">Release Type : <?php echo VERSION_RELEASE ?></p>
        <p class="text-success bold">Developer: <?php echo COMPANY ?></p>
        <p class="text-danger bold">School : <?php echo strtoupper($_SESSION["user"]["school info"]["name"]) ?></p>


        <p>made with <span class="text-danger">&hearts; </span> in Africa</p>

    </div>
    <div class="panel-heading panel-bottom">
        <button class="btn btn-success btn-md bold" onclick="destroyDialog('about')">Close</button>
    </div>
</div>

<style type="text/css">
    #overlay,#about{
        display: block;
    }
</style>
