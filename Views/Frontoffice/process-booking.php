<?php
session_start();
include_once '../../Controllers/BookingController.php';
include_once '../../Models/Booking.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $tour_id = $_POST['tour_id'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    
    // Convert string date to DateTime object
    try {
        $booking_date = new DateTime($_POST['booking_date']);
    } catch (Exception $e) {
        echo "<script>
            alert('Invalid date format. Please try again.');
            window.location.href='tours.php';
        </script>";
        exit();
    }
    
    $special_requests = $_POST['special_requests'] ?? '';

    try {
        $bookingController = new BookingController();
        
        // Create new booking with DateTime object
        $booking = new Booking(
            null, // id will be auto-generated
            $tour_id,
            $customer_name,
            $customer_email,
            $customer_phone,
            $booking_date, // Now passing DateTime object
            $special_requests
        );

        // Add booking
        $bookingController->addBooking($booking);

        // Store booking confirmation in session
        $_SESSION['booking_confirmation'] = [
            'customer_name' => $customer_name,
            'booking_date' => $booking_date->format('Y-m-d'),
            'tour_id' => $tour_id
        ];

        // Redirect to confirmation page
        header("Location: booking-confirmation.php");
        exit();

    } catch (Exception $e) {
        // Redirect with error message
        echo "<script>
            alert('Error processing booking: " . addslashes($e->getMessage()) . "');
            window.location.href='tours.php';
        </script>";
        exit();
    }
} else {
    // If accessed directly without POST data
    header("Location: tours.php");
    exit();
}
?> 