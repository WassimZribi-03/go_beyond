<?php
include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';
include_once '../../Models/Booking.php';

$bookingController = new BookingController();
$tourController = new TourController();
$error = "";
$booking = null;

if (isset($_GET['id'])) {
    $booking = $bookingController->getBooking($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $booking = new Booking(
            $_GET['id'],
            $_POST['tourId'],
            $_POST['customerName'],
            $_POST['customerEmail'],
            new DateTime($_POST['bookingDate'])
        );
        
        $bookingController->updateBooking($booking);
        header('Location: bookings-list.php');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get all tours for the dropdown
$tours = $tourController->listTours();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
    <link rel="stylesheet" href="../Frontoffice/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Update Booking</h1>
        
        <div class="booking-card">
            <form method="POST" id="updateForm" onsubmit="return validateForm(event)">
                <div class="form-group">
                    <label for="tourId">Tour</label>
                    <select id="tourId" name="tourId" required>
                        <?php while($tour = $tours->fetch()): ?>
                            <option value="<?php echo $tour['id']; ?>" 
                                <?php echo ($booking['tour_id'] == $tour['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tour['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customerName">Customer Name</label>
                    <input type="text" id="customerName" name="customerName" 
                           value="<?php echo htmlspecialchars($booking['customer_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="customerEmail">Customer Email</label>
                    <input type="email" id="customerEmail" name="customerEmail" 
                           value="<?php echo htmlspecialchars($booking['customer_email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="bookingDate">Booking Date</label>
                    <input type="date" id="bookingDate" name="bookingDate" 
                           value="<?php echo $booking['booking_date']; ?>" required>
                </div>

                <button type="submit" class="btn">Update Booking</button>
            </form>
        </div>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault();
            
            const email = document.getElementById('customerEmail').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            document.getElementById('updateForm').submit();
            return true;
        }
    </script>
</body>
</html> 