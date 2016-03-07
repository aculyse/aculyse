<?php

namespace Aculyse\Billing;

use Carbon\Carbon;
use Aculyse\Traits\Eloquent;
 

class BillingTimer{

  use Eloquent;

  public function __construct(){
    $this->startEloquent();
  }

  public function addSubscriptionTime(school,plan_duration){

  }

}
