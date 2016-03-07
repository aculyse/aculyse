<?php

namespace Aculyse;


use Aculyse\UI\HTML;
use Aculyse\Billing\Billing;
use Aculyse\Helpers\Auth\Auth;
use Aculyse\Helpers\Auth\ActiveSession;

require_once "../../vendor/autoload.php";
@session_start();
if (AccessManager::isSessionValid() == FALSE) {
    header("location:index.php");
    die();
}

Auth::isAllowed([
    AccessLevels::LEVEL_ADMIN_ONLY,
    AccessLevels::LEVEL_SINGLE_MODE
]);
HTML::header("Aculyse | Subscription account");
?>

                    <div class="col-lg-12  no-print">
                        <h1 class="text-danger lighter">Active Subscription</h1>
                        <h5></h5>

                    </div>


                    <div class="col-lg-12">

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                </div>
                            </div>

                            <div class="panel-body">
                            	<table>
                            		<?php

                            		$Billing = new 	Billing();
                            		$active_account = $Billing->getActiveSchoolSubscription();
                                /*$Billing->saveManyKeys(4,"year",10);
                              $Billing->saveManyKeys(4,"month",10);
                                $Billing->saveManyKeys(4,"term",10);
*/
                            		$account = $active_account;
                            		?>
                            			<tr class="shaddy"><td>SCHOOL DETAILS</td><td></td></tr>

                            			<tr>
                            				<td>School ID</td><td class="text-bold text-uppercase"><?php  echo $account->id  ?></td></tr>
                            				<td>Name</td><td class="text-bold text-uppercase"><?php  echo $account->name ?></td></tr>
                            				<td>Level</td><td class="text-bold text-uppercase"><?php  echo  $account->level ?></td></tr>


                            			<tr>

                            			</tr>

				<tr class="shaddy"><td>LICENSE DETAILS</td><td></td></tr>

                            			<tr>
                            				<td>Expiry date</td><td class="text-bold text-uppercase"><?php  echo $account->to_date ?></td>

                            			</tr>

                            		</table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php
        include_once '../includes/footer.php';
        ?>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery-1.11.0.js"></script>

</body>
</html>
