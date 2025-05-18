<?php
class Database {
    private static $dsn = 'mysql:host=localhost;dbname=assignment_tracher';
    private static $username = 'root';
    private static $password = '';
    private static $db;

    private function __construct() {}

    public static function getDB() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, self::$username, self::$password);
                self::$db->exec("SET NAMES 'utf8'");
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
                include(__DIR__ . '/../view/error.php');
                exit();
            }
        }
        return self::$db;
    }
}
