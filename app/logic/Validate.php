<?php

namespace Aculyse {

    class Validate
    {

        /**
         * check to see if the college number is valid
         * return <b>TRUE</b> on success and <b>FALSE</b> on failure
         * @param string $input
         * @return boolean
         * @access public
         */
        public static function validateCollegeNumber($input)
        {
            $input = trim($input);
            if (preg_match("^\\d{4}/\\d{1,4}$^", $input, $match) == FALSE) {
                return FALSE;
            } else {
                if (strlen($input) != 8) {
                    return FALSE;
                } else {
                    //make sure the year presented is between 1960 and 2050
                    $year_prefix = (int) substr($input, 0, 4);
                    //the last digit should be greater than 1
                    $last_digit = (int) substr($input, 5, 8);

                    if (is_int($year_prefix) && $year_prefix > 1960 && $year_prefix <= 2050 && $last_digit != 0) {
                        return TRUE;
                    }
                    return FALSE;
                }
            }
        }

        /**
         * check validity of a persons name
         * return <b>TRUE</b> on success and <b>FALSE</b> on failure
         * @param type $input
         * @return boolean
         */
        public static function validatePersonName($input, $is_required)
        {
            $input = trim($input);
            preg_replace("[\']", "", $input);
            if (preg_match("^[0-9]|[\+\(\)\!\@\$\%\^\&\*\(\)\_\+\=\#\}\{\[\]\?\/\>\<\"\|\\\`\~]^", $input, $match) == TRUE) {
                return FALSE;
            } else {
                if ($is_required == FALSE && strlen($input) == 0) {
                    return TRUE;
                } elseif ($is_required = TRUE && strlen($input) <= 60 && strlen($input) >= 2) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }

        /**
         * check the validity of a national id number
         * return <b>TRUE</b> on success and <b>FALSE</b> on failure
         * @param string $input
         * @return boolean
         */
        public static function validateNationalIdNumber($input)
        {
            $input = trim($input);
            $prepared_input = preg_replace("^\\s^", "", $input);
            if ((preg_match("[^\\d{2}-?\\d{6,7}-?[A-Za-z]{1}-?\\d{2}$]", $prepared_input) == FALSE) || strlen($prepared_input) < 12 || strlen($prepared_input) > 16) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        /**
         * check the validity of phone number
         * return <b>TRUE</b> on success and <b>FALSE</b> on failure
         * @param string $input
         */
        public static function validatePhoneNumber($input, $is_required)
        {
            $input = trim($input);

            if ($is_required == FALSE && strlen($input) == 0) {
                return TRUE;
            }

            if ($is_required == TRUE && strlen($input) < 5) {
                return FALSE;
            }
            $prepared_input = preg_replace("^\\s^", "", $input);

            if (preg_match("[\\D]", $prepared_input) == TRUE || strlen($prepared_input) < 6 || strlen($prepared_input) > 16) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        public static function validateSex($input, $is_required)
        {
            $input = strtoupper(trim($input));
            //sex is required
            if ($is_required == TRUE) {
                if (($input == "male") || ($input == "female") || ($input == "FEMALE") || ($input == "MALE")) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }

            //is not required but something has been enterd
            if ($is_required == FALSE && strlen($input) > 0) {
                if (($input != "male") || ($input != "female") || ($input != "FEMALE") || ($input != "MALE")) {
                    return FALSE;
                } else {
                    return FALSE;
                }
            } else {
                return TRUE;
            }
        }

        public static function validatePasswordMatch($pwd1, $pwd2)
        {
            if ($pwd1 == $pwd2) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public static function validatePasswordCriteria($input)
        {
            if (strlen($input) < 5) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        public static function validateUsernameCriteria($input)
        {
            if (strlen($input) < 5) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        public static function validateEmail($input, $is_required)
        {
            //email is not required but one has been given
            if ($is_required == FALSE && strlen($input) > 0 && filter_var($input, FILTER_VALIDATE_EMAIL) == FALSE) {
                return FALSE;
            } else if ($is_required == TRUE && filter_var($input, FILTER_VALIDATE_EMAIL) == FALSE) {
                return FALSE;
            } else {
                return TRUE;
            }

            //email is required
            if (filter_var($input, FILTER_VALIDATE_EMAIL) == FALSE) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        public static function validateMainStudy($input, $is_required)
        {
            $input = strtoupper($input);

            $valid_studies = array(
                "ART AND DESIGN",
                "COMMERCIALS",
                "CHISHONA",
                "ENGLISH",
                "FRENCH",
                "GEOGRAPHY",
                "HISTORY",
                "ISINDEBELE",
                "MATHEMATICS",
                "MUSIC",
                "PORTUGUESE",
                "PHYSICAL EDUCATION AND SPORT",
                "SCIENCE"
            );

            //is not required but the user has submitted something
            if ($is_required == FALSE && strlen($input) > 0) {

                if (in_array($input, $valid_studies) == TRUE) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else if ($is_required == FALSE && empty($input)) {
                return TRUE;
            }
            //is required and input is available
            if ($is_required == TRUE && in_array($input, $valid_studies) == TRUE) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

    }

}    