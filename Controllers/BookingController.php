<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../Models/Booking.php');

class BookingController
{
    // List all bookings with tour information
    public function listBookingsWithTours()
    {
        try {
            $db = config::getConnexion();
            
            $query = $db->prepare("
                SELECT 
                    bookings.*,
                    tours.name AS tour_name,
                    tours.price AS tour_price, 
                    tours.destination,
                    tours.duration
                FROM bookings
                INNER JOIN tours 
                    ON bookings.tour_id = tours.id
                ORDER BY bookings.booking_date DESC
            ");

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Log error and return empty array instead of dying
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
        $sql = "INSERT INTO bookings (tour_id, customer_name, customer_email, booking_date) 
                VALUES (:tour_id, :customer_name, :customer_email, :booking_date)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'tour_id' => $booking->getTourId(),
                'customer_name' => $booking->getCustomerName(),
                'customer_email' => $booking->getCustomerEmail(),
                'booking_date' => $booking->getBookingDate()->format('Y-m-d'),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
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
}
?>
