<?php

namespace Aculyse\Loggers;

class AccessLogger
{

    public function __construct()
    {
        if (file_exists("logic/database.php")) {
            $path_prefix = "";
        } elseif (file_exists("../logic/database.php")) {
            $path_prefix = "../";
        } else {
            die("The app could not find a secure way to the servers");
        }
        require_once $path_prefix . "logic/database.php";
        require_once $path_prefix . "logic/Config.php";


        $this->newConnection = new \Aculyse\Database();
        $this->newConnection->connectDatabase();
        $this->con = $this->newConnection->connection;

        @session_start();
        @$this->user_id = $_SESSION["user"]["user_num_id"];
    }

    /**
     * Save activities like logins and logouts from the system
     * @param  [type]  $message description of event
     * @param  integer $user_id the user who initiated it
     */
    public function saveLog($message, $user_id = 0)
    {

        $this->user_id = mysqli_real_escape_string($this->con, $this->user_id);
        $this->ip_address = mysqli_real_escape_string($this->con, $_SERVER['REMOTE_ADDR']);
        $this->user_agent = mysqli_real_escape_string($this->con, $_SERVER['HTTP_USER_AGENT']);
        $this->message = mysqli_real_escape_string($this->con, $message);

        $this->sql = "INSERT INTO `access log` (`user`,`ip address`,`browser`,`message`) VALUES('$this->user_id','$this->ip_address','$this->user_agent','$this->message')";

        mysqli_autocommit($this->con, FALSE);
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return FALSE;
        }

        if (mysqli_affected_rows($this->con) == 1) {
            mysqli_commit($this->con);
            return TRUE;
        } else {
            mysqli_rollback($this->con);
            return FALSE;
        }
    }
}
