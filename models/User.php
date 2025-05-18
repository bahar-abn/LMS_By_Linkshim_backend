<?php
require_once __DIR__ . '/../config/database.php';
class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // متد ثبت‌نام کاربر جدید
    public function register($data) {
        $conn = $this->db->connect(); // اتصال به دیتابیس

        // تعریف کوئری SQL برای درج کاربر جدید
        $query = 'INSERT INTO users (name, email, password, role) 
                  VALUES (:name, :email, :password, :role)';

        $stmt = $conn->prepare($query); // آماده‌سازی کوئری برای جلوگیری از حملات SQL Injection

        // مقداردهی پارامترها
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']); // رمز عبور هش شده
        $stmt->bindParam(':role', $data['role']);

        // اجرای کوئری
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // متد ورود کاربر
    public function login($email, $password) {
        $conn = $this->db->connect(); // اتصال به دیتابیس

        // کوئری برای دریافت اطلاعات کاربر بر اساس ایمیل
        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC); // دریافت اطلاعات کاربر به صورت آرایه


        if($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    // بررسی اینکه آیا ایمیل تکراری است یا نه
    public function findUserByEmail($email) {
        $conn = $this->db->connect();

        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // بررسی اینکه آیا سطری با این ایمیل وجود دارد
        if($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // گرفتن اطلاعات کاربر بر اساس ID
    public function getUserById($id) {
        $conn = $this->db->connect(); // اتصال به دیتابیس

        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // برگرداندن اطلاعات کاربر
    }
}
