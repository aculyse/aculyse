<?php

/**
 * manage connection to database
 *
 * @package Core
 * @deprecated since version 2
 * @todo To be removed in later version in favour of Eloquent ORM
 * @author Blessing Mashoko <bmashcom@hotmail.com>
 * @version v1.0 
 */

namespace Aculyse;

use Aculyse\Config;

require_once __DIR__ . "/Config.php";

class Database
{

    public $server;
    public $user;
    public $password;
    public $database;
    public $connection;

    public function __construct()
    {

        $this->server = DB_SERVER;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
        $this->database = DB_NAME;
    }

    /**
     * open a connection
     * @return boolean TRUE On success and FALSE on failure
     */
    public final function connectDatabase()
    {
        try {
            $this->connection = @mysqli_connect($this->server, $this->user, $this->password, $this->database);
            
            if (!$this->connection) {
                return FALSE;
            } else {
                return TRUE;
            }
        } catch (\Exception $ex) {
            return FALSE;
        }
    }

}
