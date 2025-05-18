<?php
require_once __DIR__ . '/../config/database.php';

class Review {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // دریافت تمام نظرات با اطلاعات کاربر و دوره
    public function getAllReviews() {
        $conn = $this->db->connect();
        $query = "SELECT r.*, u.name AS user_name, c.title AS course_title 
                  FROM reviews r
                  JOIN users u ON r.user_id = u.id
                  JOIN courses c ON r.course_id = c.id
                  ORDER BY r.created_at DESC";
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // حذف یک نظر
    public function deleteReview($id) {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
