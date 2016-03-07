<?php

/**
 * * @package Helpers
 */

namespace Aculyse\Helpers\Auth;

class ActiveSession
{

    
    private static function session()
    {
        @session_start();
        return $_SESSION["user"];
    }

    public static function id()
    {
        return self::session()["user_num_id"];
    }

    public static function user()
    {
        return self::session()["id"];
    }

    public static function checksum()
    {
        return self::session()["checksum"];
    }

    public static function token()
    {
        return self::session()["token"];
    }

    public static function transactionToken()
    {
        return self::session()["transaction_token"];
    }

    public static function school()
    {
       return self::session()["school"];
    }

    public static function schoolName()
    {
        return self::session()["school info"]["name"];
    }

    public static function randomKey()
    {
        return self::session()["random_key"];
    }

    public static function switchKey()
    {
        return self::session()["switch_key"];
    }

    public static function isDemo()
    {
        return self::session()["is_demo"];
    }

    public static function productionKey()
    {
        return self::session()["production_key"];
    }

    public static function accessLevel()
    {
        return self::session()["access_level"]["right"];
    }

    public static function home()
    {
        return self::session()["access_level"]["home"];
    }

    public static function dependent(){
        return self::session()["dependent"];
    }

    public function isGuardian(){
        @session_start();
        return isset($_SESSION['user']['dependent']);
    }

}
