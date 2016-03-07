<?php

namespace Aculyse\Loggers;

use Aculyse\Models\ActivityLog;
use Aculyse\Traits\Eloquent;
use Aculyse\Helpers\Auth\ActiveSession;

    class ActivityLogger
    {
        use Eloquent;

        function __construct()
        {
//          $this>startEloquent();
        }


        public function saveActivity( $activity_type , $table , $description )
        {
            $ActivityLog = new ActivityLog();
            $ActivityLog->user = ActiveSession::id();
            $ActivityLog->activity_type = $activity_type;
            $ActivityLog->table = $table;
            $ActivityLog->description = $description;
            $ActivityLog->browser = $_SERVER['HTTP_USER_AGENT'];
            $ActivityLog->ip_address=$_SERVER['REMOTE_ADDR'];
            return $ActivityLog->save();
        }
    }
