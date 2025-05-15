<?php
require_once 'models/User.php';
require_once 'core/Session.php';

class AuthController {
    private $userModel;
    private $session;

    public function __construct() {
        $this->userModel = new User();
        $this->session = new Session();
    }

    // Register user
    public function register() {
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => 'student', // Default role
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // Validate Name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            // Validate Password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // Validate Confirm Password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) &&
                empty($data['password_err']) && empty($data['confirm_password_err'])) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if($this->userModel->register($data)) {
                    // Redirect to login
                    header('location: /login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }

        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->view('auth/register', $data);
        }
    }

    // Login user
    public function login() {
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            // Validate Password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                $data['email_err'] = 'No user found';
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser) {
                    // Create Session
                    $this->session->set('user_id', $loggedInUser['id']);
                    $this->session->set('user_email', $loggedInUser['email']);
                    $this->session->set('user_name', $loggedInUser['name']);
                    $this->session->set('user_role', $loggedInUser['role']);

                    // Redirect to dashboard based on role
                    $this->redirectBasedOnRole($loggedInUser['role']);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }

        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('auth/login', $data);
        }
    }

    // Logout user
    public function logout() {
        $this->session->destroy();
        header('location: /login');
    }

    // Redirect based on user role
    private function redirectBasedOnRole($role) {
        switch($role) {
            case 'admin':
                header('location: /admin/dashboard');
                break;
            case 'instructor':
                header('location: /instructor/dashboard');
                break;
            case 'student':
                header('location: /student/dashboard');
                break;
            default:
                header('location: /login');
                break;
        }
    }

    // Simple view loader
    private function view($view, $data = []) {
        require_once "views/{$view}.php";
    }
}