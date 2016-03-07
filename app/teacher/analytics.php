<?php

namespace Aculyse;

use Aculyse\UI\HTML;
use Aculyse\Helpers\Auth\Auth;

require_once "../../vendor/autoload.php";
@session_start();

Auth::isAllowed([
    AccessLevels::LEVEL_READ_ANALYTICS_ONLY,
    AccessLevels::LEVEL_WRITE_ANALYTICS,
    AccessLevels::LEVEL_UNIVERSAL_READ_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
        ]
);
//add the required header markup
HTML::header("Aculyse | Analytics ready Profiles");
?>

<div class="col-lg-12 no-print">

    <h2 class="text-danger lighter">Closed Profiles</h2>
    <h5>Choose the profile you want analysis for</h5>
</div>



<div class="col-lg-12 no-paddming">

    <div id="profile-list-table" class="panel panel-primary no-print">
        <div class="panel-heading">
            Closed Profiles
        </div>

        <div class="panel-body">
            <?php
            $Profiler = new Profiler();
            $ClassManager = new ClassManager();

            $UserIdentifier = new UserIdentifier();
            $subjects = $UserIdentifier->lecturerSubjects();
            if (is_array($subjects)) {
                /* get the list of profiles */
                $dataset = $Profiler->getClosedProfiles()->toArray();
            } else {
                require_once INCLUDES_FOLDER .  '/warning.php';
                
            }
            if ($dataset == FALSE) {
                include_once INCLUDES_FOLDER .  '/no_profile_analytics.php';
                
            }
            else{
            $table_ui = "<table  id='profiles-list-table-d' class='base-table'>";
            $table_ui.= "<thead><th>Subject</th>";
            $table_ui .= "<th>Year</th>";
            $table_ui .= "<th>Term</th>";
            $table_ui .= "<th>Class Of</th>";
            $table_ui .= "<th>Class Name</th>";
            $table_ui .= "<th>Status</th>";
            $table_ui .= "<th>Created</th></thead><tbody>";

            for ($i = 0; $i <= sizeof($dataset) - 1; $i++) {
                $profile_id = strtoupper(htmlspecialchars($dataset[$i]["id"]));
                $subject = $Profiler->getSubjectName($dataset[$i]["subject"])["title"];
                $year = strtoupper(htmlspecialchars($dataset[$i]["year"]));
                $term = strtoupper(htmlspecialchars($dataset[$i]["term"]));
                $mode = strtoupper(htmlspecialchars($dataset[$i]["class_name"]));
                $class_id = strtoupper(htmlspecialchars($dataset[$i]["class_name"]));
                $class_name = strtoupper($ClassManager->getClassDetails($class_id)[0]["class_name"]);

                $status = strtoupper(htmlspecialchars($dataset[$i]["status"]));
                $class_of = strtoupper(htmlspecialchars($dataset[$i]["class of"]));
                $course_work_num = strtoupper(htmlspecialchars($dataset[$i]["number of courseworks"]));

                $date_created = $dataset[$i]["created"];

                $proccessed_timestamp = TimeConvertor::convertDatetime($date_created);
                $calculated_ago_time = TimeConvertor::makeAgo($proccessed_timestamp);

                if ($i >= 1) {
                    $previous_year = strtoupper(htmlspecialchars($dataset[$i - 1]["year"]));
                    if ($previous_year != $year) {
                        //  $table_ui.="<tr class='xl real-huge'><td></td><td></td><td></td><td>$year</td><td></td><td></td><td></td></tr>" ;
                    }
                }

                $table_ui .= "<tr>";
                $table_ui .= "<td><a href='analyser.php?profile_id=$profile_id' class='bold'>$subject</a></td>";

                $table_ui .= "<td class='fail'>$year</td>";
                $table_ui .= "<td class='pass'>$term</td>";
                $table_ui .= "<td>$class_of</td>";
                $table_ui .= "<td>$class_name</td>";

                if ($status == "CLOSED") {
                    $table_ui .= "<td><span class='badge badge-danger'>Closed</span></td>";
                } else if ($status == "IN PROGRESS") {
                    $table_ui .= "<td><span class='badge badge-success'>In progress</span></td>";
                } else {

                    $table_ui .= "<td><span class='badge badge-info'>Unkown</span></td>";
                }
                $table_ui .= "<td>$calculated_ago_time</td>";
                $table_ui .= "</tr>";
            }
            $table_ui.= "</tbody></table>";

            echo $table_ui;
        }
            ?>

        </div>
    </div>

</div>

</div>
</div>
<?php
 include_once INCLUDES_FOLDER . '/footer.php';
?>
<script src="js/highcharts.js"></script>
<script src="js/highcharts-3d.js"></script>
<script src="js/exporting.js"></script>
<script>
    $(function () {

        $('#profiles-list-table-d').dataTable({
            "order": [[3, "desc"]],
            'iDisplayLength': 50
        });
    });
</script>
</body>
</html>
