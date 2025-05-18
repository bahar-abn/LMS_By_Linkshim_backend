<?php

require_once DIR . '/../config/database.php';

class User
{
    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }


    public function register($data)
    {
        $conn = $this->db->connect();


        $query = 'INSERT INTO users (name, email, password, role) 
                  VALUES (:name, :email, :password, :role)';

        $stmt = $conn->prepare($query);


        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':role', $data['role']);


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function login($email, $password)
    {
        $conn = $this->db->connect();


        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }


    public function findUserByEmail($email)
    {
        $conn = $this->db->connect();

        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getUserById($id)
    {
        $conn = $this->db->connect();

        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}