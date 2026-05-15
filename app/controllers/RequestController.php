<?php
// ============================================
// Request Controller - Handles request submissions and tracking
// ============================================

class RequestController {
    private $db;
    
    public function __construct() {
        require_once CONFIG_PATH . 'db.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    // POST /api/submit-request
    public function submit() {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            echo json_encode(["success" => false, "message" => "Invalid data"]);
            return;
        }
        
        // Validate required fields
        if (empty($data['full_name']) || empty($data['title']) || empty($data['description'])) {
            echo json_encode(["success" => false, "message" => "Name, title and description are required"]);
            return;
        }
        
        // Generate unique ticket number
        $year = date("Y");
        $ticket = "UMG-" . $year . "-" . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        try {
            $category_id = !empty($data['category']) ? (int)$data['category'] : 8;
            $priority = $data['priority'] ?? 'medium';
            
            $sql = "INSERT INTO requests (ticket, full_name, email, phone, category_id, title, description, location, priority, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $ticket,
                $data['full_name'],
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $category_id,
                $data['title'],
                $data['description'],
                $data['location'] ?? null,
                $priority
            ]);
            
            $request_id = $this->db->lastInsertId();
            
            // Add to history
            $historySql = "INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes) VALUES (?, 'new', 'pending', 'System', ?)";
            $historyStmt = $this->db->prepare($historySql);
            $historyStmt->execute([$request_id, "Request submitted online"]);
            
            echo json_encode([
                "success" => true,
                "ticket" => $ticket,
                "message" => "Request submitted successfully"
            ]);
            
        } catch(PDOException $e) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to submit request: " . $e->getMessage()
            ]);
        }
    }
    
    // GET /api/track-request - FIXED for GET requests with query parameter
    public function track() {
        header('Content-Type: application/json');
        
        // Get ticket from query string parameter
        $ticket = isset($_GET['ticket']) ? $_GET['ticket'] : '';
        
        if (empty($ticket)) {
            echo json_encode(["success" => false, "message" => "Ticket number required"]);
            return;
        }
        
        try {
            $sql = "SELECT r.*, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id WHERE r.ticket = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$ticket]);
            $request = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$request) {
                echo json_encode(["success" => false, "message" => "Request not found"]);
                return;
            }
            
            // Get history
            $historySql = "SELECT * FROM request_history WHERE request_id = ? ORDER BY changed_at ASC";
            $historyStmt = $this->db->prepare($historySql);
            $historyStmt->execute([$request['id']]);
            $history = $historyStmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                "success" => true,
                "request" => $request,
                "history" => $history
            ]);
            
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        }
    }
}
?>