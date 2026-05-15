<?php
class History {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    public function getByRequestId($requestId) {
        $stmt = $this->db->prepare("SELECT * FROM request_history WHERE request_id = ? ORDER BY changed_at ASC");
        $stmt->execute([$requestId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function add($requestId, $oldStatus, $newStatus, $changedBy, $notes) {
        $stmt = $this->db->prepare("INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$requestId, $oldStatus, $newStatus, $changedBy, $notes]);
    }
}
?>