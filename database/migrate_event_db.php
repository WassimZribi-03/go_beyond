<?php
require_once(__DIR__ . '/../config.php');

try {
    $db = EventConfig::getEventConnexion();
    
    // Read and execute the SQL files
    $sqlFiles = [
        __DIR__ . '/event_tables.sql',
    ];

    foreach ($sqlFiles as $sqlFile) {
        $sql = file_get_contents($sqlFile);
        
        // Split into individual statements
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $db->exec($statement);
                echo "Executed: " . substr($statement, 0, 50) . "...\n";
            }
        }
    }
    
    echo "Database migration completed successfully!\n";
    
} catch (PDOException $e) {
    die("Database migration failed: " . $e->getMessage() . "\n");
}
?> 