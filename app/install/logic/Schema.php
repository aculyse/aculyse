<?php

/**
 * Create the database for the application
 * @author Blessing Mashoko <projects@bmashoko.com>
 * @copyright (c) 2016, Blessing Mashoko
 * @package Install
 * 
 */
use Aculyse\Database;
use Aculyse\Loggers\Log;
use Aculyse\Traits\DBConnection;
use Aculyse\Traits\Eloquent;
use Illuminate\Filesystem\Filesystem;

require_once dirname(dirname(dirname((__DIR__)))) . "/vendor/autoload.php";

class Schema
{

    protected $database;
    protected $logger;
    private $con;
    protected $errors = 0;

    /**
     *
     * @var type 
     * Tables and views to be created.
     */
    private $relations, $views;

    /**
     *
     * @var string
     * The sql to create primary keys 
     */
    private $relation_keys;

    use Eloquent,
        DBConnection;

    public function __construct()
    {
        $this->con = $this->databaseInstance();

        $this->logger = new Log();
        $this->logger->log_path = dirname(__DIR__) . "/logs/install.log";

        $this->relations = dirname(__DIR__) . "/relations";
        $this->views = dirname(__DIR__) . "/relations/views";
        $this->relation_keys = dirname(__DIR__) . "/relations/keys/table_keys.sql";
    }

    /**
     * Test if a connection to the database can be established
     * @param type $server
     * @param type $username
     * @param type $password
     * @param type $database
     * @return boolean TRUE on success and FALSE on failure
     */
    public function testConnection($server, $username, $password)
    {

        return @mysql_connect($server,$username,$password);
        
    }

     public function isDatabaseInstanceWorking($server, $username, $password, $database)
    {

        $db = new Database();
        $this->database = $database;
        $db->server = $server;
        $db->user = $username;
        $db->password = $password;
        $db->database = $database;

        try {
            return $db->connectDatabase();
        } catch (Exception $ex) {
            return false;
        }
    }


    /**
     * Get a list to tables to created
     * @return type
     */
    public function read($load_views = FALSE)
    {
        if ($load_views) {
            $this->relations = $this->views;
        }
        $Fly = new Filesystem();
        $files = $Fly->files($this->relations);
        return $files;
    }

    /**
     * Get a list of primary keys to be created
     * @return type
     */
    public function readKeys()
    {
        $Fly = new Filesystem();
        $files = $Fly->get($this->relation_keys);

        return explode("ALTER", $files);
    }

    /**
     * Create database
     * @return type
     */
    public function createDatabase()
    {
        $sql = "CREATE IF NOT EXISTS DATABASE $this->database ";

        return mysqli_query($this->con, $sql);
    }

    /**
     * Start creating tables into the database
     * @return boolean
     */
    public function run($views = FALSE)
    {

        $this->con = $this->databaseInstance();
        mysqli_autocommit($this->con, FALSE);
        $Fly = new Filesystem();

        //create tables
        foreach ($this->read($views) as $relation) {

            $file_content = $Fly->get($relation);
            $sql = $file_content;

            $execute = mysqli_query($this->con, $sql);
            if (!$execute) {
                $this->logger->put(mysqli_error($this->con) . " :: File [$relation]");

                $this->errors += 1;
            }
        }
        return TRUE;
    }

    public function runKeys()
    {
         $this->con = $this->databaseInstance();
        $keys_file = $this->readKeys();
        
        for ($i = 1; $i < sizeof($keys_file); $i++) {
            $sql = "ALTER " . $keys_file[$i];
            $execute = mysqli_query($this->con, $sql);
            if (!$execute) {
                $this->logger->put(mysqli_error($this->con) . " :: Query [$sql]");
                $this->errors += 1;
            }
        }
        if ($this->errors != 0) {
                return FALSE;
            }
            return TRUE;
    }

    public function commitTables()
    {
         $this->con = $this->databaseInstance();
        if ($this->errors != 0) {
            mysqli_rollback($this->con);
            return FALSE;
        }
        return mysqli_commit($this->con);
    }

}
