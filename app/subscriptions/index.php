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
HTML::header("Aculyse | Subscriptions");
?>

                    <div class="col-lg-12  no-print">
                        <h1 class="text-danger lighter">Subscriptions Manager</h1>
                        <h5></h5>

                    </div>
                 

                    <div class="col-lg-12">

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    All subscription yearly/school
                                </div>
                            </div>

                            <div class="panel-body">
 <ul class="thumbnails col-lg-12">
                                    <?php

                                $Billing = new Billing();
                                $account_types = $Billing->getAccountTypes(); 
                                foreach ($account_types as $account) :
                                ?>
                               
                                            <li class="span4 col-lg-3">
                                                <div class="thumbnail">
                                                <img src="../assets/icons/144/paid-144.png" alt="300x200" style="">
                                                <div class="caption text-center">
                                                    <h1 class='lighter'><?php  echo "$".$account->price ?></h1>
                                                    <h3><?php  echo $account->type ?></h3>
                                                <p></p>
                                                <?php
                                                if($account->activated){
                                                    echo "<p><a href='account' class='btn btn-danger btn-block'>Active Plan</a></p>";
                                                }
                                                else{
                                  
                                                echo "<p><a href='activate?type=$account->id' class='btn btn-action btn-block'>Purchase</a></p>";
                                            }
                                                ?>
                                                </div>
                                                </div>
                                            </li>
<?php
endforeach;
?>
                                        </ul>

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
