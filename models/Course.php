<?php
class Course {
    private $pdo;
    public function __construct() {
        require 'config/db.php';
        $this->pdo = $pdo;
    }
    public function allApproved() {
        $stmt = $this->pdo->query("SELECT * FROM courses WHERE status='approved'");
        return $stmt->fetchAll();
    }
    public function create($title, $desc, $instructor_id, $category_id) {
        $stmt = $this->pdo->prepare("INSERT INTO courses (title, description, instructor_id, category_id, status) VALUES (?, ?, ?, ?, 'pending')");
        return $stmt->execute([$title, $desc, $instructor_id, $category_id]);
    }
    public function approve($id) {
        $stmt = $this->pdo->prepare("UPDATE courses SET status='approved' WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
