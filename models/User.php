<?php
require_once __DIR__ . "/../core/Database.php";

class User {
    private $db;
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function register($username, $email, $password) {

        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);

        $result = $this->db->query("SELECT id FROM users WHERE email='$email' LIMIT 1");
        if ($result->num_rows > 0) {
            return "Email already exists";
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, email, password, approved) 
                VALUES ('$username', '$email', '$hash', 1)";
        return $this->db->query($sql) ? "Registered successfully" : "Registration failed";
    }

    public function login($email, $password) {
        $email = $this->db->real_escape_string($email);

        $result = $this->db->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
