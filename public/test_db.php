<?php
echo "<h2>Database Connection Test</h2>";

// Test database connection
require_once __DIR__ . '/../config/db.php';

try {
    $db = getDB();
    echo "✅ Database connected successfully!<br><br>";
    
    // Check tables
    $tables = ['users', 'categories', 'requests', 'request_history'];
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            $count = $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            echo "✅ Table '$table' exists with $count records<br>";
        } else {
            echo "❌ Table '$table' does NOT exist<br>";
        }
    }
    
    // Show users
    echo "<br><h3>Users in database:</h3>";
    $users = $db->query("SELECT id, username, role FROM users")->fetchAll();
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Username</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(Exception $e) {
    echo "❌ Database error: " . $e->getMessage();
}
?>