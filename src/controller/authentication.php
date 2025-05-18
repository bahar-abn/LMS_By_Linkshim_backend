<?php

require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../core/Session.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserDB();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'confirm_password' => trim($_POST['confirm_password'] ?? ''),
                'role' => 'student',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];


            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif ($this->userModel->getUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } elseif ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            if (empty($data['name_err']) && empty($data['email_err']) &&
                empty($data['password_err']) && empty($data['confirm_password_err'])) {

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                $this->userModel->createUser($data['name'], $data['email'], $data['password'], $data['role']);
                header('Location: ../login.php?success=registered');
                exit;
            } else {
                $this->view('../view/register', $data);
            }
        } else {
            $this->view('../view/register', [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ]);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $user = $this->userModel->getUserByEmail($data['email']);

                if ($user && password_verify($data['password'], $user['password'])) {
                    Session::set('user_id', $user['id']);
                    Session::set('user_name', $user['name']);
                    Session::set('user_email', $user['email']);
                    Session::set('user_role', $user['role']);

                    $this->redirectBasedOnRole($user['role']);
                } else {
                    $data['password_err'] = 'Invalid email or password';
                    $this->view('../login', $data);
                }
            } else {
                $this->view('../login', $data);
            }
        } else {
            $this->view('../login', [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ]);
        }
    }

    public function logout()
    {
        Session::destroy();
        header('Location: ../login.php');
        exit;
    }

    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'admin':
                header('Location: ../index.php?page=admin_dashboard');
                break;
            case 'instructor':
                header('Location: ../index.php?page=instructor_dashboard');
                break;
            case 'student':
                header('Location: ../index.php?page=student_dashboard');
                break;
            default:
                header('Location: ../login.php');
                break;
        }
        exit;
    }

    private function view($path, $data = [])
    {
        extract($data);
        require "{$path}.php";
    }
}
