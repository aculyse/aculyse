<?php

/**
  * @author Blessing Mashoko <projects@bmashoko.com>
  *
  * This class provides mechanisms to manupulate sessions
*/

namespace Aculyse;

use Aculyse\Config;
use Aculyse\Database;
use Aculyse\AccessLevels;
use Aculyse\Loggers\Log;
use Aculyse\Models\User;
use Aculyse\ErrorReporting;
use Aculyse\Traits\Eloquent;
use Aculyse\Loggers\AccessLogger;
use Aculyse\Interfaces\ISessionAuth;

  require_once __DIR__ . "/Config.php";
  require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php"; 


final class AccessManager implements ISessionAuth {

    use Eloquent;

    private static $rights = AccessLevels::LEVEL_NO_ACCESS;
    protected static $salt, $token_str;
    protected static $token, $checksum;
    protected static $transaction_token;
    private static $home_page, $rights_array;
    private $sql, $rows;

    public function __construct() {

        $this->startEloquent();
        $this->newConnection = new \Aculyse\Database();
        $this->newConnection->connectDatabase();
        $this->con = $this->newConnection->connection;
    }

    /**
     * Provide access level number and default root page for the user
     * @param string $access_level
     * @return array
     */
    public static function grantRights($access_level) {
        //lock before authenticating
        self::$rights = AccessLevels::LEVEL_NO_ACCESS;
        self::$home_page = "/";

        switch ($access_level) {
            case 'lecturer':
                self::$rights = AccessLevels::LEVEL_WRITE_ANALYTICS;
                self::$home_page = LECTURER_HOME_URL;
                break;

            case 'student_manager':
                self::$rights = AccessLevels::LEVEL_WRITE_STUDENTS;
                self::$home_page = RECORDS_PERSONEL_HOME_URL;
                break;

            case 'principal':
                self::$rights = AccessLevels::LEVEL_UNIVERSAL_READ_ONLY;
                self::$home_page = PRINCIPALS_HOME_URL;
                break;


            case 'admin':
                self::$rights = AccessLevels::LEVEL_ADMIN_ONLY;
                self::$home_page = ADMIN_HOME_URL;
                break;

            case 'single':
                self::$rights = AccessLevels::LEVEL_SINGLE_MODE;
                self::$home_page = SINGLE_HOME_URL;
                break;

            case 'guardian':
                self::$rights = AccessLevels::LEVEL_GUARDIAN;
                self::$home_page = GUARDIAN_HOME_URL;
                break;

            default:
                self::$rights = AccessLevels::LEVEL_NO_ACCESS;
                self::$home_page = HOST_URL;
                break;
        }
        self::$rights_array = array("right" => self::$rights, "home" => self::$home_page);
        return self::$rights_array;
    }

    /**
     * Start a new session
     * @param string $user_id
     * @param string $access_level
     * @return TRUE on success and FALSE on failure
     */
    public static function startSession($user_id, $access_level, $school, $user_num_id, $school_details) {
        ini_set('session.use_only_cookies', TRUE);
        @ini_set('session.use_trans_sid', FALSE);
        @session_start();

        switch ($access_level) {

            case AccessLevels::LECTURER:
                $access_level = "lecturer";
                break;

            case AccessLevels::STUDENT_MANAGER:
                $access_level = "student_manager";
                break;

            case AccessLevels::PRINCIPAL:
                $access_level = "principal";
                break;

            case AccessLevels::ADMINSTRATOR:
                $access_level = "admin";
                break;

            case AccessLevels::SINGLE_USER:
                $access_level = "single";
                break;

            case AccessLevels::LEVEL_GUARDIAN:
                $access_level = "guardian";
                break;

            default:
                return FALSE;
                break;
        }

        self::$checksum = sha1($user_id . $access_level);
        self::$token_str = strval(SESSION_KEY . SALT);
        self::$token = sha1(self::$token_str);
        self::$transaction_token = sha1(self::$checksum . self::$token_str . self::$token);


        $_SESSION['user'] = array(
            "id" => $user_id,
            "user_num_id" => $user_num_id,
            "access_level" => self::grantRights($access_level),
            "checksum" => self::$checksum,
            "token" => self::$token,
            "transaction_token" => self::$transaction_token,
            "school" => $school,
            "school info" => $school_details,
            "random_key" => sha1(rand(1, 10000)),
            "switch_key" => hash("sha512", rand(1, 100000)),
            "is_demo" => DEMO,
            "production_key" => PRODUCTION_KEY
        );

        $Auth = new AccessManager();
        $Auth->saveSessionPayload($user_id);
        if (isset($_SESSION['user']) == TRUE) {
            $AccessLogger = new Log();
            $AccessLogger->access("Log in");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Check if active session is valid, Important to counter session hijacking or fixation
     * @return TRUE on success and FALSE on failure
     */
    public static function isSessionValid() {
        @session_start();
        //check if  token is still valid
        $expected_token = sha1(strval(SESSION_KEY . SALT));
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["token"]) && isset($_SESSION["user"]["checksum"])) {
            if ($expected_token === $_SESSION["user"]["token"] 
                && $_SESSION["user"]["is_demo"] === FALSE 
                && $_SESSION["user"]["production_key"] === PRODUCTION_KEY
                ) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Give details of current session
     * @deprecated since version 2 use Aculyse\Helpers\Auth\ActiveSession instead
     */
    public static function getLoggedInUser() {
        @session_start();
        return $_SESSION;
    }

    /**
     * @deprecated since version 2 use Aculyse\Helpers\Auth\ActiveSession instead
     * @return type
     */
    protected static function getSchoolLevel() {
        @session_start();
        return $_SESSION;
    }

    /**
     * Destroy active session
     * @return TRUE on success and FALSE on failure
     */
    public static function destroySession() {
        @session_start();
        $AccessLogger = new Log();
        $AccessLogger->access("Logout");

        session_destroy();
        if (!isset($_SESSION['user'])) {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getSchoolDetails($school_id) {

        $this->school_id = mysqli_real_escape_string($this->con, $school_id);

        $this->sql = "SELECT * FROM schools WHERE id='$this->school_id'";
        $this->result = mysqli_query($this->con, $this->sql);

        if (!$this->result) {
            return "SQLExecutionException";
        }
        if (mysqli_num_rows($this->result) == 1) {
            $rows = mysqli_fetch_assoc($this->result);
            return $rows;
        } else {
            return FALSE;
        }
    }

    /**
     * check if a user is authenticated from the database,
     * @param string $username
     * @param string $password
     * @param string verification the key to login for the first time
     * @return object
     */
    public function isUserCredentialsValid($username, $password, $verification = FALSE) {
        $result = User::where("username", $username)
                ->where("password", $password)
                ->get()
                ->first();
        return $result;
    }

    /**
     * Save the session data into the database
     */
    public function saveSessionPayload($user_id) {
        $this->payload = mysqli_real_escape_string($this->con, json_encode($_SESSION));
        $this->user_id = mysqli_real_escape_string($this->con, $user_id);
        $this->session_key = mysqli_real_escape_string($this->con, $_SESSION["user"]["switch_key"]);
        $this->sql = "UPDATE users SET session='$this->payload', session_key='$this->session_key' WHERE `username`='$this->user_id' ";

        $this->executeQuery = mysqli_query($this->con, $this->sql);
    }

    /**
     * delete the session payload
     */
    public function destroySessionPayload($user_id) {
        $this->user_id = mysqli_real_escape_string($this->con, $user_id);
        $this->sql = "UPDATE users SET session='' WHERE `username`='$this->user_id' ";

        $this->executeQuery = mysqli_query($this->con, $this->sql);
    }

    /**
     * Update user password
     * @param string $username
     * @param string $old_password
     * @param string $new_password
     * @return JSON object
     */
    public function changePassword($username, $old_password, $new_password) {
        $this->username = mysqli_real_escape_string($this->con, $username);
        $this->old_password = mysqli_real_escape_string($this->con, $old_password);
        $this->new_password = mysqli_real_escape_string($this->con, $new_password);

        $this->encrypt_password = $this->encryptPassword($old_password);

        //check if old password is correct
        if (!$old_password == SALT) {
            if (!is_object($this->isUserCredentialsValid($this->username, $this->encrypt_password))) {
                return '{"status":"OldPasswordMismatchException"}';
            }
        }

        $this->encrypted_new_password = $this->encryptPassword($this->new_password);

        $this->sql = "UPDATE users SET password='$this->encrypted_new_password' WHERE `username`='$this->username' ";

        mysqli_autocommit($this->con, FALSE);
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return '{"status":"SQLExecutionException"}';
        }

        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            return '{"status":"success"}';
        } else {
            mysqli_rollback($this->con);
            return '{"status":"failed"}';
        }
    }

    /**
     * generate password reset key and save it
     * @todo make mechanism for password recovery will be availbale latter
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function generatePasswordResetKey($username) {
        $this->reset_key = mysqli_real_escape_string($this->con, sha1(SALT . rand(2000, 8000)));
        $this->username = mysqli_real_escape_string($this->con, $username);

        $this->reset_json = json_encode(array("key" => $this->reset_key, "generated" => date('d-m-Y')));

        $this->sql = "UPDATE users SET reset_key='$this->reset_json' WHERE `username`='$this->username' ";

        mysqli_autocommit($this->con, FALSE);
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return '{"status":"SQLExecutionException"}';
        }

        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            return '{"status":"success"}';
        } else {
            mysqli_rollback($this->con);
            return '{"status":"failed"}';
        }
    }

    /**
     * Retrieve password reset key from the database
     */
    public function getResetKey($username) {
        $this->username = mysqli_real_escape_string($this->con, $username);

        $this->sql = "SELECT reset_key FROM users WHERE username='$this->username'";

        $this->result = mysqli_query($this->con, $this->sql);

        if (!$this->result) {
            return "SQLExecutionException";
        }

        if (mysqli_num_rows($this->result) == 1) {
            $rows = mysqli_fetch_assoc($this->result);
            if (isset($rows["reset_key"])) {
                return json_decode($rows["reset_key"]);
            } else {
                return json_encode(array("status" => "NoKeySpecifiedExcep"));
            }
            return $rows;
        } else {
            return json_encode(array("status" => "UserNotFoundException"));
        }
    }

    /**
     * Apply sha1 encryption to create password hash
     * @param type $username
     * @param type $password
     * @return type
     */
    public function encryptPassword($password) {
        $this->encrypted_password = sha1(SALT . $password);
        return $this->encrypted_password;
    }

}
