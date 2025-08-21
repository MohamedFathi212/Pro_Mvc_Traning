<?php
require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/User.php";

class UserController extends Controller {
    private $user;
    public function __construct() {
        $this->user = new User();
    }

    public function login() {
        $this->view("users/login");
    }

    public function doLogin() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if(empty($email) || empty($password)) {
            $this->view("users/login", ['error' => "Please fill in all fields"]);
        }


        $u = $this->user->login($email, $password);
        if ($u) {
            $_SESSION['user_id'] = (int)$u['id'];
            $_SESSION['username'] = $u['username'];
            $this->redirect("index.php?action=articles.all");
        }
        $this->view("users/login", ['error' => "Invalid email or password"]);
    }

    public function register() {
        $this->view("users/register");
    }

public function doRegister() {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if(empty($username) || empty($email) || empty($password)) {
        $this->view("users/register", ['error' => "Please fill in all fields"]);
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->view("users/register", ['error' => "Invalid email format"]);
    }


    $result = $this->user->register($username, $email, $password);

    if ($result === "Email already exists") {
        $this->view("users/register", ['error' => $result]);
    } else {
        $this->redirect("index.php?action=login");
    }
}

    public function logout() {
        session_destroy();
        $this->redirect("index.php?action=login");
    }
}
