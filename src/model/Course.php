<?php
class Course {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    public function getApprovedCourses() {
        $this->db->query('SELECT courses.*, users.name as instructor_name, categories.name as category_name 
                          FROM courses 
                          INNER JOIN users ON courses.instructor_id = users.id 
                          INNER JOIN categories ON courses.category_id = categories.id 
                          WHERE courses.status = "approved"');
        return $this->db->resultSet();
    }
    
    public function getCourseById($id) {
        $this->db->query('SELECT courses.*, users.name as instructor_name, categories.name as category_name 
                          FROM courses 
                          INNER JOIN users ON courses.instructor_id = users.id 
                          INNER JOIN categories ON courses.category_id = categories.id 
                          WHERE courses.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function createCourse($data) {
        $this->db->query('INSERT INTO courses (title, description, instructor_id, category_id, status) 
                          VALUES (:title, :description, :instructor_id, :category_id, "pending")');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':instructor_id', $data['instructor_id']);
        $this->db->bind(':category_id', $data['category_id']);
        
        return $this->db->execute();
    }
    
    public function getInstructorCourses($instructor_id) {
        $this->db->query('SELECT courses.*, categories.name as category_name 
                          FROM courses 
                          INNER JOIN categories ON courses.category_id = categories.id 
                          WHERE instructor_id = :instructor_id');
        $this->db->bind(':instructor_id', $instructor_id);
        return $this->db->resultSet();
    }
    
    public function updateCourse($data) {
        $this->db->query('UPDATE courses SET title = :title, description = :description, category_id = :category_id 
                          WHERE id = :id AND instructor_id = :instructor_id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':instructor_id', $data['instructor_id']);
        
        return $this->db->execute();
    }
}
?>
