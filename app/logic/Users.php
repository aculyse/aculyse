<?php

/**
 * Manage user accounts
 *
 * @author Mashoko Blessing <bmashcom@hotmail.com>
 * @version 2.0.0
 *
 */

namespace Aculyse;

use Aculyse\Validate;
use Aculyse\Traits\DBConnection;
use Aculyse\Loggers\ActivityLogger;
use Aculyse\Models\User;
use Aculyse\Traits\Eloquent;
use Aculyse\Helpers\Auth\ActiveSession;

require_once dirname(__DIR__) . "/logic/AccessManager.php";
require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

class Users
{

    use DBConnection,
        Eloquent;

    public $Security;

    function __construct()
    {
        $this->startEloquent();
        $this->Security = new AccessManager();
        $this->con = $this->databaseInstance();
        $this->auth_school_id = ActiveSession::school();
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);
    }

    public function active(){
        $user = User::find(ActiveSession::id());
        return $user;
    }

    function getUsers($search_term = NULL)
    {

        if (!is_null($search_term)) {
            $this->search_term = mysqli_real_escape_string($this->con, $search_term);
            $this->sql = "SELECT `fullname`, `sex`, `cell number`, `email`, `piclink`, `username`, `access level`, `teacher id`,`status` FROM users WHERE school='$this->auth_school_id' && (username LIKE  '%$this->search_term%' "
                    . "OR fullname LIKE  '%$this->search_term%' "
                    . "OR email LIKE  '%$this->search_term%')";
        } else {
            $this->sql = "SELECT `fullname`, `sex`, `cell number`, `email`, `piclink`, `username`, `access level`, `teacher id`,`status` FROM users WHERE school='$this->auth_school_id'";
        }

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {

            return FALSE;
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }

        $this->user_details = array();

        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {

            array_push($this->user_details, $this->rows);
        }
        return $this->user_details;
    }

    /**
     * update user access level
     * @param type $account
     * @param type $new_access_level
     * @return string|boolean
     */
    public function updateAccessLevel($account, $new_access_level)
    {
        $this->account = mysqli_real_escape_string($this->con, $account);
        $this->new_access_level = mysqli_real_escape_string($this->con, $new_access_level);

        $this->sql = "UPDATE `users` SET `access level` = '$this->new_access_level' WHERE `username` = '$this->account' && school='$this->auth_school_id'";

        mysqli_autocommit($this->con, FALSE);

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }
        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            // $this->ActivityLogger->saveActivity("update" , "users" , "changed the access level of user [$this->account] to level number is [$this->new_access_level]") ;
            return "Success";
        } else {
            mysqli_rollback($this->con);
            return "Failed";
        }
    }

    /**
     * reset password by generating a random 5 digit number and encrypting it.
     * @param string $account
     * @return boolean
     */
    function resetPassword($account)
    {

        $this->account = mysqli_real_escape_string($this->con, $account);
        $this->random_pwd = rand(1000000, 9999999);
        $this->encrypted_pwd = $this->Security->encryptPassword($this->random_pwd);

        $this->sql = "UPDATE users SET `password` = '$this->encrypted_pwd' WHERE `username` = '$this->account' && school='$this->auth_school_id' ";

        mysqli_autocommit($this->con, FALSE);

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return '{"status":"SQLExecutionException"}';
        }
        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);

            // $this->ActivityLogger->saveActivity("update" , "users" , "password reset for user $this->account") ;
            return '{"status":"success","data":' . "$this->random_pwd" . '}';
        } else {
            mysqli_rollback($this->con);
            return '{"status":"failed"}';
        }
    }

    /**
     * Validate data submitted about the user
     * @param  array  $user_data array of user data
     * @return array a hash of invalid entries
     */
    function validateData(array $user_data)
    {

        $this->firstname = mysqli_real_escape_string($this->con, $user_data["firstname"]);
        $this->middlename = mysqli_real_escape_string($this->con, $user_data["middlename"]);
        $this->surname = mysqli_real_escape_string($this->con, $user_data["surname"]);
        $this->sex = mysqli_real_escape_string($this->con, $user_data["sex"]);
        $this->contact_num = mysqli_real_escape_string($this->con, $user_data["contact_num"]);
        $this->email = mysqli_real_escape_string($this->con, $user_data["email"]);
        $this->access_level = mysqli_real_escape_string($this->con, $user_data["access_level"]);
        $this->username = mysqli_real_escape_string($this->con, $user_data["username"]);
        $this->password = mysqli_real_escape_string($this->con, $user_data["password"]);
        $this->auto_generate_credentials = mysqli_real_escape_string($this->con, $user_data["agc"]);

        $this->errors_arr = array();

        if (Validate::validatePersonName($this->firstname, TRUE) === FALSE) {
            array_push($this->errors_arr, "Firstname is invalid make sure there are no numbers or symbols");
        }
        if (Validate::validatePersonName($this->middlename, FALSE) === FALSE) {
            array_push($this->errors_arr, "Middlename is invalid make sure there are no numbers or symbols");
        }
        if (Validate::validatePersonName($this->surname, TRUE) === FALSE) {
            array_push($this->errors_arr, "Surname is invalid make sure there are no numbers or symbols");
        }

        if (Validate::validatePhoneNumber($this->contact_num, FALSE) === FALSE) {
            array_push($this->errors_arr, "Invalid phone number, only number are allowed");
        }
        if (Validate::validateSex($this->sex, TRUE) === FALSE) {
            array_push($this->errors_arr, "sex is required ");
        }

        if (Validate::validateEmail($this->email, FALSE) === FALSE) {
            array_push($this->errors_arr, "email address invalid");
        }

        //validate credentials if auto generation is disabled
        if ($this->auto_generate_credentials == 0) {
            if (strlen($this->username) < 6) {
                array_push($this->errors_arr, "username too short at least 6 characters required");
            }
            if (strlen($this->password) < 6) {
                array_push($this->errors_arr, "password too short at least 6 characters required");
            }
        }


        if ($this->access_level == 0) {
            array_push($this->errors_arr, "The access level is required");
        }

        return $this->errors_arr;
    }

    /**
     * Save data to the database, this should be done after validation
     * @param  array  $user_date
     */
    public function saveUser(array $user_data)
    {

        $this->firstname = mysqli_real_escape_string($this->con, $user_data["firstname"]);
        $this->middlename = mysqli_real_escape_string($this->con, $user_data["middlename"]);
        $this->surname = mysqli_real_escape_string($this->con, $user_data["surname"]);
        $this->sex = mysqli_real_escape_string($this->con, $user_data["sex"]);
        $this->contact_num = mysqli_real_escape_string($this->con, $user_data["contact_num"]);
        $this->email = mysqli_real_escape_string($this->con, $user_data["email"]);
        $this->access_level = mysqli_real_escape_string($this->con, $user_data["access_level"]);
        $this->username = mysqli_real_escape_string($this->con, $user_data["username"]);
        $this->password = mysqli_real_escape_string($this->con, $user_data["password"]);
        $this->auto_generate_credentials = mysqli_real_escape_string($this->con, $user_data["agc"]);
        $this->school = mysqli_real_escape_string($this->con, $this->auth_school_id);

//format name
        if (!empty($middlename)) {
            $this->fullname = $this->firstname . " " . $this->middlename . " " . $this->surname;
        } else {
            $this->fullname = $this->firstname . " " . $this->surname;
        }

        $this->password = $this->Security->encryptPassword($this->password);


        //auto generate credentials if option is enabled
        if ($this->auto_generate_credentials == 1) {

            $generated_credentials = $this->generateCredentials($this->firstname, $this->surname);
            if (is_array($generated_credentials)) {
                $this->username = $generated_credentials["username"];
                $this->password = $generated_credentials["password"];
            } else {

                return '{"status":"CredentialsGenerationException"}';
            }
        }


        //credentials are now available lets now check if the account in not taken already
        if ($this->isAccountTaken($this->username) !== ACCOUNT_AVAILABLE) {
             return '{"status":"'.ACCOUNT_TAKEN.'"}';
        }

        $this->sql = "INSERT INTO `users`("
                . "`fullname`,"
                . "`sex`, "
                . "`cell number`, "
                . "`email`, "
                . "`username`, "
                . "`password`, "
                . "`access level`, "
                . "`status`,`school`) "
                . "VALUES ('$this->fullname',"
                . "'$this->sex',"
                . "'$this->contact_num',"
                . "'$this->email',"
                . "'$this->username',"
                . "'$this->password',"
                . "'$this->access_level',"
                . "'activated','$this->auth_school_id')";

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            print_r(mysqli_error($this->con));
            return '{"status":"SQLExecutionException"}';
        }

        if (mysqli_affected_rows($this->con) == 1) {
            return '{"status":"success","username":"' . $this->username . '"}';
        } else {
            return '{"status":"failed"}';
        }
    }

    /**
     * Generate usernames and password, usually used during initial account creation
     * @param  string  $firstname   User's firstname
     * @param  string $surname     User's surname
     * @param  boolean $make_unique set to TRUE to append a unique number to the username, usually when account generated already taken.
     * @return array a combination of username and encrypted password.
     */
    private function generateCredentials($firstname, $surname, $make_unique = FALSE)
    {

        $this->a_firstname = mysqli_real_escape_string($this->con, $firstname);
        $this->a_surname = mysqli_real_escape_string($this->con, $surname);

        $this->initial = substr($this->a_firstname, 0, 1);

        //add a prefix at the end of the username incase where username is already taken
        if ($make_unique === TRUE) {
            $this->end_prefix = rand(10, 99);
            $this->username = ($this->initial . $this->a_surname . $this->end_prefix);
        } else {
            $this->username = strtolower($this->initial . $this->a_surname);
        }

        $this->random_pwd = rand(1000000, 9999999);
        $this->encrypted_pwd = $this->Security->encryptPassword($this->random_pwd);


        $this->credentials = array(
            "username" => $this->username,
            "password" => $this->encrypted_pwd
        );

        return $this->credentials;
    }

    /**
     * Determine if account is still available
     * @param  string  $national_id_num
     * @param  string  $username
     * @return boolean
     */
    public function isAccountTaken($username)
    {

        $this->c_username = mysqli_real_escape_string($this->con, $username);

        $this->sql = "SELECT COUNT(*) FROM users WHERE `username`='$this->c_username'";

        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return "SQLExecutionException";
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }

        while ($this->result = mysqli_fetch_array($this->executeQuery)) {
            $this->count = $this->result[0];
        }
        if ($this->count > 0) {
            return ACCOUNT_TAKEN;
        } else {
            return ACCOUNT_AVAILABLE;
        }
    }

    /**
     * Mark an account as deleted, note that deletion of records is determined by the flages
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    function deleteAccount($username)
    {
        $this->username = mysqli_real_escape_string($this->con, $username);

        $this->sql = "DELETE FROM users WHERE username='$this->username' && school='$this->auth_school_id' LIMIT 1";

        mysqli_autocommit($this->con, FALSE);
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return '{"status":"SQLExecutionException"}';
        }

        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);

            // $this->ActivityLogger->saveActivity("delete" , "users" , "deleted user with username [$this->username]") ;
            return '{"status":"success","data":"' . $this->username . '"}';
        } else {
            mysqli_rollback($this->con);
            return '{"status":"failed"}';
        }
    }

    /**
     * [changeSubjects description]
     * @param  [type] $username [description]
     * @param  [type] $subject1 [description]
     * @param  [type] $subject2 [description]
     * @return [type]           [description]
     */
    function changeSubjects($username, $subject1, $subject2)
    {
        $this->username = mysqli_real_escape_string($this->con, $username);
        $this->subject1 = mysqli_real_escape_string($this->con, $subject1);
        $this->subject2 = mysqli_real_escape_string($this->con, $subject2);

        $this->sql = "UPDATE users SET subject1='$this->subject1',subject2='$this->subject2' WHERE username='$this->username' && school='$this->auth_school_id'";

        mysqli_autocommit($this->con, FALSE);
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return '{"status":"SQLExecutionException"}';
        }

        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            return '{"status":"success","data":"' . $this->username . '"}';
        } else {
            mysqli_rollback($this->con);
            return '{"status":"failed"}';
        }
    }

}
