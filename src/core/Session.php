Session.php ...
<?php

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy()
    {
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function getUserRole()
    {
        return $_SESSION['user_role'] ?? false;
    }

    public function isAdmin()
    {
        return ($this->getUserRole() == 'admin');
    }

    public function isInstructor()
    {
        return ($this->getUserRole() == 'instructor');
    }

    public function isStudent()
    {
        return ($this->getUserRole() == 'student');
    }
}