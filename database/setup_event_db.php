<?php
require_once(__DIR__ . '/../config.php');

try {
    $db = config::getEventConnexion();
    
    // Create events table
    $db->exec("
        CREATE TABLE IF NOT EXISTS events (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            date_start DATETIME NOT NULL,
            date_end DATETIME NOT NULL,
            place VARCHAR(255) NOT NULL,
            capacity INT NOT NULL DEFAULT 100,
            price DECIMAL(10,2) NOT NULL,
            image_url VARCHAR(255),
            is_featured BOOLEAN DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Create event_bookings table
    $db->exec("
        CREATE TABLE IF NOT EXISTS event_bookings (
            id INT PRIMARY KEY AUTO_INCREMENT,
            event_id INT NOT NULL,
            user_id INT NOT NULL,
            number_of_tickets INT NOT NULL DEFAULT 1,
            booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
        )
    ");

    // Insert sample events data
    $db->exec("
        INSERT INTO events (title, description, date_start, date_end, place, capacity, price, is_featured) VALUES
        ('Summer Music Festival', 'A fantastic summer music festival featuring local and international artists', '2024-07-15 18:00:00', '2024-07-15 23:00:00', 'City Park', 500, 49.99, 1),
        ('Art Exhibition', 'Contemporary art exhibition featuring local artists', '2024-06-01 10:00:00', '2024-06-30 18:00:00', 'City Gallery', 200, 15.00, 1),
        ('Food & Wine Festival', 'Taste the best local cuisine and wines', '2024-08-20 12:00:00', '2024-08-22 22:00:00', 'Downtown Square', 300, 35.00, 1)
    ");
    
    echo "Event database setup completed successfully!\n";
    echo "Tables created and sample data inserted.\n";
    
} catch (PDOException $e) {
    die("Event database setup failed: " . $e->getMessage() . "\n");
}
?> 