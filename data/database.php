<?php

class Database
{
    private $connection;

    public function __construct()
    {
        $dbhost = "localhost";
        $dbName = "db_web";
        $userName = "root";
        $userPassword = "";

        $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbName", $userName, $userPassword);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close() {
        $this->connection = null;
    }
}