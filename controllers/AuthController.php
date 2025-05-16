<?php
require_once 'models/User.php';        // بارگذاری مدل User برای کار با کاربران در دیتابیس
require_once 'core/Session.php';       // بارگذاری کلاس Session برای مدیریت نشست کاربران

class AuthController {
    private $userModel;                // متغیر برای نگهداری شیء مدل User
    private $session;                  // متغیر برای نگهداری شیء کلاس Session

    public function __construct() {
        $this->userModel = new User();     // ایجاد شیء از کلاس User
        $this->session = new Session();    // ایجاد شیء از کلاس Session
    }

    // متد ثبت‌نام کاربر
    public function register() {
        // بررسی اینکه آیا درخواست از نوع POST است
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // پاک‌سازی داده‌های ارسال‌شده
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // مقداردهی اولیه به متغیرهای فرم
            $data = [
                'name' => trim($_POST['name']),                         // نام
                'email' => trim($_POST['email']),                       // ایمیل
                'password' => trim($_POST['password']),                 // رمز عبور
                'confirm_password' => trim($_POST['confirm_password']), // تایید رمز عبور
                'role' => 'student',                                    // نقش پیش‌فرض دانشجو
                'name_err' => '',                                       // خطاهای نام
                'email_err' => '',                                      // خطاهای ایمیل
                'password_err' => '',                                   // خطاهای رمز
                'confirm_password_err' => ''                            // خطاهای تایید رمز
            ];

            // اعتبارسنجی ایمیل
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';             // ایمیل خالی است
            } else {
                // بررسی وجود ایمیل در دیتابیس
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';     // ایمیل تکراری است
                }
            }

            // اعتبارسنجی نام
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter name';               // نام خالی است
            }

            // اعتبارسنجی رمز عبور
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';       // رمز خالی است
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters'; // رمز کوتاه است
            }

            // اعتبارسنجی تایید رمز
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password'; // تایید رمز خالی است
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match'; // رمزها تطابق ندارند
                }
            }

            // بررسی اینکه هیچ خطایی وجود ندارد
            if(empty($data['email_err']) && empty($data['name_err']) &&
                empty($data['password_err']) && empty($data['confirm_password_err'])) {

                // هش کردن رمز عبور برای امنیت
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // ثبت کاربر در دیتابیس
                if($this->userModel->register($data)) {
                    // هدایت به صفحه ورود پس از ثبت موفق
                    header('location: /login');
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
        // بررسی اینکه آیا درخواست POST است
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // پاک‌سازی داده‌های ارسال شده
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // مقداردهی داده‌ها
            $data = [
                'email' => trim($_POST['email']),            // ایمیل
                'password' => trim($_POST['password']),      // رمز عبور
                'email_err' => '',                           // خطاهای ایمیل
                'password_err' => '',                        // خطاهای رمز
            ];

            // بررسی ایمیل
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';   // ایمیل خالی است
            }

            // بررسی رمز عبور
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password'; // رمز خالی است
            }

            // بررسی وجود کاربر
            if($this->userModel->findUserByEmail($data['email'])) {
                // کاربر پیدا شد
            } else {
                $data['email_err'] = 'No user found';        // کاربر پیدا نشد
            }

            // بررسی خطاها
            if(empty($data['email_err']) && empty($data['password_err'])) {
                // ورود کاربر با متد login
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser) {
                    // ساخت نشست برای کاربر واردشده
                    $this->session->set('user_id', $loggedInUser['id']);
                    $this->session->set('user_email', $loggedInUser['email']);
                    $this->session->set('user_name', $loggedInUser['name']);
                    $this->session->set('user_role', $loggedInUser['role']);

                    // هدایت کاربر براساس نقش او
                    $this->redirectBasedOnRole($loggedInUser['role']);
                } else {
                    $data['password_err'] = 'Password incorrect'; // رمز اشتباه است
                    $this->view('auth/login', $data);             // نمایش فرم با خطا
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

    // هدایت کاربر به داشبورد مناسب بر اساس نقش او
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
