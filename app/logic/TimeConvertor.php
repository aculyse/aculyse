<?php

/* Description: converts timestamps to time intervals with current date and time
 */

namespace Aculyse;

use Caborn\Carbon;

//require_once '../vendor/autoload.php';

class TimeConvertor {

    public static function convertDatetime($str) {
        list($date, $time) = explode(' ', $str);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        return $timestamp;
    }

    public static function makeAgo($timestamp) {
        return \Carbon\Carbon::createFromTimestampUTC($timestamp)->diffForHumans();
    }

}

?>