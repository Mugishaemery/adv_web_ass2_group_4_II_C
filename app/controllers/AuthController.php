<?php
// ============================================
// Auth Controller - Handles authentication
// ============================================

class AuthController {
    private $db;
    
    public function __construct() {
        require_once CONFIG_PATH . 'db.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    // GET /login - Display login page
    public function login() {
        $title = 'Admin Login';
        ob_start();
        include VIEW_PATH . 'auth/login.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/main.php';
    }
    
    // POST /api/admin-login - Process login
    public function authenticate() {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data || empty($data['username']) || empty($data['password'])) {
            echo json_encode(["success" => false, "message" => "Username and password required"]);
            return;
        }
        
        try {
            $sql = "SELECT * FROM users WHERE username = ? AND is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$data['username']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Verify password
                $passwordValid = false;
                
                // Try bcrypt verification
                if (password_verify($data['password'], $user['password'])) {
                    $passwordValid = true;
                }
                // Plain text fallback for demo
                elseif ($data['password'] === $user['password']) {
                    $passwordValid = true;
                    // Upgrade to bcrypt
                    $newHash = password_hash($data['password'], PASSWORD_DEFAULT);
                    $updateStmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $updateStmt->execute([$newHash, $user['id']]);
                }
                
                if ($passwordValid) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    
                    echo json_encode([
                        "success" => true,
                        "user" => [
                            "id" => $user['id'],
                            "username" => $user['username'],
                            "full_name" => $user['full_name'],
                            "role" => $user['role']
                        ]
                    ]);
                    return;
                }
            }
            
            echo json_encode(["success" => false, "message" => "Invalid credentials"]);
            
        } catch(PDOException $e) {
            echo json_encode(["success" => false, "message" => "Login failed: " . $e->getMessage()]);
        }
    }
}
?>