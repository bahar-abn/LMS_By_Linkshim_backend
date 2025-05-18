<?php
require_once 'models/User.php';
require_once 'models/Course.php';
require_once 'helpers/Session.php';
require_once 'models/Review.php';

class AdminController {
    public function users() {
        Session::checkAdmin();
        $userModel = new User();
        $users = $userModel->getAllUsers();
        include 'views/admin/users.php';
    }

    public function deleteUser($id) {
        Session::checkAdmin();
        $userModel = new User();
        $userModel->deleteUser($id);
        header("Location: /admin/users?deleted=true");
    }

    public function editUser($id) {
        Session::checkAdmin();
        $userModel = new User();
        $user = $userModel->getUserById($id);
        include 'views/admin/edit_user.php';
    }

    public function updateUser($id) {
        Session::checkAdmin();
        $userModel = new User();
        $userModel->updateUser($id, $_POST['name'], $_POST['email'], $_POST['role']);
        header("Location: /admin/users?updated=true");
    }

    public function pendingCourses() {
        Session::checkAdmin();
        $courseModel = new Course();
        $courses = $courseModel->getPendingCourses();
        include 'views/admin/courses.php';
    }

    public function approveCourse($id) {
        Session::checkAdmin();
        $courseModel = new Course();
        $courseModel->updateStatus($id, 'approved');
        header("Location: /admin/courses?status=approved");
    }

    public function rejectCourse($id) {
        Session::checkAdmin();
        $courseModel = new Course();
        $courseModel->updateStatus($id, 'rejected');
        header("Location: /admin/courses?status=rejected");
    }

    public function reviews() {
        Session::checkAdmin();
        $reviewModel = new Review();
        $reviews = $reviewModel->getAllReviews();
        include 'views/admin/reviews.php';
    }

    public function deleteReview($id) {
        Session::checkAdmin();
        $reviewModel = new Review();
        $reviewModel->deleteReview($id);
        header("Location: /admin/reviews?deleted=true");
    }
}
