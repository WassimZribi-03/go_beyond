<?php
include_once '../../Controllers/TourController.php';

if (isset($_GET['id'])) {
    try {
        $tourController = new TourController();
        $tourController->deleteTour($_GET['id']);
        
        // Redirect back to tours list with success message
        header('Location: tours-list.php?message=Tour deleted successfully');
        exit(); // Make sure to exit after redirect
    } catch (Exception $e) {
        // Redirect back to tours list with error message
        header('Location: tours-list.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    // No ID provided, redirect back to tours list
    header('Location: tours-list.php?error=No tour ID provided');
    exit();
}
?>
