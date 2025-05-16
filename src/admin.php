<?php
require_once 'controller/AdminController.php';

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'approve':
        AdminController::approveCourse($_GET['id']);
        break;
    case 'reject':
        AdminController::rejectCourse($_GET['id']);
        break;
    case 'delete_review':
        AdminController::deleteReview($_GET['id']);
        break;
    default:
        AdminController::dashboard();
}
