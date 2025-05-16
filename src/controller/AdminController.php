<?php
require_once 'model/database.php';
require_once 'model/User.php';
require_once 'model/Course.php';
require_once 'model/Review.php';

class AdminController {
    public static function dashboard() {
        $users = User::getAll();
        $courses = Course::getPending();
        $reviews = Review::getAll();

        include 'view/admin/dashboard.php';
    }

    public static function approveCourse($course_id) {
        Course::approve($course_id);
        header('Location: admin.php');
    }

    public static function rejectCourse($course_id) {
        Course::reject($course_id);
        header('Location: admin.php');
    }

    public static function deleteReview($review_id) {
        Review::delete($review_id);
        header('Location: admin.php');
    }
}
