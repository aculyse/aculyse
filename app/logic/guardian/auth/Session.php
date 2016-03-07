<?php
/**
 * Created by PhpStorm.
 * User: User1
 * Date: 05/02/2016
 * Time: 3:16 PM
 */

namespace Aculyse\Guardian\Auth;

const SIGNUP_SESSION_NAME = "aculyse_signup";

class Session
{

    public static function setSchool($school_id,$student)
    {
        @session_start();
        $_SESSION['user']['school'] = $school_id;
        self::setDependent($student);
    }

    public static function setDependent($dependents)
    {
        @session_start();
        $_SESSION['user']['dependent'] = $dependents;
    }

    public static function startSignupSession($guardian)
    {
      @session_start();
      $_SESSION[SIGNUP_SESSION_NAME] = $guardian;
    }

    public static function isSignupSessionValid()
    {
        @session_start();
     return isset($_SESSION[SIGNUP_SESSION_NAME]);
    }
}
