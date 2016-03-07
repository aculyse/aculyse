<?php
require_once "logic/AccessManager.php";
@session_start();
if (Aculyse\AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
    die();
}

//session is valid lets check the access level on level 4 is allowed, from more details check AccessLevels class
if ($_SESSION["user"]["access_level"]["right"] != Aculyse\AccessLevels::LEVEL_WRITE_ANALYTICS) {
    header("location:index.php");
    die();
}
require_once "logic/ProfileMetadata.php";
?>

<div class="container-fluid panel" id="meta-cover">

    <div class="panel-heading">
        <button class="btn btn-sm btn-action bold text-muted" onclick=$("#meta-cover").remove();$("#overlay").hide();>
            close
        </button>
    </div>
    <div class="panel-body">

        <div class="col-lg-12">
            <?php
            $ProfileMetadata = new \Aculyse\ProfileMetadata();

            $profile_id = $_POST["pid"];
            $profile_hash = $_POST["phash"];
            $secret_hash = sha1(SALT . $profile_id);

            /*
              if ($secret_hash !== $profile_hash) {
              require_once "includes/no_metadata.php";
              die();
              } */

            $result = $ProfileMetadata->get($profile_id);

            if (is_array($result)) {
                $table = "<table>";
                $table .= "<thead>";
                $table .= "<th class='col-lg-1'>Test #</th>";
                $table .= "<th class='col-lg-2'>Title</th>";
                $table .= "<th class='col-lg-5'>Description</th>";
                $table .= "<th class='col-lg-4'>Scope</th>";
                $table .= "</thead>";
                $table .= "<tbody>";

                for ($i = 0; $i < sizeof($result); $i++) {

                    $test_num = $result[$i]["test_num"];
                    $title = $result[$i]["name"];
                    $description = $result[$i]["description"];
                    $scope = $result[$i]["scope"];
                    $comment = $result[$i]["comment"];


                    $table .= "<tr>";
                    $table .= "<td class='bold text-info'>$test_num</td>";
                    $table .= "<td class='bold'><input type=text max-length=500 class='input col-lg-12 full-width' value=$title/></td>";
                    $table .= "<td> <textarea class='input col-lg-12 full-width'>$description</textarea></td>";
                    $table .= "<td><textarea class='input col-lg-12 full-width'>$scope</textarea></td>";
                    $table .= "</tr>";
                }
                $table .= "</tbody>";
                $table .= "</table>";

                print_r($table);
            } else {
                require_once "includes/no_metadata.php";
            }
            ?>
        </div>
    </div>
</div>
