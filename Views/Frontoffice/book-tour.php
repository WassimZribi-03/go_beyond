<?php
include_once '../../Controllers/BookingController.php';
include_once '../../Models/Booking.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $booking = new Booking(
            null,
            $_POST['tourId'],
            $_POST['fullName'],
            $_POST['email'],
            new DateTime($_POST['tourDate'])
        );
        
        $bookingController = new BookingController();
        $bookingController->addBooking($booking);
        
        // Redirect to my-bookings.php after successful booking
        header('Location: my-bookings.php?success=1');
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
    <title>Book Your Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .booking-container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            backdrop-filter: blur(10px);
        }

        .tour-info {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
        }

        .tour-info h2 {
            font-size: 2.2em;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .tour-price {
            font-size: 1.5em;
            font-weight: 600;
        }

        .form-section {
            margin-bottom: 35px;
        }

        .form-section h3 {
            color: #2d3436;
            font-size: 1.5em;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2d3436;
            font-weight: 500;
            font-size: 1.1em;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-group i {
            position: absolute;
            right: 15px;
            top: 45px;
            color: #a0a0a0;
        }

        .book-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-top: 20px;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.2);
        }

        .error-message {
            background: #fee;
            color: #e74c3c;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #2e7d32;
        }

        .success-message a {
            display: inline-block;
            margin-top: 15px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <!-- Add navigation -->
        <div class="navigation" style="margin-bottom: 20px;">
            <a href="my-bookings.php" style="text-decoration: none; color: #667eea;">
                <i class="fas fa-arrow-left"></i> View My Bookings
            </a>
        </div>

        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                Booking confirmed successfully!
                <br>
                <a href="my-bookings.php">
                    <i class="fas fa-list"></i> View My Bookings
                </a>
                <br>
                <a href="tours.php">
                    <i class="fas fa-arrow-left"></i> Browse More Tours
                </a>
            </div>
        <?php else: ?>
            <div id="selectedTourInfo" class="tour-info"></div>
            
            <form method="POST" action="" id="bookingForm" onsubmit="return validateForm(event)">
                <input type="hidden" id="tourId" name="tourId">
                
                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Personal Information</h3>
                    <div class="form-group">
                        <label for="fullName">Full Name *</label>
                        <input type="text" id="fullName" name="fullName" required>
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                        <i class="fas fa-envelope"></i>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required>
                        <i class="fas fa-phone"></i>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-calendar"></i> Tour Details</h3>
                    <div class="form-group">
                        <label for="tourDate">Tour Date *</label>
                        <input type="date" id="tourDate" name="tourDate" required>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>

                <button type="submit" class="book-btn">
                    <i class="fas fa-check-circle"></i> Confirm Booking
                </button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tourId = sessionStorage.getItem('selectedTourId');
            const tourName = sessionStorage.getItem('selectedTourName');
            const tourPrice = sessionStorage.getItem('tourPrice');
            
            if (!tourId || !tourName) {
                document.getElementById('selectedTourInfo').innerHTML = `
                    <div class="error-message">
                        <p>No tour selected. Please select a tour first.</p>
                        <a href="tours.php" class="btn">Browse Tours</a>
                    </div>
                `;
                return;
            }

            document.getElementById('tourId').value = tourId;
            document.getElementById('selectedTourInfo').innerHTML = `
                <h2>${tourName}</h2>
                <p class="tour-price">$${tourPrice}</p>
            `;

            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tourDate').min = today;
        });

        function validateForm(event) {
            event.preventDefault();
            
            // Add form validation here
            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const tourDate = document.getElementById('tourDate').value;

            if (fullName.length < 3) {
                alert('Please enter a valid name (minimum 3 characters)');
                return false;
            }

            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                alert('Please enter a valid email address');
                return false;
            }

            if (!phone.match(/^\+?[\d\s-]{8,}$/)) {
                alert('Please enter a valid phone number');
                return false;
            }

            if (!tourDate) {
                alert('Please select a tour date');
                return false;
            }

            document.getElementById('bookingForm').submit();
            return true;
        }
    </script>
</body>
</html> 