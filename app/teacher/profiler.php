<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\UserIdentifier;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";

//chacl allowed access level
@session_start();
Auth::isAllowed([
    AccessLevels::LEVEL_WRITE_ANALYTICS,
    AccessLevels::LEVEL_SINGLE_MODE
]);

//add the required header markup
HTML::header("Aculyse | Profiler");

//get teacher subjets and classes
$UserIdentifier = new UserIdentifier();
$subjects = $UserIdentifier->lecturerSubjects();
?>

<div class="col-lg-12">
    <h2 class="text-danger lighter">Your Profiles</h2>
    <h5>Below is a list of profiles you have created, you have full access to them</h5>
</div>

<div class="col-lg-12">
    <div class="panel panel-primary shadow">
        <div class="panel-body">
            <button class="btn btn-md btn-action" onclick="getProfileForm();"><span class="glyph-icon flaticon-note19"></span>Start A New Profile</button>

        </div>
    </div>
</div>

<!-- /.row -->
<div class="col-lg-12" id="preloaded-menu">
    <div class="panel panel-primary">
        <div class="panel-heading bold">
            <span class="glyph-icon flaticon-note19"></span>Existing Profiles Menu
        </div>
        <div class="panel-body">

            <?php
            UIGenerator::getProfilesTable("markboard");
            ?>

        </div>
    </div>
</div>

</div>
</div>
</div>
<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>


<script>
    $(function () {
        $(".selecter_1").selecter();
        $('#student-list-table').dataTable({
            "order": [[6, "desc"]],
            'iDisplayLength': 50,
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "info": "Showing page _PAGE_ of _PAGES_"
            }
        });
    });
</script>

</body>
</html>
