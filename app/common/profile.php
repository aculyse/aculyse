<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once '../../vendor/autoload.php';

$access_level_num = ActiveSession::accessLevel();
@session_start();
Auth::isAllowed([
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_WRITE_ANALYTICS,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);

HTML::header("Aculyse | Class Management Portal")
?>

<?php

$User = new Users();
$active_user = $User->active();

?>


<div class="col-lg-12">
    <h1 class="text-danger lighter">User Account</h1>
    <h5>View or edit your account details</h5>
</div>
<div class="col-lg-12">
<div class="well">
<button class="btn btn-action"><i class="fa fa-edit"></i> Edit Profile</button>
</div>
</div>
<div class="col-lg-5">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Student Information
        </div>

        <div class="panel-body">

            <div class="centered" id="avatar-mid">
                    <img src="../avatars/200x200_5eb6766def8686f0505f587533c57009ca1a7f93.png">
                </div><table id="student-list-table" class="base-table">

                <tbody><tr>
                    <td class="text-bold">FULLNAME</td>
                    <td class="text-danger bold"><?php  echo $active_user->fullname ?></td>
                </tr>
                <tr>
                    <td class="text-bold">USERNAME</td>
                    <td class="text-danger"><?php  echo $active_user->username ?></td>
                </tr>
                <tr>
                    <td class="text-bold">EMAIL</td>
                    <td class="text-danger"><?php  echo $active_user->email ?></td>
                </tr>
                <tr>
                    <td class="text-bold">PHONE NUMBER</td>
                    <td class="text-danger"><?php  echo $active_user['cell number'] ?></td>
                </tr>
                <tr>
                    <td class="text-bold">ACCESS LEVEL</td>
                    <td class="text-danger"><?php  echo $active_user->access_level ?></td>
                </tr>

                <tr>
                    <td class="text-bold">STATUS</td>
                    <td class="text-danger"><?php  echo $active_user->status ?></td>
                </tr>


            </tbody></table>


        </div>

    </div>
</div>
<div class="col-lg-7">
<div class="panel panel-primary">
                <div class="panel-heading">
                  About me
                </div><!-- /.panel-header -->
                <div class="panel-body">
                  <strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                  <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                  <p class="text-muted">Malibu, California</p>

                  <hr>

                  <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                  <p>
                    <span class="label label-danger">UI Design</span>
                    <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span>
                  </p>

                  <hr>

                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div><!-- /.panel-body -->
              </div>

</div>
</div>

<?php
include_once INCLUDES_FOLDER . '/footer.php';
?>
</body>
</html>
