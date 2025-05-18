<?php
require('model/database.php');
require('model/assignment_db.php');
require('model/course_db.php');

session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$description = trim($_POST['assignment_id'] ?? '');
$description = trim($_POST['description'] ?? '');
$description = trim($_POST['course_name'] ?? '');

$course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);
if (!$course_id) {
    $course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);

}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if (!$action) {
        $action = 'list_assignments';
    }
}

switch($action) {
    case "list_courses":
        $courses = get_courses();
        include('view/course_list.php');
        break;

    case "add_course":
        if (!empty($course_name)) {
            add_course($course_name);
            header("Location: .?action=list_courses");
        } else {
            $error = "Course name is required.";
            include('view/error.php');
        }
        break;

    case "add_assignment":
        if ($course_id && $description) {
            add_assignment($course_id, $description);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Invalid assignment data. Check all fields and try again.";
            include('view/error.php');
        }
        break;

    case "delete_course":
        if ($course_id) {
            try {
                delete_course($course_id);
                header("Location: .?action=list_courses");
            } catch (PDOException $e) {
                $error = "You cannot delete a course if assignments exist for it.";
                include('view/error.php');
            }
        }
        break;

    case "delete_assignment":
        if ($assignment_id) {
            delete_assignment($assignment_id);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Missing or incorrect assignment id.";
            include('view/error.php');
        }
        break;

    case "logout":
        session_destroy();
        header("Location: login.php");
        exit();
        break;

    default:
        $course_name = get_course_name($course_id);
        $courses = get_courses();
        $assignments = get_assignments_by_course($course_id);
        include('view/assignment_list.php');
}

