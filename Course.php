<?php
require_once __DIR__ . '/../config/database.php';

class Course {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getPendingCourses() {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT c.*, u.name as instructor_name 
                              FROM courses c 
                              JOIN users u ON c.instructor_id = u.id 
                              WHERE c.status = 'pending'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("UPDATE courses SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
