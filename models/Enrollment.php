<?php
class Enrollment {
    private $pdo;
    public function __construct() {
        require 'config/db.php';
        $this->pdo = $pdo;
    }
    public function enroll($user_id, $course_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM enrollments WHERE user_id=? AND course_id=?");
        $stmt->execute([$user_id, $course_id]);
        if (!$stmt->fetch()) {
            $stmt = $this->pdo->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
            return $stmt->execute([$user_id, $course_id]);
        }
        return false;
    }
}
