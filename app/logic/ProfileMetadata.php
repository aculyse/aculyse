<?php

namespace Aculyse {

    require_once "database.php" ;
    require_once "AccessManager.php" ;
    require_once "Config.php" ;

    class ProfileMetadata
    {

        public function __construct()
        {
            $this->newConnection = new \Aculyse\Database() ;
            $this->newConnection->connectDatabase() ;
            $this->con = $this->newConnection->connection ;
            @session_start() ;

            $this->auth_school_id = AccessManager::getLoggedInUser()["user"]["school"] ;
            $this->auth_school_id = mysqli_real_escape_string($this->con , $this->auth_school_id) ;
        }

        /**
         * add more information about a profiles
         * @param [type] $profile_id [unique ID of the profile]
         * @param [type] $test_num   [test number from 1-10]
         * @param array  $data       [the data to add]
         */
        public function add( array $data )
        {

            $profile_id = mysqli_real_escape_string($this->con , $data["profile_id"]) ;
            $test_num = mysqli_real_escape_string($this->con , $data["test_num"]) ;
            $name = mysqli_real_escape_string($this->con , $data["name"]) ;
            $description = mysqli_real_escape_string($this->con , $data["desc"]) ;

            $this->sql = "INSERT INTO `profile_metadata`(`profile id`, `test_num`, `name`, `description`) VALUES('$profile_id','$test_num','$name','$description')" ;

            $this->executeQuery = mysqli_query($this->con , $this->sql) ;

            if(!$this->executeQuery) {
                return json_encode(array("status" => "SQLExecutionExecution")) ;
            }
            if(mysqli_affected_rows($this->con) >= 1) {

                return json_encode(array("status" => "success" , "insert_id" => mysqli_insert_id($this->con))) ;
            }
            else {
                return json_encode(array("status" => "failed")) ;
            }
        }
        
        /**
         * get the metadata of a profile
         * @param int $profile_id
         */
        
        public function get( $profile_id )
        {
            $this->profile_id = mysqli_real_escape_string($this->con , $profile_id) ;

            $this->sql = "SELECT * FROM profile_metadata WHERE `profile id`='$this->profile_id'" ;

            $this->executeQuery = mysqli_query($this->con , $this->sql) ;
            if(!$this->executeQuery) {
                return json_encode(array("status" => "SQLExecutionExecution")) ;
            }
            if(mysqli_num_rows($this->executeQuery) == 0) {

                return json_encode(array("status" => "NoRowsFound")) ;
            }
            $this->dataset = array() ;
            while($this->rows = mysqli_fetch_array($this->executeQuery , MYSQLI_ASSOC)) {
                array_push($this->dataset , $this->rows) ;
            }
            return $this->dataset ;
        }
    }
}