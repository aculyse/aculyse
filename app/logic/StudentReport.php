<?php

namespace Aculyse{

use Aculyse\Traits\DBConnection;

    class StudentReport
    {

        use DBConnection;
        public $student ;
        private $sql , $executeQuery ;

         function __construct()
    {
        $this->con = $this->databaseInstance();
    }

        function getStudentMarks( $student , $subject = NULL , $profile_id = NULL , $full_report = FALSE )
        {
            $this->student = mysqli_real_escape_string($this->con , $student) ;
            $this->subject = mysqli_real_escape_string($this->con , $subject) ;
            $this->profile_id = mysqli_real_escape_string($this->con , $profile_id) ;

            if($full_report == TRUE) {
                $this->sql = "SELECT * FROM profiles_and_marks WHERE `student id`='$this->student' && status='closed' ORDER BY year DESC,term DESC " ;
            }
            else {
                $this->sql = "SELECT * FROM marks WHERE `student id`='$this->student' && `profile id`='$this->profile_id'" ;
            }
            $this->executeQuery = mysqli_query($this->con , $this->sql) ;

            if(!$this->executeQuery) {

                return FALSE ;
            }

            if(mysqli_num_rows($this->executeQuery) == 0) {
                return FALSE ;
            }

            $this->tempo_arr = array() ;
            while($this->results = mysqli_fetch_array($this->executeQuery , MYSQL_ASSOC)) {
                array_push($this->tempo_arr , $this->results) ;
            }
            return $this->tempo_arr ;
        }
    }
}
