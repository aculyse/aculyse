<aside class="sidcebar main-sidebar" id="mini-bar">

    <section class="sidebar">
    <ul class="sidebar-menu">

        <?php

        $access_level_num = Aculyse\Helpers\Auth\ActiveSession::accessLevel();

        if ($access_level_num == Aculyse\AccessLevels::LEVEL_ADMIN_ONLY) {
            echo '<li><a href="super?overview"><i class="fa fa-users"></i><span >Users</span></a></li>';
        }
        if ($access_level_num == Aculyse\AccessLevels::LEVEL_WRITE_STUDENTS || $access_level_num == Aculyse\AccessLevels::LEVEL_SINGLE_MODE || $access_level_num == 2 || $access_level_num == 5 || $access_level_num == Aculyse\AccessLevels::LEVEL_ADMIN_ONLY) {

            echo '<li><a href="dash?overview"><i class="fa fa-tasks"></i><span >Students</span></a></li>';
            if ($access_level_num == Aculyse\AccessLevels::LEVEL_WRITE_STUDENTS || $access_level_num == Aculyse\AccessLevels::LEVEL_ADMIN_ONLY) {
                echo '<li><a href="new" title="Add a new student"><i class="fa fa-plus-circle"></i><span >New Student</span></a></li>';
            }
        }

        if ($access_level_num == 3 || $access_level_num == 4 || $access_level_num == 5 || $access_level_num == Aculyse\AccessLevels::LEVEL_SINGLE_MODE) {

            echo '<li><a href="analytics"><i class="fa fa-bar-chart-o"></i><span>Analytics</span></a></li>';

            if ($access_level_num == 4 || $access_level_num == Aculyse\AccessLevels::LEVEL_SINGLE_MODE) {
                echo '<li><a href="profiler"><i class="fa fa-table"></i><span >Profiler</span></a></li>';
                echo '<li><a href="classes"><i class="fa fa-group"></i><span >Classes</span></a></li>';
            }

        }
        if($access_level_num == \Aculyse\AccessLevels::LEVEL_GUARDIAN){
            echo '<li><a href="change_password"><i class="fa fa-lock"></i><span>Security</span></a></li>';
        }else{
            echo '<li onclick="getDialog(\'security\');"><a href="#"><i class="fa fa-lock"></i><span>Security</span></a></li>';
        }
        ?>

        <li><a href="#" onclick="logout();"><i class="fa fa-ban"></i><span >Sign out</span></a></li>
        <li><a href="../help" target="blank"><i class="fa fa-lightbulb-o"></i><span >Help</span></a></li>
        <li onclick="getDialog('feedback_form');"><a href="#"><i class="fa fa-bug"></i><span >Feedback</span></a></li>
        <li onclick="getDialog('about');"><a href="#"><i class="fa fa-info"></i><span >About</span></a></li>
        <li><a onclick="toggleSideBar()"><i class="fa fa-th-list"></i><span >Minimize</span></a></li>

    </ul>
    </section>

</aside>
