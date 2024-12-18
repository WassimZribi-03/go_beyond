<?php
require_once(__DIR__ . '/../config.php');

try {
    $db = config::getConnexion();
    
    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/create_tables.sql');
    
    // Split the SQL file into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    // Execute each statement
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $db->exec($statement);
        }
    }
    
    echo "Database setup completed successfully!\n";
    echo "Tables created and sample data inserted.\n";
    
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage() . "\n");
} 