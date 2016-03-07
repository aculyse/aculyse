<?php

namespace Aculyse {
    //require_once '../vendor/autoload.php';

    class UserIdentifier
    {

        function __construct()
        {
            $this->newConnection = new Database() ;
            $this->newConnection->connectDatabase() ;
            $this->con = $this->newConnection->connection;

            @session_start() ;
            $this->username = mysqli_real_escape_string($this->con , $_SESSION['user']['user_num_id']) ;
            $this->access_level = mysqli_real_escape_string($this->con , $_SESSION['user']['access_level']["right"]) ;
        }

        function lecturerSubjects()
        {
            $this->sql = "SELECT * FROM `trs and subjects` where `teacher_id`='$this->username'" ;
            $this->executeQuery = mysqli_query($this->con , $this->sql) ;

            if(!$this->executeQuery) {
                return FALSE ;
            }
            $this->dataset = array() ;
            while($this->rows = mysqli_fetch_array($this->executeQuery , MYSQLI_ASSOC)) {
                array_push($this->dataset , $this->rows) ;
            }
            return $this->dataset ;
        }

        function subjectLookup()
        {
            $subjects_codes = $this->lecturerSubjects() ;

            $this->subjects = array() ;
            for($i = 0 ; $i <= sizeof($subjects_codes) - 1 ; $i++) {
                $subject_id = $subjects_codes[$i]["subject"] ;
                $this->sql = "SELECT * FROM `subjects` where `id`='$subject_id'" ;
                $this->executeQuery = mysqli_query($this->con , $this->sql) ;

                if(!$this->executeQuery) {
                    return FALSE ;
                }

                while($this->rows = mysqli_fetch_array($this->executeQuery , MYSQLI_ASSOC)) {
                    array_push($this->subjects , $this->rows) ;
                }
            }

            return $this->subjects ;
        }

        public function getTeacherClasses( $class_id = NULL )
        {
            $this->class_id = mysqli_real_escape_string($this->con , $class_id) ;
            $this->classes = array() ;

            if(!empty($class_id)) {
                $this->sql = "SELECT * FROM `trs and subjects` where `class`='$this->class_id'" ;
            }
            else {
                $this->sql = "SELECT * FROM `trs and subjects` where `teacher_id`='$this->username'" ;
            }
            $this->executeQuery = mysqli_query($this->con , $this->sql) ;


            if(!$this->executeQuery) {
                return FALSE ;
            }

            while($this->rows = mysqli_fetch_array($this->executeQuery , MYSQLI_ASSOC)) {
                array_push($this->classes , $this->rows) ;
            }


            return $this->classes ;
        }
    }
}