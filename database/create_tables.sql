-- Create events table if it doesn't exist
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
);

-- Create event_bookings table if it doesn't exist
CREATE TABLE IF NOT EXISTS event_bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    number_of_tickets INT NOT NULL DEFAULT 1,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Create tours table if it doesn't exist
CREATE TABLE IF NOT EXISTS tours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    capacity INT NOT NULL DEFAULT 20,
    is_featured BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create bookings table if it doesn't exist
CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tour_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20),
    booking_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
);

-- Insert some sample data for events
INSERT INTO events (title, description, date_start, date_end, place, capacity, price, is_featured) VALUES
('Summer Music Festival', 'A fantastic summer music festival featuring local and international artists', '2024-07-15 18:00:00', '2024-07-15 23:00:00', 'City Park', 500, 49.99, 1),
('Art Exhibition', 'Contemporary art exhibition featuring local artists', '2024-06-01 10:00:00', '2024-06-30 18:00:00', 'City Gallery', 200, 15.00, 1),
('Food & Wine Festival', 'Taste the best local cuisine and wines', '2024-08-20 12:00:00', '2024-08-22 22:00:00', 'Downtown Square', 300, 35.00, 1);

-- Insert some sample data for tours
INSERT INTO tours (name, destination, duration, price, description, capacity, is_featured) VALUES
('Desert Safari Adventure', 'Sahara Desert', 3, 299.99, 'Experience the magic of the Sahara Desert with our guided tour', 15, 1),
('Coastal Paradise Tour', 'Mediterranean Coast', 5, 599.99, 'Explore the beautiful Mediterranean coastline', 20, 1),
('Mountain Expedition', 'Atlas Mountains', 4, 449.99, 'Trek through the majestic Atlas Mountains', 12, 1); 