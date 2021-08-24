<?php

class DataBase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "emaillist";


    function __construct(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if($this->conn->connect_error){
            die("Connection failed: " . $this->conn->connect_errno);
        }
    }

    function getConnection(){
        return $this->conn;
    }
}