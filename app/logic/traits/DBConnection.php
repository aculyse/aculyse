<?php

namespace Aculyse\Traits;

use Aculyse\Database;

trait DBConnection {

    public function databaseInstance() {
        $newConnection = new Database();
        $newConnection->connectDatabase();
        $con = $newConnection->connection;
        return $con;
    }

}
