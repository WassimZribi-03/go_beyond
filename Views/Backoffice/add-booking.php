<?php
include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';
include_once '../../Models/Booking.php';

$bookingController = new BookingController();
$tourController = new TourController();
$tours = $tourController->listTours();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $booking_date = new DateTime($_POST['booking_date']);
        $booking = new Booking(
            null,
            $_POST['tour_id'],
            $_POST['customer_name'],
            $_POST['customer_email'],
            $booking_date
        );
        
        $bookingController->addBooking($booking);
        header('Location: bookings-list.php?message=Booking added successfully');
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Booking</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        label, input, select { display: block; width: 100%; margin: 10px 0; padding: 8px; }
        button { padding: 10px 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Add New Booking</h1>

    <form id="bookingForm" method="POST" onsubmit="return validateForm(event)">
        <div>
            <label for="tour_id">Select Tour</label>
            <select id="tour_id" name="tour_id">
                <option value="">Select a tour...</option>
                <?php while ($tour = $tours->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $tour['id']; ?>">
                        <?php echo htmlspecialchars($tour['name']); ?> - 
                        $<?php echo htmlspecialchars($tour['price']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label for="customer_name">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name">
        </div>

        <div>
            <label for="customer_email">Customer Email</label>
            <input type="text" id="customer_email" name="customer_email">
        </div>

        <div>
            <label for="booking_date">Booking Date</label>
            <input type="date" id="booking_date" name="booking_date">
        </div>

        <button type="submit">Add Booking</button>
    </form>

    <script>
        function validateForm(event) {
            event.preventDefault();
            
            // Tour validation
            const tourId = document.getElementById('tour_id').value.trim();
            if (!tourId) {
                alert('Please select a tour');
                document.getElementById('tour_id').focus();
                return false;
            }

            // Customer name validation
            const customerName = document.getElementById('customer_name').value.trim();
            if (!customerName) {
                alert('Please enter customer name');
                document.getElementById('customer_name').focus();
                return false;
            }
            if (customerName.length < 3) {
                alert('Customer name must be at least 3 characters long');
                document.getElementById('customer_name').focus();
                return false;
            }
            if (customerName.length > 50) {
                alert('Customer name cannot exceed 50 characters');
                document.getElementById('customer_name').focus();
                return false;
            }
            if (!/^[a-zA-Z\s]+$/.test(customerName)) {
                alert('Customer name should contain only letters and spaces');
                document.getElementById('customer_name').focus();
                return false;
            }

            // Email validation
            const customerEmail = document.getElementById('customer_email').value.trim();
            if (!customerEmail) {
                alert('Please enter customer email');
                document.getElementById('customer_email').focus();
                return false;
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(customerEmail)) {
                alert('Please enter a valid email address');
                document.getElementById('customer_email').focus();
                return false;
            }
            if (customerEmail.length > 100) {
                alert('Email address cannot exceed 100 characters');
                document.getElementById('customer_email').focus();
                return false;
            }

            // Booking date validation
            const bookingDateValue = document.getElementById('booking_date').value.trim();
            if (!bookingDateValue) {
                alert('Please select a booking date');
                document.getElementById('booking_date').focus();
                return false;
            }

            const bookingDate = new Date(bookingDateValue);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (isNaN(bookingDate.getTime())) {
                alert('Please select a valid booking date');
                document.getElementById('booking_date').focus();
                return false;
            }
            if (bookingDate < today) {
                alert('Booking date cannot be in the past');
                document.getElementById('booking_date').focus();
                return false;
            }
            
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);
            if (bookingDate > maxDate) {
                alert('Booking date cannot be more than 1 year in advance');
                document.getElementById('booking_date').focus();
                return false;
            }

            // If all validations pass, submit the form
            document.getElementById('bookingForm').submit();
            return true;
        }

        // Set date restrictions when page loads
        window.onload = function() {
            const bookingDateInput = document.getElementById('booking_date');
            const today = new Date().toISOString().split('T')[0];
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);
            const maxDateStr = maxDate.toISOString().split('T')[0];
            
            bookingDateInput.min = today;
            bookingDateInput.max = maxDateStr;
        }
    </script>
</body>
</html>
