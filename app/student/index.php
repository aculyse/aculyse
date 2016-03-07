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
/*
Auth::isAllowed([
        AccessLevels::LEVEL_GUARDIAN
    ],TRUE
);*/

HTML::header("Aculyse | Student Profile Analysis");
?>
<div class="col-lg-12 no-print">
    <h1 class="text-danger lighter">Resources</h1>
    <h5>You can access information of your following dependencies.</h5>
</div>

<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>


</body>
</html>
