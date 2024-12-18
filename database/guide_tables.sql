-- Create guide table
CREATE TABLE IF NOT EXISTS guide (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    language VARCHAR(50),
    price DECIMAL(10,2),
    category VARCHAR(100),
    region VARCHAR(100),
    country VARCHAR(100)
);

-- Create guide_reservations table
CREATE TABLE IF NOT EXISTS guide_reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guide_id INT,
    user_id INT,
    reservation_date DATETIME,
    status VARCHAR(50),
    FOREIGN KEY (guide_id) REFERENCES guide(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create guide_availability table
CREATE TABLE IF NOT EXISTS guide_availability (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guide_id INT,
    available_date DATE,
    start_time TIME,
    end_time TIME,
    is_available BOOLEAN DEFAULT true,
    FOREIGN KEY (guide_id) REFERENCES guide(id)
); 