<?php
// ============================================
// API Controller - Simplified Version
// ============================================

class ApiController {
    private $db;
    
    public function __construct() {
        require_once CONFIG_PATH . 'db.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    // GET /api/stats
    public function getStats() {
        header('Content-Type: application/json');
        
        try {
            // Get total requests
            $totalStmt = $this->db->query("SELECT COUNT(*) as count FROM requests");
            $total = $totalStmt->fetch(PDO::FETCH_ASSOC);
            
            // Get pending
            $pendingStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'pending'");
            $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC);
            
            // Get in progress
            $progressStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'in_progress'");
            $progress = $progressStmt->fetch(PDO::FETCH_ASSOC);
            
            // Get resolved
            $resolvedStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'resolved'");
            $resolved = $resolvedStmt->fetch(PDO::FETCH_ASSOC);
            
            // Get high priority
            $highStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE priority = 'high'");
            $high = $highStmt->fetch(PDO::FETCH_ASSOC);
            
            $stats = [
                'total' => (int)$total['count'],
                'pending' => (int)$pending['count'],
                'in_progress' => (int)$progress['count'],
                'resolved' => (int)$resolved['count'],
                'high_priority' => (int)$high['count']
            ];
            
            echo json_encode(["success" => true, "stats" => $stats]);
            
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }
    
    // GET /api/categories
    public function getCategories() {
        header('Content-Type: application/json');
        
        try {
            $stmt = $this->db->query("SELECT id, name, icon FROM categories WHERE is_active = 1");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "categories" => $categories]);
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }
    
    // GET /api/users - Add this method
    public function getUsers() {
        header('Content-Type: application/json');
        
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(["success" => false, "message" => "Unauthorized - Admin access required"]);
            return;
        }
        
        try {
            $sql = "SELECT id, username, full_name, role, email, is_active, created_at FROM users ORDER BY id";
            $stmt = $this->db->query($sql);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "users" => $users]);
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }
}
?>