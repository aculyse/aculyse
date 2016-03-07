<?php

/**
 * @todo version 3 will include this
 *  @author Blessing Mashoko <projects@bmashoko.com>
 *  This provides the breakdown for weighing tests and exams
 * this is still unimplemented any in the system
 */

namespace Aculyse;

use Aculyse\Traits\Eloquent;
use Aculyse\Models\Breakdown;
use Aculyse\Helpers\Auth\ActiveSession;

class BreakdownManager
{

    use Eloquent;

    public function __construct()
    {
        $this->startEloquent();
        $this->authenticated_user = ActiveSession::user();
        $this->auth_teacher_id = ActiveSession::id();
        $this->auth_school_id = ActiveSession::school();
    }

    public function init($profile_id, $test_num = 0, $exam = 0)
    {
        $test_arr = array();
        for ($i = 1; $i <= $test_num; $i++) {
            //array_push($test_arr, arry("course work $i"=>0));
        }

        $Breakdown = new Breakdown();
        $Breakdown->profile_id = $profile_id;
        $Breakdown->test_num = json_encode($test_arr);
        $Breakdown->exam = $exam;
        return $Breakdown->save();
    }

    public function observe()
    {
        
    }

    public function getProfileBD($profile_id)
    {
        $breakdown = Breakdown::where("profile_id", $profile_id)
                ->with("profile_info")
                ->get();

        return $breakdown;
    }

}
