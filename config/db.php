<?php
// ============================================
// UMUGANDA MVC - Database Configuration
// ============================================

class Database {
    private $host = "localhost";
    private $db_name = "umuganda";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            return $this->conn;
        } catch(PDOException $exception) {
            // Return error details for debugging
            die(json_encode([
                "success" => false, 
                "message" => "Database connection failed: " . $exception->getMessage()
            ]));
        }
    }
}

// Helper function to get DB connection
function getDB() {
    $database = new Database();
    return $database->getConnection();
}
?>