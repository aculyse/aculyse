<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * Grading system 
 */

namespace Aculyse {

    use Aculyse\Config;

    class GradingSystem {

        public static $primary_level_struct = array("1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0);
        public static $ordinary_level_struct = array("A" => 0, "B" => 0, "C" => 0, "D" => 0, "E" => 0, "U" => 0);
        public static $advanced_level_struct = array("A" => 0, "B" => 0, "C" => 0, "D" => 0, "E" => 0, "O" => 0, "F" => 0);
        public static $primary_levels = array("Grade 0", "Grade 1", "Grade 2", "Grade 3", "Grade 4", "Grade 5", "Grade 6", "Grade 7");
        public static $ordinary_levels = array("Form 1", "Form 2", "Form 3", "Form 4");
        public static $advanced_levels = array("Lower 6th", "Upper 6th");

        /**
         * Grade perfomance using primary level. Grade 1 to 7
         * @param int $final_mark
         * @return string
         */
        private static function gradePrimary($final_mark) {
            if ($final_mark >= 90) {
                return "1";
            }
            if ($final_mark >= 80 && $final_mark < 90) {
                return "2";
            }
            if ($final_mark >= 70 && $final_mark <= 79) {
                return "3";
            }
            if ($final_mark >= 60 && $final_mark <= 69) {
                return "4";
            }
            if ($final_mark >= 50 && $final_mark <= 59) {
                return "5";
            }
            if ($final_mark >= 40 && $final_mark <= 49) {
                return "6";
            }
            if ($final_mark >= 30 && $final_mark <= 39) {
                return "7";
            }
            if ($final_mark >= 20 && $final_mark <= 39) {
                return "8";
            }
            if ($final_mark < 20) {
                return "9";
            }
            return;
        }

        /**
         * Grade perfomance according to GCE Ordinary level. Form 1 to 4
         * @param int $final_mark
         * @return string
         */
        private static function gradeOrdinaryLevel($final_mark) {
            if ($final_mark >= 75) {
                return "A";
            }
            if ($final_mark >= 60 && $final_mark <= 74) {
                return "B";
            }
            if ($final_mark >= 50 && $final_mark <= 59) {
                return "C";
            }
            if ($final_mark >= 45 && $final_mark <= 49) {
                return "D";
            }
            if ($final_mark >= 40 && $final_mark <= 44) {
                return "E";
            }
            if ($final_mark < 40) {
                return "U";
            }
        }

        /**
         * Grade perfomance according to GCE Advanced level. Form 1 to 4
         * @param int $final_mark
         * @return string
         */
        private static function gradeAdvancedLevel($final_mark) {
            if ($final_mark >= 75) {
                return "A";
            }
            if ($final_mark >= 60 && $final_mark <= 74) {
                return "B";
            }
            if ($final_mark >= 50 && $final_mark <= 59) {
                return "C";
            }
            if ($final_mark >= 45 && $final_mark <= 49) {
                return "D";
            }
            if ($final_mark >= 40 && $final_mark <= 44) {
                return "E";
            }
            if ($final_mark >= 35 && $final_mark <= 39) {
                return "O";
            }
            if ($final_mark <= 34) {
                return "F";
            }
        }

        /**
         * Facade for grading system
         * @param int $level
         * @param int $final_mark
         * @return type
         */
        public static function ZIMSEC($level, $final_mark) {
            switch ($level) {
                case PRY_LEVEL:
                    return self::gradePrimary($final_mark);
                    break;

                case O_LEVEL:
                    return self::gradeOrdinaryLevel($final_mark);
                    break;

                case A_LEVEL:
                    return self::gradeAdvancedLevel($final_mark);
                    break;

                default:
                    return;
                    break;
            }
        }
        
        /**
         * Choose default grading system based on class level.
         * @param string $level
         * @return type
         */
        public static function chooseDefaultGrading($level) {
            if (in_array($level, self::$primary_levels)) {
                return PRY_LEVEL;
            }
            if (in_array($level, self::$ordinary_levels)) {
                return O_LEVEL;
            }
            if (in_array($level, self::$advanced_levels)) {
                return A_LEVEL;
            }
        }
        
        
        /**
         * Get the structure of a grading system
         * @param type $level
         * @return type
         */
        public static function getGradingStructure($level) {

            switch ($level) {
                case PRY_LEVEL:
                    return self::$primary_level_struct;
                    break;

                case O_LEVEL:
                    return self::$ordinary_level_struct;
                    break;

                case A_LEVEL:
                    return self::$advanced_level_struct;
                    break;

                default:
                    return;
                    break;
            }
        }

        public static function getLevelName($level_id) {
            switch ($level_id) {
                case PRY_LEVEL:
                    return "Primary Level";
                    break;

                case O_LEVEL:
                    return "Ordinary Level";
                    break;

                case A_LEVEL:
                    return "Advanced Level";
                    break;

                default:
                    break;
            }
        }

    }

}
