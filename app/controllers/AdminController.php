<?php
// ============================================
// Admin Controller - Complete Working Version
// ============================================

class AdminController {
    private $db;
    
    public function __construct() {
        require_once CONFIG_PATH . 'db.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /umuganda-mvc/login');
            exit();
        }
        return $_SESSION;
    }
    
    public function dashboard() {
        $session = $this->checkAuth();
        
        try {
            $totalStmt = $this->db->query("SELECT COUNT(*) as count FROM requests");
            $total = $totalStmt->fetch(PDO::FETCH_ASSOC);
            
            $pendingStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'pending'");
            $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC);
            
            $progressStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'in_progress'");
            $progress = $progressStmt->fetch(PDO::FETCH_ASSOC);
            
            $resolvedStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'resolved'");
            $resolved = $resolvedStmt->fetch(PDO::FETCH_ASSOC);
            
            $highStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE priority = 'high'");
            $high = $highStmt->fetch(PDO::FETCH_ASSOC);
            
            $stats = [
                'total' => $total['count'] ?? 0,
                'pending' => $pending['count'] ?? 0,
                'in_progress' => $progress['count'] ?? 0,
                'resolved' => $resolved['count'] ?? 0,
                'high_priority' => $high['count'] ?? 0
            ];
            
            $recentSql = "SELECT r.id, r.ticket, r.title, r.full_name, r.priority, r.status, r.submitted_at, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.submitted_at DESC LIMIT 10";
            $recentStmt = $this->db->query($recentSql);
            $recentRequests = $recentStmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $stats = ['total' => 0, 'pending' => 0, 'in_progress' => 0, 'resolved' => 0, 'high_priority' => 0];
            $recentRequests = [];
        }
        
        $title = 'Dashboard';
        ob_start();
        include VIEW_PATH . 'admin/dashboard.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/admin.php';
    }
    
    public function requests() {
        $session = $this->checkAuth();
        
        try {
            $sql = "SELECT r.id, r.ticket, r.full_name, r.email, r.title, r.priority, r.status, r.submitted_at, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.submitted_at DESC";
            $stmt = $this->db->query($sql);
            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $requests = [];
        }
        
        $title = 'All Requests';
        ob_start();
        include VIEW_PATH . 'admin/requests.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/admin.php';
    }
    
    public function reports() {
        $session = $this->checkAuth();
        
        try {
            $totalStmt = $this->db->query("SELECT COUNT(*) as count FROM requests");
            $total = $totalStmt->fetch(PDO::FETCH_ASSOC);
            
            $pendingStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'pending'");
            $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC);
            
            $progressStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'in_progress'");
            $progress = $progressStmt->fetch(PDO::FETCH_ASSOC);
            
            $resolvedStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'resolved'");
            $resolved = $resolvedStmt->fetch(PDO::FETCH_ASSOC);
            
            $stats = [
                'total' => $total['count'] ?? 0,
                'pending' => $pending['count'] ?? 0,
                'in_progress' => $progress['count'] ?? 0,
                'resolved' => $resolved['count'] ?? 0
            ];
            
            $allSql = "SELECT r.ticket, r.full_name, r.priority, r.status, r.submitted_at, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.submitted_at DESC";
            $allStmt = $this->db->query($allSql);
            $allRequests = $allStmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $stats = ['total' => 0, 'pending' => 0, 'in_progress' => 0, 'resolved' => 0];
            $allRequests = [];
        }
        
        $title = 'Reports';
        ob_start();
        include VIEW_PATH . 'admin/reports.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/admin.php';
    }
    
    public function users() {
        $session = $this->checkAuth();
        
        if ($session['role'] !== 'admin') {
            header('Location: /umuganda-mvc/admin/dashboard');
            exit();
        }
        
        try {
            $sql = "SELECT id, username, full_name, role, email, is_active, created_at FROM users ORDER BY id";
            $stmt = $this->db->query($sql);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $users = [];
        }
        
        $title = 'User Management';
        ob_start();
        include VIEW_PATH . 'admin/users.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/admin.php';
    }
    
    public function viewRequest($id) {
        $session = $this->checkAuth();
        
        try {
            $sql = "SELECT r.*, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id WHERE r.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $request = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$request) {
                echo "Request not found";
                return;
            }
            
            $historySql = "SELECT * FROM request_history WHERE request_id = ? ORDER BY changed_at ASC";
            $historyStmt = $this->db->prepare($historySql);
            $historyStmt->execute([$id]);
            $history = $historyStmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $request = null;
            $history = [];
        }
        
        $title = 'Request Details';
        ob_start();
        include VIEW_PATH . 'admin/view-request.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/admin.php';
    }
    
    public function updateRequest() {
        header('Content-Type: application/json');
        
        $session = $this->checkAuth();
        
        $request_id = $_POST['request_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $notes = $_POST['notes'] ?? '';
        
        if (!$request_id || !$status) {
            echo json_encode(["success" => false, "message" => "Request ID and status required"]);
            return;
        }
        
        try {
            $checkStmt = $this->db->prepare("SELECT status FROM requests WHERE id = ?");
            $checkStmt->execute([$request_id]);
            $current = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$current) {
                echo json_encode(["success" => false, "message" => "Request not found"]);
                return;
            }
            
            $updateSql = "UPDATE requests SET status = ?, notes = ?, updated_at = NOW()";
            $params = [$status, $notes];
            
            if ($status == 'resolved') {
                $updateSql .= ", resolved_at = NOW()";
            }
            
            $updateSql .= " WHERE id = ?";
            $params[] = $request_id;
            
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->execute($params);
            
            if ($status != $current['status']) {
                $historySql = "INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes) VALUES (?, ?, ?, ?, ?)";
                $historyStmt = $this->db->prepare($historySql);
                $historyStmt->execute([
                    $request_id,
                    $current['status'],
                    $status,
                    $_SESSION['username'] ?? 'Admin',
                    $notes
                ]);
            }
            
            header("Location: /umuganda-mvc/admin/view-request/" . $request_id);
            exit();
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    // Add this method for creating new officer
public function addOfficer() {
    header('Content-Type: application/json');
    
    $session = $this->checkAuth();
    
    // Only admin can add officers
    if ($session['role'] !== 'admin') {
        echo json_encode(["success" => false, "message" => "Unauthorized"]);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data || empty($data['username']) || empty($data['password']) || empty($data['full_name'])) {
        echo json_encode(["success" => false, "message" => "Username, full name and password required"]);
        return;
    }
    
    try {
        // Check if username exists
        $checkStmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $checkStmt->execute([$data['username']]);
        if ($checkStmt->fetch()) {
            echo json_encode(["success" => false, "message" => "Username already exists"]);
            return;
        }
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, full_name, role, email, is_active) VALUES (?, ?, ?, 'officer', ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['username'],
            $hashedPassword,
            $data['full_name'],
            $data['email'] ?? null
        ]);
        
        echo json_encode(["success" => true, "message" => "Officer added successfully"]);
        
    } catch(PDOException $e) {
        echo json_encode(["success" => false, "message" => "Failed to add officer: " . $e->getMessage()]);
    }
}

// Add this method for removing/deactivating officer
public function removeOfficer() {
    header('Content-Type: application/json');
    
    $session = $this->checkAuth();
    
    // Only admin can remove officers
    if ($session['role'] !== 'admin') {
        echo json_encode(["success" => false, "message" => "Unauthorized"]);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data || empty($data['user_id'])) {
        echo json_encode(["success" => false, "message" => "User ID required"]);
        return;
    }
    
    try {
        // Check if user exists and is not admin
        $checkStmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
        $checkStmt->execute([$data['user_id']]);
        $user = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            echo json_encode(["success" => false, "message" => "User not found"]);
            return;
        }
        
        if ($user['role'] === 'admin') {
            echo json_encode(["success" => false, "message" => "Cannot remove admin user"]);
            return;
        }
        
        // Soft delete - deactivate user
        $sql = "UPDATE users SET is_active = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['user_id']]);
        
        echo json_encode(["success" => true, "message" => "Officer removed successfully"]);
        
    } catch(PDOException $e) {
        echo json_encode(["success" => false, "message" => "Failed to remove officer: " . $e->getMessage()]);
    }
}

// Add this method for reactivating officer
public function reactivateOfficer() {
    header('Content-Type: application/json');
    
    $session = $this->checkAuth();
    
    if ($session['role'] !== 'admin') {
        echo json_encode(["success" => false, "message" => "Unauthorized"]);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data || empty($data['user_id'])) {
        echo json_encode(["success" => false, "message" => "User ID required"]);
        return;
    }
    
    try {
        $sql = "UPDATE users SET is_active = 1 WHERE id = ? AND role != 'admin'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['user_id']]);
        
        echo json_encode(["success" => true, "message" => "Officer reactivated successfully"]);
        
    } catch(PDOException $e) {
        echo json_encode(["success" => false, "message" => "Failed to reactivate officer"]);
    }
}

// Add this method for printing reports
public function printReports() {
    $session = $this->checkAuth();
    
    try {
        // Get all requests
        $sql = "SELECT r.*, c.name as category_name FROM requests r LEFT JOIN categories c ON r.category_id = c.id ORDER BY r.submitted_at DESC";
        $stmt = $this->db->query($sql);
        $allRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get stats
        $totalStmt = $this->db->query("SELECT COUNT(*) as count FROM requests");
        $total = $totalStmt->fetch(PDO::FETCH_ASSOC);
        
        $pendingStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'pending'");
        $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC);
        
        $progressStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'in_progress'");
        $progress = $progressStmt->fetch(PDO::FETCH_ASSOC);
        
        $resolvedStmt = $this->db->query("SELECT COUNT(*) as count FROM requests WHERE status = 'resolved'");
        $resolved = $resolvedStmt->fetch(PDO::FETCH_ASSOC);
        
        $stats = [
            'total' => $total['count'] ?? 0,
            'pending' => $pending['count'] ?? 0,
            'in_progress' => $progress['count'] ?? 0,
            'resolved' => $resolved['count'] ?? 0
        ];
        
        // Get category breakdown
        $catStmt = $this->db->query("SELECT c.name, COUNT(r.id) as count FROM categories c LEFT JOIN requests r ON c.id = r.category_id GROUP BY c.id");
        $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        $allRequests = [];
        $stats = ['total' => 0, 'pending' => 0, 'in_progress' => 0, 'resolved' => 0];
        $categories = [];
    }
    
    // Load print view
    $title = 'Print Reports';
    ob_start();
    include VIEW_PATH . 'admin/print-reports.php';
    $content = ob_get_clean();
    include VIEW_PATH . 'layouts/print.php';
}
public function changePassword() {
    header('Content-Type: application/json');
    
    $session = $this->checkAuth();
    
    if ($session['role'] !== 'admin') {
        echo json_encode(["success" => false, "message" => "Unauthorized"]);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data || empty($data['user_id']) || empty($data['new_password'])) {
        echo json_encode(["success" => false, "message" => "User ID and new password required"]);
        return;
    }
    
    try {
        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$hashedPassword, $data['user_id']]);
        
        echo json_encode(["success" => true, "message" => "Password changed successfully"]);
        
    } catch(PDOException $e) {
        echo json_encode(["success" => false, "message" => "Failed to change password"]);
    }
}
}
?>