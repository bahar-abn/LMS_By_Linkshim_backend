<?php
require_once 'core/Session.php';
$session = new Session();

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$base_path = '/';

switch ($request) {
    case $base_path:
    case $base_path . 'login':
        require 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;

    case $base_path . 'register':
        require 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->register();
        break;

    case $base_path . 'logout':
        require 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;

    case $base_path . 'admin/dashboard':
        if($session->isAdmin()) {
            echo "Admin Dashboard";
            // Here you would include the admin dashboard view
        } else {
            header('Location: /login');
        }
        break;

    case $base_path . 'instructor/dashboard':
        if($session->isInstructor()) {
            echo "Instructor Dashboard";
            // Here you would include the instructor dashboard view
        } else {
            header('Location: /login');
        }
        break;

    case $base_path . 'student/dashboard':
        if($session->isStudent()) {
            echo "Student Dashboard";
            // Here you would include the student dashboard view
        } else {
            header('Location: /login');
        }
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}