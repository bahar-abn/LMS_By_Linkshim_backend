<?php
require_once 'core/Controller.php';
class CourseController extends Controller {
    public function index() {
        $course = $this->model('Course');
        $courses = $course->allApproved();
        $this->view('course/index', ['courses' => $courses]);
    }
    public function create() {
        session_start();
        if ($_SESSION['user']['role'] !== 'instructor') die('Unauthorized');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $course = $this->model('Course');
            $course->create($_POST['title'], $_POST['description'], $_SESSION['user']['id'], $_POST['category_id']);
            header('Location: /dashboard');
        } else {
            $this->view('course/create');
        }
    }
    public function enroll($id) {
        session_start();
        $enroll = $this->model('Enrollment');
        $enroll->enroll($_SESSION['user']['id'], $id);
        echo "Enrolled successfully!";
    }
}