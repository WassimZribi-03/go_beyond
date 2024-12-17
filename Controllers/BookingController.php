<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../Models/Booking.php');

class BookingController
{
    // List all bookings with tour information
    public function listBookingsWithTours($filters = [])
    {
        try {
            $db = config::getConnexion();
            
            $sql = "
                SELECT 
                    bookings.*,
                    tours.name AS tour_name,
                    tours.price AS tour_price, 
                    tours.destination,
                    tours.duration,
                    DATE_FORMAT(bookings.created_at, '%Y-%m-%d') as created_date
                FROM bookings
                INNER JOIN tours 
                    ON bookings.tour_id = tours.id
                WHERE 1=1
            ";
            
            $params = [];

            // Apply filters
            if (!empty($filters['customer_name'])) {
                $sql .= " AND bookings.customer_name LIKE ?";
                $params[] = "%" . $filters['customer_name'] . "%";
            }

            if (!empty($filters['tour_name'])) {
                $sql .= " AND tours.name LIKE ?";
                $params[] = "%" . $filters['tour_name'] . "%";
            }

            if (!empty($filters['date_from'])) {
                $sql .= " AND bookings.booking_date >= ?";
                $params[] = $filters['date_from'];
            }

            if (!empty($filters['date_to'])) {
                $sql .= " AND bookings.booking_date <= ?";
                $params[] = $filters['date_to'];
            }

            if (!empty($filters['min_price'])) {
                $sql .= " AND tours.price >= ?";
                $params[] = $filters['min_price'];
            }

            if (!empty($filters['max_price'])) {
                $sql .= " AND tours.price <= ?";
                $params[] = $filters['max_price'];
            }

            $sql .= " ORDER BY bookings.booking_date DESC";
            
            $query = $db->prepare($sql);
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    // List all bookings
    public function listBookings()
    {
        $sql = "SELECT * FROM bookings";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Show a specific booking
    public function showBooking($id)
    {
        $sql = "SELECT * FROM bookings WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a new booking
    public function addBooking($booking)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare("
                INSERT INTO bookings 
                (tour_id, customer_name, customer_email, customer_phone, booking_date) 
                VALUES (:tour_id, :customer_name, :customer_email, :customer_phone, :booking_date)
            ");
            
            $result = $query->execute([
                'tour_id' => $booking->getTourId(),
                'customer_name' => $booking->getCustomerName(),
                'customer_email' => $booking->getCustomerEmail(),
                'customer_phone' => $booking->getCustomerPhone(),
                'booking_date' => $booking->getBookingDate()->format('Y-m-d')
            ]);

            if (!$result) {
                throw new Exception("Failed to add booking");
            }

            return true;
        } catch (PDOException $e) {
            error_log("Database error in addBooking: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    // Delete a booking
    public function deleteBooking($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a booking
    public function updateBooking($booking, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE bookings SET 
                    tour_id = :tour_id,
                    customer_name = :customer_name,
                    customer_email = :customer_email,
                    booking_date = :booking_date
                WHERE id = :id'
            );
            
            $query->execute([
                'id' => $id,
                'tour_id' => $booking->getTourId(),
                'customer_name' => $booking->getCustomerName(),
                'customer_email' => $booking->getCustomerEmail(),
                'booking_date' => $booking->getBookingDate()->format('Y-m-d'),
            ]);
            
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Get total number of bookings
    public function getTotalBookings()
    {
        try {
            $db = config::getConnexion();
            $query = $db->query("SELECT COUNT(*) FROM bookings");
            return $query->fetchColumn();
        } catch (Exception $e) {
            error_log("Error getting total bookings: " . $e->getMessage());
            return 0;
        }
    }

    // Get recent bookings with tour information
    public function getRecentBookings($limit = 5)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare("
                SELECT 
                    bookings.*,
                    tours.name AS tour_name,
                    tours.destination,
                    tours.duration
                FROM bookings
                INNER JOIN tours ON bookings.tour_id = tours.id
                ORDER BY bookings.created_at DESC
                LIMIT :limit
            ");
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting recent bookings: " . $e->getMessage());
            return [];
        }
    }

    // Get today's bookings count
    public function getTodayBookingsCount()
    {
        try {
            $db = config::getConnexion();
            $query = $db->query("SELECT COUNT(*) FROM bookings WHERE DATE(booking_date) = CURDATE()");
            return $query->fetchColumn();
        } catch (Exception $e) {
            error_log("Error getting today's bookings: " . $e->getMessage());
            return 0;
        }
    }

    // Get total earnings from all bookings
    public function getTotalEarnings()
    {
        try {
            $db = config::getConnexion();
            $query = $db->query("
                SELECT SUM(t.price) as total_earnings
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
            ");
            return $query->fetchColumn() ?: 0;
        } catch (Exception $e) {
            error_log("Error getting total earnings: " . $e->getMessage());
            return 0;
        }
    }

    // Get average tour price
    public function getAverageTourPrice()
    {
        try {
            $db = config::getConnexion();
            $query = $db->query("
                SELECT AVG(t.price) as avg_price
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
            ");
            return round($query->fetchColumn(), 2) ?: 0;
        } catch (Exception $e) {
            error_log("Error getting average price: " . $e->getMessage());
            return 0;
        }
    }
}
?>
