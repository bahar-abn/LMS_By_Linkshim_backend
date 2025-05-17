<?php
require_once 'core/Controller.php';
class ReviewController extends Controller {
    public function add() {
        session_start();
        $review = $this->model('Review');
        $review->add($_SESSION['user']['id'], $_POST['course_id'], $_POST['comment']);
        header('Location: /courses');
    }
}