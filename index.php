<?php
require_once 'core/Session.php';
require_once 'config/constants.php';
$session = new Session();

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$request = str_replace(BASE_URL, '', $request);

switch ($request) {
    case '':
    case 'login':
        require 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;

    case 'register':
        require 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->register();
        break;

    case 'logout':
        require 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'admin/dashboard':
        if($session->isAdmin()) {
            echo "Admin Dashboard";
        } else {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        break;

    case 'instructor/dashboard':
        if($session->isInstructor()) {
            echo "Instructor Dashboard";
        } else {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        break;

    case 'student/dashboard':
        if($session->isStudent()) {
            echo "Student Dashboard";
        } else {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}