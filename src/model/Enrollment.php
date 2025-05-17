<?php
class Enrollment {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    public function enroll($user_id, $course_id) {
        $this->db->query('SELECT * FROM enrollments WHERE user_id = :user_id AND course_id = :course_id');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':course_id', $course_id);
        $row = $this->db->single();
        if($row) {
            return false; 
        }
        $this->db->query('INSERT INTO enrollments (user_id, course_id) VALUES (:user_id, :course_id)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':course_id', $course_id);
        
        return $this->db->execute();
    }
    
    public function getStudentCourses($user_id) {
        $this->db->query('SELECT courses.*, users.name as instructor_name, categories.name as category_name 
                          FROM enrollments 
                          INNER JOIN courses ON enrollments.course_id = courses.id 
                          INNER JOIN users ON courses.instructor_id = users.id 
                          INNER JOIN categories ON courses.category_id = categories.id 
                          WHERE enrollments.user_id = :user_id AND courses.status = "approved"');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
    
    public function isEnrolled($user_id, $course_id) {
        $this->db->query('SELECT * FROM enrollments WHERE user_id = :user_id AND course_id = :course_id');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':course_id', $course_id);
        $row = $this->db->single();
        
        return $row ? true : false;
    }
}
?>
