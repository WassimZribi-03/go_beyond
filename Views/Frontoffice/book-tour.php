<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../../Controllers/TourController.php';
include_once '../../Controllers/BookingController.php';
include_once '../../Models/Booking.php';

// Get tour ID from URL
if (!isset($_GET['tour_id'])) {
    header('Location: tours.php');
    exit();
}

$tourController = new TourController();
$bookingController = new BookingController();

try {
    $tour = $tourController->getTourById($_GET['tour_id']);
    if (!$tour) {
        throw new Exception("Tour not found");
    }
} catch (Exception $e) {
    header('Location: tours.php');
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("Form submitted: " . print_r($_POST, true));
    try {
        // Validate and sanitize input
        $customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
        $customer_email = filter_input(INPUT_POST, 'customer_email', FILTER_VALIDATE_EMAIL);
        $customer_phone = filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING);
        $booking_date = new DateTime($_POST['booking_date']);

        if (!$customer_name || !$customer_email || !$customer_phone || !$booking_date) {
            throw new Exception("Please fill in all required fields");
        }

        // Create new booking
        $booking = new Booking(
            null,
            $tour['id'],
            $customer_name,
            $customer_email,
            $customer_phone,
            $booking_date
        );

        // Add booking
        $bookingController->addBooking($booking);

        // Store booking details in session for confirmation page
        $_SESSION['booking_confirmation'] = [
            'customer_name' => $customer_name,
            'booking_date' => $booking_date->format('Y-m-d'),
            'tour_id' => $tour['id']
        ];

        // Redirect to confirmation page
        header('Location: booking-confirmation.php');
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
    <title>Book Tour - <?php echo htmlspecialchars($tour['name']); ?></title>
    <style>
        :root {
            --primary-color: #D2B48C;
            --secondary-color: #BC8F8F;
            --accent-color: #DEB887;
            --text-color: #5D4037;
            --light-beige: #F5F5DC;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-beige);
            color: var(--text-color);
            line-height: 1.6;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .tour-details {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        button {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1.1rem;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--secondary-color);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: var(--text-color);
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="tours.php" class="back-link">← Back to Tours</a>
        
        <div class="tour-details">
            <h1>Book Tour: <?php echo htmlspecialchars($tour['name']); ?></h1>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($tour['destination']); ?></p>
            <p><strong>Duration:</strong> <?php echo htmlspecialchars($tour['duration']); ?> days</p>
            <p><strong>Price:</strong> <?php echo htmlspecialchars($tour['price']); ?> DT</p>
        </div>

        <form method="POST" id="bookingForm" action="process-booking.php" onsubmit="return validateForm(event)">
            <input type="hidden" name="tour_id" value="<?php echo (int)$_GET['tour_id']; ?>">

            <div class="form-group">
                <label for="customer_name">Full Name *</label>
                <input type="text" id="customer_name" name="customer_name">
            </div>

            <div class="form-group">
                <label for="customer_email">Email *</label>
                <input type="text" id="customer_email" name="customer_email">
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone Number *</label>
                <input type="text" id="customer_phone" name="customer_phone">
            </div>

            <div class="form-group">
                <label for="booking_date">Booking Date *</label>
                <input type="date" id="booking_date" name="booking_date">
            </div>

            <button type="submit">Book Now</button>
        </form>
    </div>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('booking_date').setAttribute('min', today);

        // Prevent non-numeric input for phone
        document.getElementById('customer_phone').addEventListener('keypress', function(e) {
            if (!/^\d*$/.test(e.key) || this.value.length >= 8) {
                e.preventDefault();
            }
        });

        // Prevent paste for phone number
        document.getElementById('customer_phone').addEventListener('paste', function(e) {
            e.preventDefault();
        });

        // Prevent special characters in name
        document.getElementById('customer_name').addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.keyCode || e.which);
            if (!/^[a-zA-Z\s]$/.test(char)) {
                e.preventDefault();
            }
        });

        function validateForm(event) {
            event.preventDefault();

            // Get form values
            const name = document.getElementById('customer_name').value.trim();
            const email = document.getElementById('customer_email').value.trim();
            const phone = document.getElementById('customer_phone').value.trim();
            const date = document.getElementById('booking_date').value;

            // Name validation
            if (name.length < 3) {
                alert('Please enter a valid name (minimum 3 characters)');
                return false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            // Phone validation
            if (!/^\d{8}$/.test(phone)) {
                alert('Please enter a valid 8-digit phone number');
                return false;
            }

            // Date validation
            const selectedDate = new Date(date);
            const todayDate = new Date();
            todayDate.setHours(0, 0, 0, 0);

            if (!date || selectedDate < todayDate) {
                alert('Please select a valid future date');
                return false;
            }

            // If all validations pass
            if (confirm('Are you sure you want to book this tour?')) {
                document.getElementById('bookingForm').submit();
            }

            return false;
        }
    </script>
</body>
</html>