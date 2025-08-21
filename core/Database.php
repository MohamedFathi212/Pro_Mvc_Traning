<?php
class Database {
    public $conn;
    private $host = "localhost";
    private $db   = "blogs";
    private $user = "root";
    private $pass = "";

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        $this->conn->set_charset("utf8mb4");
    }
}
