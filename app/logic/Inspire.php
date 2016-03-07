<?php

/*
 | -----------------------------------------------------------------------
 | INSPIRE
 | -----------------------------------------------------------------------
 |  Give the user some bit of inspiration
 |
 */

namespace Aculyse;

class Inspire {
    
    private static $quotes = array(
        "Education is the key",
        "Wisdom is an acquired quality",
        "Education matters when you apply it",
        "Teachers are the super humans of our generation",
        "This software is a result of a teacher",
        "Quality is the mantra of our softwares",
    );

    public static function quote() {
        $random = rand(0, sizeof(self::$quotes) - 1);
        return self::$quotes[$random];
    }

}
