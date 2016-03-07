<?php

/**
 * This class is responsible for read operation on students, for write operation see StudentWriter.php
 *
 * @author Mashoko Blessing <bmashcom@hotmail.com>
 * @version 2.0.0
 *
 */

namespace Aculyse;

use Aculyse\Models\Student;
use Aculyse\Traits\Eloquent;
use Aculyse\Traits\DBConnection;
use Aculyse\Helpers\Auth\ActiveSession;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

class Students
{

    use DBConnection,
        Eloquent;

    public $student_id, $newConnection, $con, $dataset = array();
    public $firstname;
    public $surname;
    private $sql;
    private $executeQuery;
    private $img;
    private $status;
    private $id_num;

    function __construct()
    {
        $this->con = $this->databaseInstance();
        $this->startEloquent();
        $this->auth_school_id = ActiveSession::school();
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);
    }

    public function search($search_term)
    {
        $this->sql = "SELECT * FROM students WHERE school='$this->auth_school_id' && (`student_id` LIKE '%$search_term%' "
            . "OR firstname LIKE  '%$search_term%' "
            . "OR surname LIKE  '%$search_term%' "
            . "OR `middle name` LIKE  '%$search_term%') "
            . "&& status !='deleted'";
        $students = Capsule::select($this->sql);

        return $students;
    }

    public function get($page = 0)
    {

        $students = Student::where("status", "!=", "deleted")
            ->where("school", ActiveSession::school())
            ->orderBy("firstname", "ASC")
            ->with("classes")
            ->forPage($page, 30)
            ->get();

        return $students;
    }

    public function findByStudentId($student_id)
    {
        $student = Student::where("student_id", $student_id)
            ->get();
        return $student->toArray();
    }

    /**
     * This function generates queries based on the parameters passed to it.
     * @param type $type
     * @param type $user_account
     * @param type $search_term
     * @return sql string
     * @deprecated since version 1
     */
    private function generateQuries($type, $user_account, $search_term)
    {
        switch ($type) {

            case "LIST":

                if ($search_term != NULL) {
                    $this->sql = "SELECT * FROM students WHERE school='$this->auth_school_id' && (`student_id` LIKE '%$search_term%' "
                        . "OR firstname LIKE  '%$search_term%' "
                        . "OR surname LIKE  '%$search_term%' "
                        . "OR `middle name` LIKE  '%$search_term%') "
                        . "&& status !='deleted'";
                    return $this->sql;
                }
                if (is_numeric($this->start_from) && $this->start_from > 0) {
                    $this->sql = "SELECT * FROM students WHERE school='$this->auth_school_id' && status !='deleted' ORDER BY `student_id` ASC LIMIT $this->start_from,30";
                    return $this->sql;
                } else {
                    $this->sql = "SELECT * FROM students WHERE school='$this->auth_school_id' && status !='deleted' ORDER BY `student_id` ASC LIMIT 30";
                    return $this->sql;
                }

                break;

            case "SINGLE":
                $this->sql = "SELECT * FROM students WHERE school='$this->auth_school_id' && status !='deleted' && `student_id`='$user_account'";

                return $this->sql;
                break;
        }
    }

    /**
     * Extract student data based on parameter list.
     * @param type $start_from
     * @param type $type
     * @param type $user_account
     * @param type $search
     * @param type $sql
     * @return boolean
     */
    function getStudents($start_from = NULL, $type = NULL, $user_account = NULL, $search = NULL, $sql = NULL, array $year_and_class = [])
    {


        $this->start_from = mysqli_real_escape_string($this->con, $start_from);
        $this->type = mysqli_real_escape_string($this->con, $type);
        $this->user_account = mysqli_real_escape_string($this->con, $user_account);
        $this->search_term = mysqli_real_escape_string($this->con, $search);

        if (!is_null($sql)) {
            $this->sql = $sql;
        } else {
            $this->sql = $this->generateQuries($this->type, $this->user_account, $this->search_term);
        }

        if (sizeof($year_and_class) > 0) {
            $this->year = mysqli_real_escape_string($this->con, $year_and_class["year"]);
            $this->class = mysqli_real_escape_string($this->con, $year_and_class["class"]);
            $this->sql = "SELECT * FROM students WHERE school='$this->auth_school_id' && status !='deleted' && `class_name`='$this->class' && `class of`='$this->year' ";
        }
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return FALSE;
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {

            return FALSE;
        }

        $this->student_details = array();

        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {

            $this->id = htmlspecialchars($this->rows['id']);
            $this->student_id = htmlspecialchars($this->rows['student_id']);
            $this->firstname = htmlspecialchars($this->rows['firstname']);
            $this->middlename = htmlspecialchars($this->rows['middle name']);
            $this->surname = htmlspecialchars($this->rows['surname']);

            $this->school = $this->rows["school"];
            $this->class_of = $this->rows["class of"];
            $this->class_name = $this->rows["class_name"];

            $this->home = htmlspecialchars($this->rows['home']);
            $this->cell = htmlspecialchars($this->rows['cell number']);
            $this->email = htmlspecialchars($this->rows['email']);

            $this->status = htmlspecialchars($this->rows['status']);
            $this->sex = htmlspecialchars($this->rows['sex']);
            $this->dob = htmlspecialchars($this->rows['dob']);
            $this->avatar = $this->getAvatar();

            $this->details = array(
                "id" => $this->id,
                "student id" => $this->student_id,
                "firstname" => $this->firstname,
                "middle name" => $this->middlename,
                "surname" => $this->surname,
                "school" => $this->school,
                "class of" => $this->class_of,
                "class_name" => $this->class_name,
                "sex" => $this->sex,
                "dob" => $this->dob,
                "home" => $this->home,
                "cell number" => $this->cell,
                "email" => $this->email,
                "avatar" => $this->avatar,
                "status" => $this->status
            );
            array_push($this->student_details, $this->details);
        }
        return $this->student_details;
    }

    /**
     * Get status of a students account
     * @param type $account_id
     * @return string|boolean
     */
    public function getAccountStatus($account_id)
    {
        $this->student_id = mysqli_real_escape_string($this->con, $account_id);

        $this->sql = "SELECT status FROM students WHERE `id`='$account_id' ";

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        } else {
            $this->dataset = mysqli_fetch_array($this->executeQuery, MYSQL_ASSOC);

            return $this->dataset["status"];
        }
    }

    /**
     * Get picture of a student
     * @return type
     */
    public function getAvatar($name = NULL)
    {

        if (isset($this->rows)) {
            $name = htmlspecialchars($this->rows['piclink'], ENT_QUOTES, 'UTF-8');
        }

        $this->piclink = AVATARS_FOLDER_URL . "/200x200_$name";
        $this->directory_location = AVATARS_FOLDER . "/200x200_$name";
        if (is_file($this->directory_location) && file($this->directory_location)) {
            return $this->piclink;
        } else {
            //return $this->piclink;
            return AVATARS_FOLDER_URL . "/default.png";
        }
    }

    /**
     * this function updates student status based on the year they are set to graduate. If they are past that year they are updated as graduated.
     * Reliability of this function is not important.
     */
    private function cronStudentStatus()
    {
        $current_year = date("Y");
        $this->sql = "UPDATE `students` SET `status` = 'graduated' WHERE `class of`<'$current_year' && school='$this->auth_school_id'";

        mysqli_autocommit($this->con, FALSE);

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }
        if (mysqli_affected_rows($this->con) > 1) {
            mysqli_commit($this->con);
            return TRUE;
        } else {
            mysqli_rollback($this->con);
            return FALSE;
        }
    }

}
