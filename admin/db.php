<?php
class dbConnection {
    protected $conn;

public function __construct() {
    $this->conn = new mysqli('127.0.0.1', 'root', '', 'quiz_db');

if ($this->conn->connect_error) {
    die("connection failed:");
    }
}
public function getConnection() {
        return $this->conn;
    }
}
?>
