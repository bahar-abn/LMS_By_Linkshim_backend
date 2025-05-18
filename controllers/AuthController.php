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


    public function register() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => 'student',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // اعتبارسنجی ایمیل
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }else {
                // بررسی وجود ایمیل در دیتابیس
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // اعتبارسنجی نام
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            // اعتبارسنجی رمز عبور
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';       }
            elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // اعتبارسنجی تایید رمز
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password'; }
            else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if(empty($data['email_err']) && empty($data['name_err']) &&
                empty($data['password_err']) && empty($data['confirm_password_err'])) {

                // هش کردن رمز عبور برای امنیت
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // ثبت کاربر در دیتابیس
                if($this->userModel->register($data)) {
                    // هدایت به صفحه ورود پس از ثبت موفق
                    echo('welcome');
                } else {
                    die('Something went wrong'); // خطای غیرمنتظره
                }
            } else {
                // در صورت وجود خطا، نمایش مجدد فرم با خطاها
                $this->view('auth/register', $data);
            }

        } else {
            // اگر روش درخواست POST نبود، مقداردهی اولیه به فرم ثبت‌نام
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

            // نمایش فرم ثبت‌نام
            $this->view('auth/register', $data);
        }
    }

    // متد ورود کاربر
    public function login() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // پاک‌سازی داده‌ها برای اینکه خطا بوجود نیاد
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // مقداردهی داده‌ها
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // بررسی ایمیل
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            // بررسی رمز عبور
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // بررسی وجود کاربر
            if($this->userModel->findUserByEmail($data['email'])) {

            } else {
                $data['email_err'] = 'No user found';
            }

            // بررسی خطاها
            if(empty($data['email_err']) && empty($data['password_err'])) {
                // ورود کاربر با متد login
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser) {
                    // ساخت سشن برای کاربر واردشده
                    $this->session->set('user_id', $loggedInUser['id']);
                    $this->session->set('user_email', $loggedInUser['email']);
                    $this->session->set('user_name', $loggedInUser['name']);
                    $this->session->set('user_role', $loggedInUser['role']);

                    // هدایت کاربر براساس نقش او
                    $this->redirectBasedOnRole($loggedInUser['role']);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('auth/login', $data);
                }
            } else {
                // نمایش مجدد فرم با خطاها
                $this->view('auth/login', $data);
            }

        } else {
            // اگر درخواست POST نبود، نمایش ساده فرم ورود
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('auth/login', $data); // نمایش فرم ورود
        }
    }

    // متد خروج از حساب کاربری
    public function logout() {
        $this->session->destroy();        // حذف نشست کاربر
        header('location: ' . BASE_URL . 'login');// هدایت به صفحه ورود
    }

    // هدایت  به داشبورد مناسب بر اساس نقش
    private function redirectBasedOnRole($role) {
        switch($role) {
            case 'admin':
                header('location: /admin/dashboard');        // هدایت به داشبورد ادمین
                break;
            case 'instructor':
                header('location: /instructor/dashboard');   // هدایت به داشبورد مدرس
                break;
            case 'student':
                header('location: /student/dashboard');      // هدایت به داشبورد دانشجو
                break;
            default:
                header('location: /login');                  // اگر نقش نامعتبر بود، بازگشت به صفحه ورود
                break;
        }
    }

    // متد بارگذاری ویو با داده
    private function view($view, $data = []) {
        require_once "views/{$view}.php"; // بارگذاری فایل ویو مربوطه
    }
}
