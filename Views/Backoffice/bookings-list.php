<?php
include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';

$bookingController = new BookingController();
$tourController = new TourController();
$bookings = $bookingController->listBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 10px 15px; margin: 0 5px; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-add { background-color: #28a745; }
        .btn-edit { background-color: #007bff; }
        .btn-delete { background-color: #dc3545; }
    </style>
</head>
<body>
    <h1>Manage Bookings</h1>

    <div class="actions">
        <a href="add-booking.php" class="btn btn-add" onclick="return confirmAdd()">Add New Booking</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Tour Name</th>
                <th>Booking Date</th>
                <th>Customer Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($bookings && $bookings->rowCount() > 0): ?>
                <?php while ($booking = $bookings->fetch(PDO::FETCH_ASSOC)): 
                    $tour = $tourController->showTour($booking['tour_id']);
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($tour['name'] ?? 'Unknown Tour'); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['customer_email']); ?></td>
                        <td>
                            <a href="update-booking.php?id=<?php echo $booking['id']; ?>" 
                               class="btn btn-edit" 
                               onclick="return confirmEdit(<?php echo htmlspecialchars($booking['id']); ?>)">Edit</a>
                            <a href="#" 
                               class="btn btn-delete" 
                               onclick="return confirmDelete(<?php echo htmlspecialchars($booking['id']); ?>)">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No bookings found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // Check for URL parameters on page load
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            const error = urlParams.get('error');
            
            if (message) {
                alert(message);
            }
            if (error) {
                alert('Error: ' + error);
            }
        }

        function confirmAdd() {
            return confirm('Do you want to add a new booking?');
        }

        function confirmEdit(bookingId) {
            return confirm(`Do you want to edit booking #${bookingId}?`);
        }

        function confirmDelete(bookingId) {
            if (confirm(`Are you sure you want to delete booking #${bookingId}?`)) {
                if (confirm('This action cannot be undone. Proceed?')) {
                    window.location.href = `delete-booking.php?id=${bookingId}`;
                }
            }
            return false;
        }

        // Handle server responses
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }

        function showError(error) {
            if (error) {
                alert('Error: ' + error);
            }
        }

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
