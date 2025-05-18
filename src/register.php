<?php

require_once('model/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "fill in all the required fields!";
    } elseif ($password !== $confirm_password) {
        $error = "they are not the same.";
    } else {
        $db = Database::getDB();
        $query = "INSERT INTO users (name, email, password) VALUES (:name ,:email, :password)";
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->execute();
        $statement->closeCursor();
        header("Location: login.php");
        exit();
    }
}
include('register_form.php');

