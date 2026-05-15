<?php
// ============================================
// Request Model
// ============================================

class Request {
    private $db;
    
    public function __construct() {
        // Require db.php and get connection
        require_once __DIR__ . '/../../config/db.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    public function getAll($filters = []) {
        $sql = "SELECT r.*, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.submitted_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findById($id) {
        $sql = "SELECT r.*, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id WHERE r.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getStats() {
        $sql = "SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending, SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress, SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved, SUM(CASE WHEN priority = 'high' THEN 1 ELSE 0 END) as high_priority FROM requests";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getRecent($limit = 10) {
        $sql = "SELECT r.*, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.submitted_at DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>