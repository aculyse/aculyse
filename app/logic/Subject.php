<?php

namespace Aculyse;

use Aculyse\Traits\DBConnection;
require_once dirname(dirname(__DIR__)) . "/vendor/autoload.php";

class Subject
{

    use DBConnection;

    public $exists = FALSE;

    public function __construct()
    {
        $this->con = $this->databaseInstance();
        @session_start();

        $this->auth_school_id = AccessManager::getLoggedInUser()["user"]["school"];
        $this->auth_school_id = mysqli_real_escape_string($this->con, $this->auth_school_id);
    }

    private function all()
    {
        return "SELECT id,title,school FROM subjects WHERE school='0' || school='$this->auth_school_id' ORDER BY title ASC ";
    }

    private function onlyCustom()
    {
        return "SELECT id,title,school FROM subjects WHERE school='$this->auth_school_id' ORDER BY title ASC";
    }

    public function search($query)
    {
        $this->query = mysqli_real_escape_string($this->con, $query);
        $this->sql = "SELECT id,title,school FROM subjects WHERE (school='0' || school='$this->auth_school_id') && (title LIKE '%$this->query%') ORDER BY title ASC ";

        return $this->execute($this->sql);
    }

    private function execute($sql)
    {
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {
            return FALSE;
        }

        if (mysqli_num_rows($this->executeQuery) == 0) {
            return FALSE;
        }
        $this->dataset = array();
        while ($this->rows = mysqli_fetch_array($this->executeQuery, MYSQLI_ASSOC)) {
            array_push($this->dataset, $this->rows);
        }

        return $this->dataset;
    }

    public function getAll($include_custom = FALSE)
    {

        $this->sql = $this->all();
        if ($include_custom) {
            $this->sql = $this->onlyCustom();
        }
        return $this->execute($this->sql);
    }

    public function getBuiltIn()
    {
        $this->sql = "SELECT * FROM subjects WHERE school='0' ";
        return $this->execute($this->sql);
    }

    public function addNew($name)
    {
        $name = mysqli_real_escape_string($this->con, $name);

        if (is_array($this->alreadyExists($name))) {
            return "exists";
        }
        $this->sql = "INSERT INTO subjects (title,school) VALUES('$name','$this->auth_school_id')";
        $this->executeQuery = mysqli_query($this->con, $this->sql);

        if (!$this->executeQuery) {

            return FALSE;
        }

        if (mysqli_affected_rows($this->con) == 1) {
            return TRUE;
        }
        return FALSE;
    }

    private function alreadyExists($name)
    {
        $name = mysqli_real_escape_string($this->con, $name);
        $this->sql = "SELECT * FROM subjects WHERE (title='$name' && school='$this->auth_school_id') || (title='$name' && school='0')";

        return $this->execute($this->sql);
    }

}
