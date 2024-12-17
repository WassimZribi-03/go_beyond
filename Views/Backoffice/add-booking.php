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
        // Validate required fields
        if (empty($_POST['tour_id']) || empty($_POST['customer_name']) || 
            empty($_POST['customer_email']) || empty($_POST['customer_phone']) || 
            empty($_POST['booking_date'])) {
            throw new Exception("All fields are required");
        }

        $booking_date = new DateTime($_POST['booking_date']);
        $booking = new Booking(
            null,
            intval($_POST['tour_id']),  // Convert to integer
            $_POST['customer_name'],
            $_POST['customer_email'],
            $_POST['customer_phone'],
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #34495E;
            --accent-color: #3498DB;
            --success-color: #2ECC71;
            --warning-color: #F1C40F;
            --danger-color: #E74C3C;
            --text-color: #2C3E50;
            --light-bg: #ECF0F1;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .form-container {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        input, select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid var(--light-bg);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232C3E50' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        input:focus, select:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--white);
        }

        .btn-secondary {
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .error {
            color: var(--danger-color);
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Add New Booking</h1>
            <p>Create a new tour booking</p>
        </div>

        <div class="form-container">
            <form id="bookingForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="tour_id">Select Tour *</label>
                    <select id="tour_id" name="tour_id">
                        <option value="">Select a tour...</option>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?php echo $tour['id']; ?>">
                                <?php echo htmlspecialchars($tour['name']); ?> - 
                                <?php echo htmlspecialchars($tour['destination']); ?> 
                                (<?php echo htmlspecialchars($tour['price']); ?> DT)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_name">Customer Name *</label>
                    <input type="text" id="customer_name" name="customer_name">
                </div>

                <div class="form-group">
                    <label for="customer_email">Email *</label>
                    <input type="email" id="customer_email" name="customer_email">
                </div>

                <div class="form-group">
                    <label for="customer_phone">Phone Number *</label>
                    <input type="tel" id="customer_phone" name="customer_phone">
                </div>

                <div class="form-group">
                    <label for="booking_date">Booking Date *</label>
                    <input type="date" id="booking_date" name="booking_date">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Booking
                    </button>
                    <a href="bookings-list.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // Tour validation
            const tourId = document.getElementById('tour_id').value.trim();
            if (!tourId) {
                alert('Please select a tour');
                document.getElementById('tour_id').focus();
                return false;
            }

            // Customer name validation
            const customerName = document.getElementById('customer_name').value.trim();
            if (!customerName || customerName.length < 3) {
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

            // Phone validation
            const phone = document.getElementById('customer_phone').value.trim();
            if (!phone || !/^\d{8}$/.test(phone)) {
                alert('Please enter a valid 8-digit phone number');
                document.getElementById('customer_phone').focus();
                return false;
            }

            // Date validation
            const bookingDate = document.getElementById('booking_date').value;
            if (!bookingDate) {
                alert('Please select a booking date');
                document.getElementById('booking_date').focus();
                return false;
            }

            const selectedDate = new Date(bookingDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                alert('Booking date cannot be in the past');
                document.getElementById('booking_date').focus();
                return false;
            }

            return true;
        }

        // Add input restrictions
        document.getElementById('customer_phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
        });

        document.getElementById('customer_name').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });

        // Set minimum date to today
        window.onload = function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('booking_date').min = today;
        }
    </script>
</body>
</html>
