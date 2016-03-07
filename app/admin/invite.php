<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * This page is for inviting parents to signup on the
 * platform, to track their children
 */

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Guardian\Guardian;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once "../../vendor/autoload.php";
@session_start();

$access_level_num = ActiveSession::accessLevel();

Auth::isAllowed([
    AccessLevels::LEVEL_WRITE_STUDENTS,
    AccessLevels::LEVEL_READ_STUDENTS_ONLY,
    AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
]);

HTML::header("Aculyse | Student Management");
?>

<span class='hide nope hiden' id="access-pixel" data-access="<?php echo $access_level_num ?>"></span>

<div class="col-lg-12  no-print">
    <h3 class="text-danger lighter">Invite Parents/Guardians</h3>
    <h5>For parents to track their children invite them. A message will be sent giving the instructions on how to get
        started.</h5>

</div>

<?php
$guardian = new Guardian();
$parent = $guardian->getInvitable();

$parent_count = $parent->count();
$guardian->invite($parent);

?>
<div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h2><?php echo $parent_count ?></h2>
            <p>Guardian(s) can be invited</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer text-bold" style="padding:1%;">
            Invite Now <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>


</body>
</html>
