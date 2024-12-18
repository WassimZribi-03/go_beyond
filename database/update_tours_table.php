<?php
require_once '../config.php';

try {
    $db = config::getConnexion();
    
    // Add is_featured column if it doesn't exist
    $db->exec("ALTER TABLE tours ADD COLUMN IF NOT EXISTS is_featured BOOLEAN DEFAULT FALSE");
    
    // Add created_at column if it doesn't exist
    $db->exec("ALTER TABLE tours ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    
    // Add capacity column if it doesn't exist
    $db->exec("ALTER TABLE tours ADD COLUMN IF NOT EXISTS capacity INT DEFAULT 20");
    
    echo "Tours table updated successfully!";
} catch (PDOException $e) {
    die("Error updating tours table: " . $e->getMessage());
}
?> 