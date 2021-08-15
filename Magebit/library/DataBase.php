<?php

class DataBase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "emaillist";

    private $table = "emails";

    function __construct(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if($this->conn->connect_error){
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function getConnection(){
        return $this->conn;
    }

    function getTable(){
        return $this->table;
    }
}