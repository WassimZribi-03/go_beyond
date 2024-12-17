<?php
include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';
include_once '../../Models/Booking.php';

$bookingController = new BookingController();
$tourController = new TourController();
$tours = $tourController->listTours();
$error = "";

// Get existing booking
if (!isset($_GET['id'])) {
    header('Location: bookings-list.php');
    exit();
}

try {
    $booking = $bookingController->showBooking($_GET['id']);
    if (!$booking) {
        throw new Exception("Booking not found");
    }
} catch (Exception $e) {
    header('Location: bookings-list.php?error=' . urlencode($e->getMessage()));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $booking_date = new DateTime($_POST['booking_date']);
        $updatedBooking = new Booking(
            $_GET['id'],
            $_POST['tour_id'],
            $_POST['customer_name'],
            $_POST['customer_email'],
            $_POST['customer_phone'],
            $booking_date
        );
        
        $bookingController->updateBooking($updatedBooking, $_GET['id']);
        header('Location: bookings-list.php?message=Booking updated successfully');
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
    <title>Update Booking</title>
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

        input, select, textarea {
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
        }

        input:focus, select:focus, textarea:focus {
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

        @media (max-width: 768px) {
            body {
                padding: 1rem;
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
            <h1>Update Booking</h1>
            <p>Modify booking details</p>
        </div>

        <div class="form-container">
            <form id="bookingForm" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="tour_id">Select Tour *</label>
                    <select id="tour_id" name="tour_id" required>
                        <?php foreach ($tours as $tour): ?>
                            <option value="<?php echo $tour['id']; ?>" 
                                    <?php echo ($tour['id'] == $booking['tour_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tour['name']); ?> - 
                                <?php echo htmlspecialchars($tour['destination']); ?> 
                                (<?php echo htmlspecialchars($tour['price']); ?> DT)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_name">Customer Name *</label>
                    <input type="text" id="customer_name" name="customer_name" 
                           value="<?php echo htmlspecialchars($booking['customer_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="customer_email">Email *</label>
                    <input type="email" id="customer_email" name="customer_email" 
                           value="<?php echo htmlspecialchars($booking['customer_email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="customer_phone">Phone Number *</label>
                    <input type="tel" id="customer_phone" name="customer_phone" 
                           value="<?php echo htmlspecialchars($booking['customer_phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="booking_date">Booking Date *</label>
                    <input type="date" id="booking_date" name="booking_date" 
                           value="<?php echo htmlspecialchars($booking['booking_date']); ?>" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Booking
                    </button>
                    <a href="bookings-list.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Keep the same validation script as add-booking.php
        function validateForm() {
            // Tour validation
            const tourId = document.getElementById('tour_id').value.trim();
            if (!tourId) {
                alert('Please select a tour');
                return false;
            }

            // Customer name validation
            const customerName = document.getElementById('customer_name').value.trim();
            if (!customerName || customerName.length < 3) {
                alert('Please enter a valid customer name (minimum 3 characters)');
                return false;
            }

            // Email validation
            const email = document.getElementById('customer_email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            // Phone validation
            const phone = document.getElementById('customer_phone').value.trim();
            if (!phone || !/^\d{8}$/.test(phone)) {
                alert('Please enter a valid 8-digit phone number');
                return false;
            }

            // Date validation
            const bookingDate = document.getElementById('booking_date').value;
            const selectedDate = new Date(bookingDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (!bookingDate || selectedDate < today) {
                alert('Please select a valid future date');
                return false;
            }

            return true;
        }

        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent non-numeric input for phone
            const phoneInput = document.getElementById('customer_phone');
            phoneInput.addEventListener('keypress', function(e) {
                if (!/^\d*$/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Set minimum date to today
            const dateInput = document.getElementById('booking_date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });
    </script>
</body>
</html> 