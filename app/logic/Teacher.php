<?php

/**
 *
 * @author Blessing Mashoko <projects@bmashoko.com>
 * Manage information about classes as well as allocating classed to teachers and students
 *
 */

namespace Aculyse;

use Aculyse\Config;
use Aculyse\Database;
use Aculyse\Models\User;
use Aculyse\AccessManager;
use Aculyse\Traits\Eloquent;
use Aculyse\Models\TeacherClasses;
use Aculyse\Loggers\ActivityLogger;
use Aculyse\Helpers\Auth\ActiveSession;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

class Teacher
{
    use Eloquent;

    public function __construct()
    {
        $this->startEloquent();

        @session_start();
        $this->auth_school_id = ActiveSession::school();
    }

    public function get($id){   
        return User::find($id);
    }
}