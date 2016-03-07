<?php
/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * @version 2.0.0
 * @package Aculyse Turmeric Edition
 */

namespace Aculyse\Interfaces
{

    interface ISessionAuth
    {

        public static function grantRights( $access_level ) ;

        public static function startSession( $user_id , $access_level , $school , $user_num_id , $school_details ) ;

        public static function isSessionValid() ;

        public static function destroySession() ;
    }

    interface IProfiler
    {

        public function isProfileNotTaken( array $arg ) ;

        public function getClassStudents( array $arg ) ;

        public function initializeProfile( $students , array $profile_data , $status = "in progress" ) ;

        public function addIndividualInProfile( $college_num ) ;

        public function getProfileMarks( array $criteria_params , $student = NULL , $extremes = NULL , $search = NULL ) ;

        public function updateMark( $id , $column , $value , $is_final , $profile_id ) ;

        public function compileProfile( array $profile_data , $course_work_weight = 30 , $final_exam_weight = 70 ) ;
    }

  
    interface ISchoolManager
    {

        public function validateAccountInfo( array $data ) ;

        public function createAccount( array $data ) ;
    }
}
