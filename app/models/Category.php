<?php
class Category {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>