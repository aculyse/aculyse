<?php

namespace Aculyse;

use Aculyse\Users;
use Aculyse\Config;
use Aculyse\Database;
use Aculyse\AccessManager;
require_once __DIR__."/Config.php";
require_once __DIR__."/Validate.php";
require_once __DIR__."/AccessManager.php";
require_once dirname(dirname(__DIR__))."/vendor/autoload.php";

class SchoolManager extends Users
{
    var $admin_name ;
    var $admin_email ;
    var $admin_password ;
    var $school_name ;
    var $school_type ;
    var $error_arr ;
    var $admin_username ;

    function __construct()
    {
        $this->newConnection = new Database() ;
        $Security = new AccessManager() ;
        $this->newConnection->connectDatabase() ;
        $this->con = $this->newConnection->connection ;
    }

    public function validateAccountInfo( array $data )
    {
        //get school information
        $this->admin_name = mysqli_real_escape_string($this->con , $data["name"]) ;
        $this->admin_email = mysqli_real_escape_string($this->con , $data["email"]) ;
        $this->admin_username = mysqli_real_escape_string($this->con , $data["username"]) ;
        $this->admin_password = mysqli_real_escape_string($this->con , $data["pwd"]) ;
        $this->school_name = mysqli_real_escape_string($this->con , $data["school name"]) ;
        $this->school_type = mysqli_real_escape_string($this->con , $data["school type"]) ;

        //validate the school information
        $this->errors_arr = array() ;
        if(Validate::validatePersonName($this->admin_name , TRUE) == FALSE) {
            array_push($this->errors_arr , "Firstname is invalid make sure there are no numbers or symbols") ;
        }

        if(Validate::validateEmail($this->admin_email , TRUE) == FALSE) {
            array_push($this->errors_arr , "Email is required") ;
        }

        if(Validate::validatePasswordCriteria($this->admin_password) == FALSE) {
            array_push($this->errors_arr , "Password should be at least 6 characters") ;
        }

        if(Validate::validateUsernameCriteria($this->admin_username) == FALSE) {
            array_push($this->errors_arr , "Username should be at least 6 characters") ;
        }

        if(empty($this->school_name)) {
            array_push($this->errors_arr , "School name is required") ;
        }

        if(empty($this->school_type) || $this->school_type == "") {
            array_push($this->errors_arr , "School type is required") ;
        }
        return $this->errors_arr ;
    }

    public function createAccount( array $data )
    {

        $Security = new AccessManager() ;
        $validation = $this->validateAccountInfo($data) ;

        if(sizeof($validation) > 0) {
            return  json_encode($validation);
        }

        $this->admin_name = mysqli_real_escape_string($this->con , $data["name"]) ;
        $this->admin_email = mysqli_real_escape_string($this->con , $data["email"]) ;
        $this->admin_username = mysqli_real_escape_string($this->con , $data["username"]) ;
        $this->admin_password = mysqli_real_escape_string($this->con , $data["pwd"]) ;
        $this->school_name = mysqli_real_escape_string($this->con , $data["school name"]) ;
        $this->school_type = mysqli_real_escape_string($this->con , $data["school type"]) ;
        $this->access_level = AccessLevels::ADMINSTRATOR ;
        $this->encrypted_pwd = $Security->encryptPassword($this->admin_password) ;


        if($this->isAccountTaken($this->admin_username) !== ACCOUNT_AVAILABLE) {
            return '{"status":"'.ACCOUNT_TAKEN.'"}' ;
        }

        //start transaction
        mysqli_autocommit($this->con , FALSE) ;
        //initialise errors in sql statements as zero
        $sql_errors = 0 ;
        $this->sql = "INSERT INTO `schools`(`name`, `level`) VALUES('$this->school_name','$this->school_type')" ;


        $this->executeQuery = mysqli_query($this->con , $this->sql) ;

        if(!$this->executeQuery) {
            $sql_errors +=1 ;
        }

        if(mysqli_affected_rows($this->con) != 1) {
            $sql_errors +=1 ;
        }

        $school_id = mysqli_real_escape_string($this->con , mysqli_insert_id($this->con)) ;
        $verification_key = mysqli_real_escape_string($this->con,$this->generateVerificationKey());

        //run second query
        $this->sql2 = "INSERT INTO `users`("
                . "`fullname`,"
                . "`username`,"
                . "`email`, "
                . "`password`, "
                . "`access level`, "
                . "`status`,`school`,verification_code) "
                . "VALUES ('$this->admin_name',"
                . "'$this->admin_username',"
                . "'$this->admin_email',"
                . "'$this->encrypted_pwd',"
                . "'$this->access_level',"
                . "'activated','$school_id','$verification_key')" ;


        $this->executeQuery2 = mysqli_query($this->con , $this->sql2) ;

        if(!$this->executeQuery2) {
            $sql_errors +=1 ;
        }

        if(mysqli_affected_rows($this->con) != 1) {
            $sql_errors +=1 ;
        }

        ///check for errors
        if($sql_errors == 0) {
            mysqli_commit($this->con) ;
            return '{"status":"success"}' ;
        }
        else {
            mysqli_rollback($this->con) ;
            return '{"status":"failed"}' ;
        }
    }

    /**
    *Send verification message
    */
    public function sendVerificationCode($user, $email_address, $key){
      $this->secret_key = $key;
      $this->reset_url = HOST_URL . "/verify.php?user=$user&key=$this->secret_key&mail_link=true";

      // Send to?
      $to = $email_address;
      // The Subject
      $subject = "Password reset";

      // The message
      $message = "<h3>Welcome to Aculyse</h3>
        <h4>Dear $user</h4>
          <br/><br/>Congratulations on signing up with Aculyse. To get started please follow any of the 2 options<br/>
      1. Click here <a href='$this->reset_url' target='blank'>this link.</a><br/>
      2. Copy and paste this address <b>$this->reset_url</b> on your browser
              <br/>
              <br/>
              <
              ";

      // In case any of our lines are larger than 70 characters, we should use wordwrap()
      $message = wordwrap($message, 170);

      // Send email
      // Returns TRUE if the mail was successfully accepted for delivery, FALSE otherwise.
      if (mail($to, $subject, $message)) {
          return TRUE;
      } else {
          retuRN FALSE;
      }
    }

    /**
  *Generate the key to be used for verification key purpose
  */
    public function generateVerificationKey() {
        $this->verification_key = hash('sha512',SALT . rand(2000, 8000));
        return $this->verification_key;
    }
}
