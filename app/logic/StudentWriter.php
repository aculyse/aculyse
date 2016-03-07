<?php

namespace Aculyse;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";
require_once 'Config.php';

use Aculyse\Loggers\Log;
use Aculyse\Models\Student;
use Aculyse\Traits\Eloquent;


const START_ALPHA_INDEX = 0;
const END_ALPHA_INDEX = 25;
const ACU_PREFIX = "ACU-";

class StudentsWriter extends Students
{

    private $errors_arr = array();
    public $ActivityLogger;


    public function __construct()
    {
        parent::__construct();
        $this->ActivityLogger = new Log();
    }

    public function isAccountAvailable($student_id)
    {

        $account = Student::where("student_id", $student_id)
            ->count();

        if ($account > 0) {
            return ACCOUNT_TAKEN;
        } else {
            return ACCOUNT_AVAILABLE;
        }
    }

    //dob not validated
    public function addNewStudent($student_id, $ms1 = NULL, $ms2 = NULL, $firstname, $middlename = NULL, $surname, $national_id_num = NULL, $dob, $sex, $cell_number = NULL, $email_address = NULL, $home = NULL, $dob = NULL, $class, $class_of, $school)
    {
        //before validating the data make sure account is not taken
        if ($this->isAccountAvailable($student_id) == ACCOUNT_TAKEN) {
            return ACCOUNT_TAKEN;
        }

        if (Validate::validatePersonName($firstname, TRUE) === FALSE) {
            array_push($this->errors_arr, "Firstname is invalid make sure there are no numbers or symbols");
        }
        if (Validate::validatePersonName($middlename, FALSE) === FALSE) {
            array_push($this->errors_arr, "Middlename is invalid make sure there are no numbers or symbols");
        }
        if (Validate::validatePersonName($surname, TRUE) === FALSE) {
            array_push($this->errors_arr, "Surname is invalid make sure there are no numbers or symbols");
        }

        if (Validate::validatePhoneNumber($cell_number, FALSE) === FALSE) {
            array_push($this->errors_arr, "Invalid phone number, only number are allowed");
        }
        if (Validate::validateSex($sex, TRUE) === FALSE) {
            array_push($this->errors_arr, "sex is required ");
        }

        if (Validate::validateEmail($email_address, FALSE) === FALSE) {
            array_push($this->errors_arr, "email address invalid");
        }

        if (sizeof($this->errors_arr) > 0) {
            return $this->errors_arr;
        }

        //there are no errors so proceed to save escape format and save record
        $Student = new Student();
        $Student->student_id = $student_id;
        $Student->class_name = $class;
        $Student['class of'] = $class_of;
        $Student->school = $school;
        $Student->firstname = $firstname;
        $Student['middle name'] = $middlename;
        $Student->surname = $surname;
        $Student->sex = $sex;
        $Student->home = $home;
        $Student['cell number'] = $cell_number;
        $Student->email = $email_address;
        $Student->dob = $dob;
        return $Student->save();
    }

    /**
     * remove student account
     * @param string $student_id
     * @return boolean TRUE on success other wise False
     */
    public function deleteStudent($student_id)
    {

        return Student::where("student_id",$student_id)
            ->update(["status"=>"deleted"]);
    }

    /**
     *
     * activate or deactivate accounts based on action presented by $action parameter
     * $action value and corresponding action<br/><br/>
     * deactivated=>execute to deactivate account.<br/>
     * activated=>execute to activate account.<br/>
     *
     * @param string $account student identifier
     * @param string $status either 'activated' or 'deactivated'
     * @return boolean 'TRUE' on success & 'FALSE' on failure
     * @deprecated since version 1
     */
    function changeAccountStatus($account)
    {
        $account = mysqli_real_escape_string($this->con, $account);

        //get current status omf this account
        $this->current_status = $this->getAccountStatus($account);

        if ($this->current_status == "activated") {
            $this->new_status = "deactivated";
        } else if ($this->current_status == "deactivated") {
            $this->new_status = "activated";
        } else {
            return "StatusInvalidException";
        }

        $this->new_status = mysqli_real_escape_string($this->con, $this->new_status);

        $this->sql = "UPDATE `students` SET `status` = '$this->new_status' WHERE `students`.`id` = '$account'";

        mysqli_autocommit($this->con, FALSE);

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }
        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            return TRUE;
        } else {
            mysqli_rollback($this->con);
            return FALSE;
        }
    }

    /**
     * Update student profile
     * @param $field database column name
     * @param $value the value to be update to
     * @param $student_id student identification number
     * @return string
     *
     */
    public function updateProfile($field, $value, $student_id)
    {
        $update = Student::where("student_id", $student_id)
            ->update(["$field" => $value]);

        if ($update) {
            $this->ActivityLogger->write(['activity' => 'update', 'table' => 'students', 'description' => "update student id [$student_id] column [$field] to value [$value]"]);
            return "Success";
        } else {
            return "NoUpdate";
        }
    }

    /**
     * Generate a unique student ID  number
     * @return student id number
     */
    public function generateStudentNum()
    {

        $alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

        $first_letter = $alphabet[rand(START_ALPHA_INDEX, END_ALPHA_INDEX)];
        $second_letter = $alphabet[rand(START_ALPHA_INDEX, END_ALPHA_INDEX)];
        $last_letter = $alphabet[rand(START_ALPHA_INDEX, END_ALPHA_INDEX)];

        $middle_code = rand(10000, 99999);

        $full_code = ACU_PREFIX . $first_letter . $second_letter . $middle_code . $last_letter;

        //check if the acount is taken
        if ($this->isAccountAvailable($full_code) === ACCOUNT_AVAILABLE) {
            return $full_code;
        } else {
            $this->generateStudentNum();
        }
    }

}
