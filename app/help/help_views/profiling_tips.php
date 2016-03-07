<?php
//require_once '../logic/Config.php' ;
?>


<div class="col-lg-12">
    <div class="panel-group collapse in" id="accordion1" style="">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
                        What is Profiling?
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    In this context a <b>Profile</b> is a collection of student perfomances/marks recorded for a certain period of time.
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo">
                        How to start a Profile
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>To start a Profile, you have to enter the <b>Profile Criterias</b> on the form shown below:</p>
                    <img class="col-lg-12" src="img/prof_1.png"/>

                    <p>The following criteria should be met, for a Profile to start</p>
                    <ul>
                        <li><b>Non existence.</b>The Profile should not be existing already, if the profile already exists you will not start a new one, instead you will be show the existing one. </li>
                        <br/>
                        <li><b>Students Existence.</b> There should be students in a class which meet the criteria for the profile or else the profile will not be start.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree">
                        How to  add/editing Marks
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Adding/Editing marks can be done on existing profiles and only the author of the Profile can edit it. To edit just add a percentage in textbox on the Profile table. The screenshot below shows the Profiling page.</p>
                    <img class="col-lg-12" src="img/prof_2.png"/>
                    <p>The following criteria should be met, for editing to be done</p>
                    <ul>
                        <li><b>Author only.</b>The user who started the profile is the one who has the permission to edit the Profile no one else, this is done for security reasons.</li>
                        <br/>
                        <li><b>Mark as a percentage.</b> Marks <b>should</b> be entered as percentages betwen <b>0 and  100</b> to be deemed valid or else the system will reject them</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion1" href="#ICompile">
                        Compiling a Profile
                    </a>
                </h4>
            </div>
            <div id="ICompile" class="panel-collapse collapse">
                <div class="panel-body">
                    <p><b>Compiling</b> is process of allocating <b>weight</b> to different tests or exams so that <b>Perfomance Analytics</b> can be done. It also indicates to other users that a Profile is now final and closed.</p>
                    <h6><b>The following steps show how to compile a profile.</b></h6>
                    <ul>
                        <li>Open any profile in <b>edit mode</b> i.e you have the permission to edit/add marks.</li>
                        <li>Click &quot;<b>Compile</b>&quot; button at the top of the panel.</li>
                        <li><p>The modal window will be shown for compiling the profile as shown below:</p>
                            <img  class="col-lg-12" src="img/prof_3.png"/>
                            <p>Fill in at <b>least one </b>field. Do not that fill in numbers only without <b>percentage(&percnt;)</b> sign and the <b>total</b> of the two fields <b><u>should</u> not exceed 100%</b>.</p>
                        </li>
                        <li>Click <b>&quot;Compile&quot;</b>. If the action is completed successfully the Profile status will change to <b>&quot;closed&quot;</b> and becomes available on the Perfomance Analytics page for other users</b></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion1" href="#IAdd">
                        Adding additional students
                    </a>
                </h4>
            </div>
            <div id="IAdd" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Students are added to a profile based on their college number (entry year) and subject, that may not be enough. You can add students manually who are not added automatically for reasons like repetition e.t.c to a profile by following the following steps: </p>

                    <ul>
                        <li>Open any profile in <b>edit mode</b> i.e you have the permission to edit/add marks.</li>
                        <li>Click &quot;<b>Add Student</b>&quot; button at the top of the panel.</li>
                        <li><b>Search or input the college number</b> and click <b>"Add Student"</b></li>
                    </ul>
                    When your done check the profile if the student is now added.
                </div>
            </div>
        </div>

    </div>
</div>