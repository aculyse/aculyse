<?php

namespace Aculyse;

use Aculyse\Guardian\Auth\Session;
use Aculyse\UI\HTML;
use Aculyse\Guardian\Guardian;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once "../../vendor/autoload.php";

@session_start();

//check if user is allowed
Auth::isAllowed([
        AccessLevels::LEVEL_GUARDIAN
    ],TRUE
);

HTML::header("Aculyse | Student Profile Analysis");
?>
<div class="col-lg-12 no-print">
    <h1 class="text-danger lighter">Your Dependencies</h1>
    <h5>You can access information of your following dependencies.</h5>
</div>

<div class="col-lg-12">
    <div class="well well-sm white">
        <form method="post" action="">
            <input class="btn btn-action" name="refresh_form" type="submit" value="Refresh Dependences"/>
        </form>
    </div>
</div>

<?php

$StudentReader = new Students();
$guardian = new Guardian();
$guardian->id = ActiveSession::id();

//Refresh dependency.
if (isset($_POST["refresh_form"])) {

    if ($guardian->refreshDependences()) {
        echo "<div class='col-lg-12'>
                    <div class='alert alert-success text-bold'>Your dependences have been updated successfully
                    </div>
                   </div>";
    } else {
        echo "<div class='col-lg-12'>
                    <div class='alert alert-warning text-bold'>Your dependences were not updated.
                    </div>
                   </div>";
    }
}
$dependences = $guardian->getDependences();

//refresh guardian list
//dd($guardian->refreshDependences());

if (sizeof($dependences) == 0) {
    require_once INCLUDES_FOLDER . "/no_dependent.php";

}
for ($i = 0; $i < sizeof($dependences); $i++):

    $student_id = $dependences[$i]["dependent"][0]["student_id"];
    $firstname = $dependences[$i]["dependent"][0]["firstname"];
    $middlename = $dependences[$i]["dependent"][0]["middle name"];
    $surname = $dependences[$i]["dependent"][0]["surname"];
    $sex = $dependences[$i]["dependent"][0]["sex"];
    $avatar = $StudentReader->getAvatar($dependences[$i]["dependent"][0]["piclink"]);
    $class_level = $dependences[$i]["dependent"][0]["classes"]["level"];
    $school_id = $dependences[$i]["dependent"][0]["school"];
    $school_name = $dependences[$i]["dependent"][0]["school_info"]["name"];


    ?>

    <div class="col-lg-4">
        <div class="panel panel-primary">

            <div class="panel-body">
                <div class="centered" id="avatar-mid">
                    <img src="<?php echo $avatar ?>">
                </div>

                <table id="student-list-table" class="base-table">

                    <tbody>
                    <tr>
                        <td class="text-bold">STUDENT ID</td>
                        <td class="text-danger bold"><?php echo $student_id ?></td>
                    </tr>
                    <tr>
                        <td class="text-bold">FULLNAME</td>
                        <td class="text-danger"><?php echo "$firstname $middlename $surname" ?></td>
                    </tr>

                    <tr>
                        <td class="text-bold">SEX</td>
                        <td class="text-danger"><?php echo $sex ?></td>
                    </tr>

                    <tr>
                        <td class="text-bold">LEVEL</td>
                        <td class="text-danger"><?php echo $class_level ?></td>
                    </tr>

                    <tr>
                        <td class="text-bold">SCHOOL</td>
                        <td class="text-danger"><?php echo $school_name ?></td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <form action="executers/school_switcher.php" method="post">

                    <input type="hidden" name="school" value="<?php echo $school_id ?>"/>
                    <input type="hidden" name="student" value="<?php echo $student_id ?>"/>

                    <input type="submit" class="btn btn-action btn-block" value="View Report Book"/>
                </form>
            </div>
        </div>
    </div>

    <?php
endfor;


?>
<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>


</body>
</html>
