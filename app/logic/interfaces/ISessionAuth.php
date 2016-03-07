<?php

namespace Aculyse\Interfaces;

interface ISessionAuth
{

    /**
     * Give rights to a user, in form of an access level
     * @param type $access_level
     */
    public static function grantRights($access_level);

    /**
     * Start user session
     * @param int $user_id
     * @param int $access_level
     * @param int  $school
     * @param int $user_num_id
     * @param array $school_details
     */
    public static function startSession($user_id, $access_level, $school, $user_num_id, $school_details);

    /**
     * Check if a session is valid
     */
    public static function isSessionValid();

    /**
     * Destroy an existing session
     */
    public static function destroySession();
}
