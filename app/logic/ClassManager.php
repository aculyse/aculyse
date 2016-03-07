<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * Manage information about classes as well as allocating classed to teachers and students
 */

namespace Aculyse;

use Aculyse\Config;
use Aculyse\Database;
use Aculyse\AccessManager;
use Aculyse\Traits\Eloquent;
use Aculyse\Traits\DBConnection;
use Aculyse\Models\TeacherClasses;
use Aculyse\Loggers\ActivityLogger;
use Aculyse\Interfaces\IClassManager;
use Aculyse\Helpers\Auth\ActiveSession;

require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

class ClassManager implements IClassManager
{
    use Eloquent,
        DBConnection;

    public function __construct()
    {
        $this->startEloquent();
        $this->ActivityLogger = new ActivityLogger();

        $this->con = $this->databaseInstance();

        @session_start();
        $this->auth_school_id = ActiveSession::school();
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);
    }

    public function getTeacherSubject($teacher_id, $get_class_id = NULL)
    {

        $allocations = TeacherClasses::where("teacher_id",$teacher_id)
                                        ->with("user_info","class_info","subject_info")
                                        ->get();

        return $allocations;

        $this->teacher_id = mysqli_real_escape_string($this->con, $teacher_id);
        $this->get_class_id = mysqli_real_escape_string($this->con, $get_class_id);

        if (is_int($get_class_id)) {
            $this->sql = "SELECT * FROM teacher_with_their_subjects WHERE `teacher_id`='$this->teacher_id' && `id`='$this->get_class_id'";
        } else {
            $this->sql = "SELECT * FROM teacher_with_their_subjects WHERE `teacher_id`='$this->teacher_id' && deleted='no'";
        }
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return FALSE;
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }
        $this->dataset = array();
        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {
            array_push($this->dataset, $this->rows);
        }

        return $this->dataset;
    }

    public function getAllSubjects()
    {
        $this->sql = "SELECT * FROM subjects ORDER BY `title` ASC";

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return FALSE;
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }
        $this->dataset = array();
        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {
            array_push($this->dataset, $this->rows);
        }

        return $this->dataset;
    }

    public function getClassesOfferedAtSchool($query = NULL)
    {

        $this->school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);
        $query = mysqli_real_escape_string($this->con, $query);

        $this->sql = "SELECT * FROM classes WHERE school='$this->school_id' ORDER BY `class_name` ASC";
        if (!is_null($query)) {
            $this->sql = "SELECT * FROM classes WHERE school='$this->school_id' && `class_name` LIKE '%$query%' ORDER BY `class_name` ASC";
        }
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return FALSE;
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }
        $this->dataset = array();
        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {
            array_push($this->dataset, $this->rows);
        }

        return $this->dataset;
    }

    private function checkClassStatus($subject, $teacher_id, $class_id)
    {

        $count= TeacherClasses::where("teacher_id",$teacher_id)
                                ->where("subject",$subject)
                                ->where("class",$class_id)
                                ->count();

        if($count==0){
            return TRUE;
        }
        return FALSE;
    }

    public function allocateClassToTeacher($subject, $class_id, $teacher_id)
    {
    
        $this->subject_id = mysqli_real_escape_string($this->con, $subject);
        $this->teacher_id = mysqli_real_escape_string($this->con, $teacher_id);
        $this->class_id = mysqli_real_escape_string($this->con, $class_id);
        //$this->class_name = mysqli_real_escape_string($this->con , $class_name);
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);

        $class_status = $this->checkClassStatus($this->subject_id, $this->teacher_id, $this->class_id);

        if ($class_status != TRUE) {
            return json_encode(array("status" => "TAKEN"));
        }

        $this->sql = "INSERT INTO `trs and subjects`(teacher_id,subject,class) VALUES('$this->teacher_id','$this->subject_id','$this->class_id')";

        //mysqli_autocommit($this->con , FALSE) ;
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {

            return json_encode(array("status" => "SQLExecutionException"));
        }

        if (mysqli_affected_rows($this->con) == 1) {
            //  mysqli_commit($this->con) ;
            $insert_id = mysqli_insert_id($this->con);
            $subject_info = $this->getTeacherSubject($this->teacher_id, $insert_id);
            $subject_name = $subject_info[0]["title"];
            $class_name = $this->getClassDetails($subject_info[0]["class"]);
            return json_encode(array("status" => "success", "subject" => $subject_name, "class" => $class_name[0]["class_name"], "class_id" => $class_name[0]["class_id"]));
        } else {
            //mysqli_rollback($this->con) ;
            return json_encode(array("status" => "failed"));
        }
    }

    public function deallocateSubjectToTeacher($id)
    {
        $this->id = mysqli_real_escape_string($this->con, $id);

        $this->sql = "DELETE FROM  `trs and subjects` WHERE id='$this->id' LIMIT 1 ";

        mysqli_autocommit($this->con, FALSE);
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }

        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            $this->ActivityLogger->saveActivity("delete", "teachers and subjects", "removed association with id [$this->id]");

            return "success";
        } else {
            mysqli_rollback($this->con);
            return "failed";
        }
    }

    public function getClassDetails($class_id, $get_class_students = FALSE)
    {

        $this->class_id = mysqli_real_escape_string($this->con, $class_id);

        if ($get_class_students == TRUE) {
            $this->sql = "SELECT DISTINCT `class of` FROM students WHERE `class_name`='$this->class_id' && `school`='$this->auth_school_id'";
        } else {
            $this->sql = "SELECT * FROM classes WHERE `class_id`='$this->class_id' && `school`='$this->auth_school_id'";
        }

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }
        $this->dataset = array();
        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {
            array_push($this->dataset, $this->rows);
        }

        return $this->dataset;
    }

    private function isClassAvailable($class_name)
    {

        $this->class_name = mysqli_real_escape_string($this->con, $class_name);
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);

        $this->sql = "SELECT * FROM classes WHERE `class_name`='$this->class_name' && `school`='$this->auth_school_id'";

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function createClass($class_name, $class_desc, $level)
    {
        $this->class_name = mysqli_real_escape_string($this->con, $class_name);
        $this->class_desc = mysqli_real_escape_string($this->con, $class_desc);
        $this->class_level = mysqli_real_escape_string($this->con, $level);
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);

        if ($this->isClassAvailable($this->class_name) != TRUE) {
            return ACCOUNT_TAKEN;
        }

        $this->sql = "INSERT INTO `classes`(`class_name`,`school`,`desc` ,`level` ) VALUES('$this->class_name','$this->auth_school_id','$this->class_desc','$this->class_level')";

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }

        if (mysqli_affected_rows($this->con) == 1) {
            return "success";
        } else {
            mysqli_rollback($this->con);
            return "failed";
        }
    }

    protected function removeClass()
    {
        
    }

    public function testORM(){

        return TeacherClasses::with('subject_info','user_info','class_info')->get();
    }

}
