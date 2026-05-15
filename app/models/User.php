<?php
// ============================================
// User Model
// ============================================

class User {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../config/db.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function getAll() {
        $sql = "SELECT id, username, full_name, role, email, is_active, created_at FROM users ORDER BY id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ? AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>