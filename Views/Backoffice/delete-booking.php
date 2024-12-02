<?php
include_once '../../Controllers/BookingController.php';

if (isset($_GET['id'])) {
    try {
        $bookingController = new BookingController();
        $bookingController->deleteBooking($_GET['id']);
        
        header('Location: bookings-list.php?message=Booking deleted successfully');
        exit();
    } catch (Exception $e) {
        header('Location: bookings-list.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: bookings-list.php?error=No booking ID provided');
    exit();
}
?>
