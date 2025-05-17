<?php
class Review {
    private $pdo;
    public function __construct() {
        require 'config/db.php';
        $this->pdo = $pdo;
    }
    public function add($user_id, $course_id, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (user_id, course_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $course_id, $comment]);
    }
}