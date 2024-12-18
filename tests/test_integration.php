<?php
require_once(__DIR__ . '/../config.php');

function testDatabaseConnections() {
    try {
        // Test main database connection
        $mainDb = config::getConnexion();
        echo "✓ Main database connection successful\n";
        
        // Test event database connection
        $eventDb = config::getEventConnexion();
        echo "✓ Event database connection successful\n";
        
        return true;
    } catch (Exception $e) {
        echo "✗ Database connection error: " . $e->getMessage() . "\n";
        return false;
    }
}

function testTableExistence() {
    try {
        $eventDb = config::getEventConnexion();
        
        // Test categorievent table
        $result = $eventDb->query("SELECT 1 FROM categorievent LIMIT 1");
        echo "✓ categorievent table exists and is accessible\n";
        
        // Test gestionevent table
        $result = $eventDb->query("SELECT 1 FROM gestionevent LIMIT 1");
        echo "✓ gestionevent table exists and is accessible\n";
        
        // Test tour_event_relation table
        $mainDb = config::getConnexion();
        $result = $mainDb->query("SELECT 1 FROM tour_event_relation LIMIT 1");
        echo "✓ tour_event_relation table exists and is accessible\n";
        
        return true;
    } catch (Exception $e) {
        echo "✗ Table verification error: " . $e->getMessage() . "\n";
        return false;
    }
}

echo "Starting integration tests...\n\n";

echo "Testing database connections:\n";
$dbResult = testDatabaseConnections();
echo "\n";

echo "Testing table structure:\n";
$tableResult = testTableExistence();
echo "\n";

if ($dbResult && $tableResult) {
    echo "All integration tests passed successfully!\n";
} else {
    echo "Some tests failed. Please check the errors above.\n";
}
?> 