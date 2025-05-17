<?php
require_once 'core/Controller.php';
class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->model('User');
            $res = $user->login($_POST['email'], $_POST['password']);
            if ($res) {
                session_start();
                $_SESSION['user'] = $res;
                header('Location: /dashboard');
            } else {
                echo "Login failed";
            }
        } else {
            $this->view('auth/login');
        }
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->model('User');
            $user->register($_POST['name'], $_POST['email'], $_POST['password'], 'student');
            header('Location: /login');
        } else {
            $this->view('auth/register');
        }
    }
}