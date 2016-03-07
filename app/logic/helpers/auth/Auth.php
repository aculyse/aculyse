<?php

namespace Aculyse\Helpers\Auth;

use Aculyse\Config;
use Aculyse\Helpers\Auth\ActiveSession;

class Auth {


    /**
     * Check if a user access level is allowed to view or take
     * certain actions.
     * @param array $allowed_levels
     * @return bool
     */
    private static function isAccessLevelAllowed($allowed_levels = []) {
        $access_level_num = ActiveSession::accessLevel();
        return (!in_array($access_level_num, $allowed_levels) || !\Aculyse\AccessManager::isSessionValid());
    }


    /**
     * Check if a user access level is allowed to view or take
     * certain actions.
     * @param type $allowed_levels
     */
    public static function isAllowed($allowed_levels = [],$is_guardian=FALSE) {
        if (self::isAccessLevelAllowed($allowed_levels)) {
          if ($is_guardian) {
            header("location:login.php");
            die();
          }else{
            header("location:../");
            die();
          }
        }
    }


    public static function giveAccessToLevels($allowed_levels = []) {
        return self::giveAccessToLevels($allowed_levels);
    }

}
