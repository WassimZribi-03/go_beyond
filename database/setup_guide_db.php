<?php
require_once(__DIR__ . '/../config.php');

try {
    $pdo = config::getConnexion();
    
    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/guide_tables.sql');
    $pdo->exec($sql);
    
    echo "Guide database tables created successfully!\n";
} catch (PDOException $e) {
    die("Error creating guide database tables: " . $e->getMessage() . "\n");
}
?> 