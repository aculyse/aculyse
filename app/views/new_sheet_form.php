<?php

namespace Aculyse;

require_once '../../vendor/autoload.php';
@session_start() ;
if(is_null($_SESSION['user']['id']) == true) {
    header("location:index.php") ;
    die() ;
}

$UserIdentifier = new UserIdentifier() ;
$ClassManager = new ClassManager() ;

$teacher_subjects = $ClassManager->getTeacherSubject($_SESSION['user']['user_num_id']) ;

$subjects = $UserIdentifier->subjectLookup() ;
$tr_classes = $UserIdentifier->getTeacherClasses() ;
?>
<div id="overlay" class="yep" onclick="$('#overlay,#new-profile-menu').fadeOut(200);" > </div>
<div class ="col-lg-8 col-lg-offset-2 dialog" id="new-profile-menu">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyph-icon flaticon-crayon4"></span>Profile Creation Wizard
            <button class='btn btn-xs btn-default pull-right' onclick="$('#overlay,#new-profile-menu').remove();"><strong>Close</strong></button>
        </div>

        <div class="panel-body">
            <?php
            if(sizeof($subjects) == 0) {
                require_once '../includes/no_subject.php' ;
                die() ;
            }
            ?>
            <div class="col-lg-12 no-padding">
                <input type="hidden" id="current-prof-sect" value="1"/>
                <form id="new-sheet-form">
                    <div class="ui steps">
                        <a class="active step" id="step-1">
                            <div class="contentf">
                                <div class="title">Step 1</div>
                                <div class="description">Select class</div>
                            </div>
                        </a>
                        <a class="step" id="step-2">
                            <div class="contentf">
                                <div class="title">Step 2</div>
                                <div class="description">Select time variables</div>
                            </div>
                        </a>
                        <a class="step" id="step-3">
                            <div class="contentf">
                                <div class="title">Final</div>
                                <div class="description">Choose number of tests</div>
                            </div>
                        </a>
                    </div>
                    <div class="ui horizontal divider"><span class="typcn typcn-tabs-outline"></span></div>
                    <section id="prof-1">

                        <?php
                        echo '<div class="listgroup pointer" id="subject-tags">' ;
                        $i=0;
                        foreach ($teacher_subjects as $tr) {
                            $i+=1;



                            echo '<div class="ui image label tr-subs-label" id="class-' . $i . '" onclick="prof_next(' . $i . ',1);" ">
    <h6 class="bold"><span>' . $tr->subject_info->title . '</span></h6>
    <span class="blue">' . $tr->class_info->class_name . '</span>
  ' ;
                            echo "<input type='hidden' id='input-class-id' value='".$tr->class_info->class_id."'/>" ;
                            echo "<input type='hidden' id='subject-class-id' value='".$tr->subject_info->id."'/>" ;
                            echo '</div>' ;
                        }
                        echo '</div>' ;
                        ?>
                    </section>
                    <section id="prof-2" class="nope">


                        <input type="hidden" id="subjectTXT"/>
                        <input type="hidden" id="classTXT"/>



                        <div class="input-box">
                            <label class="labels">Class of </label>
                            <select name="modeTXT" class="input selector selecter" required="" id="modeTXT">
                                <option value="null">--year of graduation--</option>

                            </select>
                        </div>



                        <div class="input-box">
                            <label class="labels">Year</label>
                            <select name="yrTXT" class="input selector selecter_1" required="" id="yearTXT">
                                <?php
                                $now = date("Y") ;
                                echo "<option value='$now'>$now</option>" ;

                                for($i = $now ; $i >= 2005 ; $i--) {
                                    echo "<option>$i</option>" ;
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <label class="labels">Term</label>
                            <select name="termTXT" class="input selector selecter_1" required="" id="termTXT">
                                <option value="null">--select term--</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>

                        <div class="panel-bottom col-lg-12 sp-bottom">

                            <div class="ui horizontal divider"><span class="typcn typcn-tabs-outline"></span></div>

                            <a class="btn btn-md btn-action pull-left" onclick="profBack();"><span class="typcn typcn-backspace xl"></span>Restart Wizard</a>
                            <a class="btn btn-md btn-action pull-right" onclick="prof_next(null, 0)">Next<span class="typcn typcn-arrow-forward xl"></span></a>
                        </div>
                    </section>
                    <section id="prof-3" class="nope">

                        <div class="input-box">
                            <label class="labels">Number of tests</label>
                            <select name="cwTXT" class="input selector selecter_1" required="" id="cwTXT">
                                <option value="0">--no course works--</option>
                                <?php
                                for($i = 1 ; $i <= 10 ; $i++) {
                                    echo "<option value='$i'>$i</option>" ;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="panel-bottom col-lg-12 sp-bottom">

                            <div class="ui horizontal divider"><span class="typcn typcn-tabs-outline"></span></div>
                            <a class="btn btn-md btn-action pull-left" onclick="profBack();"><span class="typcn typcn-backspace xl"></span>Restart Wizard</a>

                            <a class="btn btn-md btn-action pull-right" onclick="startProfile();">Finish<span class="typcn typcn-cog-outline xl"></span></a>
                        </div>
                    </section>
                </form>
            </div>
            <div class="col-lg-12 no-padding">
                <div class="list-group" id="errors-box">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(function() {
        $(".selecter_1").selecter();
    });
</script>
