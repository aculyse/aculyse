<?php

/**
 * Manage Billing and subscription management
 * @author Blessing Mashoko <projects@bmashoko.com>
 * @package Billing
 */

namespace Aculyse\Billing;

use Carbon\Carbon;
use Aculyse\Models\Licenses;
use Aculyse\Models\School;
use Aculyse\Models\AccountTypes;
use Aculyse\Traits\Eloquent;
use Aculyse\Traits\DBConnection;
use Aculyse\Helpers\Auth\ActiveSession;
use Aculyse\Billing\Traits\CanGenerateKeys;

const LICENCE_KEY_USED = 1;
const LICENCE_KEY_AVAILABLE = 0;

class Billing
{

    private $key;
    private $pin;
    private $auth_school_id;


    use Eloquent,
        CanGenerateKeys;

    function __construct()
    {
        $this->startEloquent();
        $this->authenticated_user = ActiveSession::user();
        $this->auth_teacher_id = ActiveSession::id();
        $this->auth_school_id = ActiveSession::school();
    }

    /**
    *Check if the licence key and pin combination are valid
    *@param string key 25 digit key
    *@param int pin
    */
    public function checkKey($key, $pin)
    {
        $this->key = $key;
        $this->pin = $pin;

        $result = Licenses::where("key", $this->key)
                ->where("pin", $this->pin)
                ->where("used",LICENCE_KEY_AVAILABLE)
                ->with("plan_type")
                ->get();
        return $result;
    }

    /**
    *Activate a licence after validating if its valid
    */
    public function activate()
    {
        $license = Licenses::find($this->key);
        $license->school_id = $this->auth_school_id;
        $license->activated_at = Carbon::now();
        $license->used=LICENCE_KEY_USED;
        if($license->save()){
          return $this->duration($license->duration);
        }
        return FALSE;
    }

    public function duration($time_frame=NULL)
    {
        $days=0;

        switch ($time_frame) {
          case 'month':
            $days = 31;
            break;

          case 'term':
            $days = 80;
            break;

        case 'year':
              $days = 365;
          break;

       default:
            $days=0;
            break;
        }
        $school = School::find($this->auth_school_id);
        $expiry = \Aculyse\TimeConvertor::convertDatetime($school->to_date);

        $school->to_date = Carbon::createFromTimestamp($expiry)->addDays($days);
        return $school->save();
    }

    /**
    *Get all plans available
    */
    public function getAccountTypes()
    {
        return AccountTypes::all();
    }

    /**
    *Get activation details of a school
    */
    public function getActiveSchoolSubscription()
    {
        $subscription = School::find(ActiveSession::school());
        return $subscription;
    }
}
