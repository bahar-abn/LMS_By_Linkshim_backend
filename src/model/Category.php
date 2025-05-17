<?php
class Category {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    public function getAllCategories() {
        $this->db->query('SELECT * FROM categories');
        return $this->db->resultSet();
    }
    
    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
?>
