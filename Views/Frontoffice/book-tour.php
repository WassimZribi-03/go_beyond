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
        
        $success = "Booking confirmed successfully!";
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
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .booking-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .booking-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .booking-card:hover {
            transform: translateY(-5px);
        }

        .booking-content {
            padding: 20px;
        }

        .selected-tour {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .selected-tour h2 {
            font-size: 2em;
            margin-bottom: 15px;
        }

        .selected-tour .price {
            font-size: 1.5em;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #6B73FF;
            box-shadow: 0 0 10px rgba(107, 115, 255, 0.2);
            outline: none;
        }

        .book-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(107, 115, 255, 0.3);
        }

        .error-message, .success-message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error-message {
            background: #fee;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }

        .success-message {
            background: #efe;
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Complete Your Booking</h1>
        
        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
                <br>
                <a href="tours.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Return to Tours
                </a>
            </div>
        <?php else: ?>
            <div class="booking-grid">
                <div class="booking-card">
                    <div class="booking-content">
                        <div id="selectedTourInfo" class="selected-tour"></div>
                        
                        <form method="POST" action="" id="bookingForm" onsubmit="return validateForm(event)">
                            <input type="hidden" id="tourId" name="tourId">
                            
                            <div class="form-group">
                                <label for="fullName">
                                    <i class="fas fa-user"></i> Full Name
                                </label>
                                <input type="text" id="fullName" name="fullName" required>
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>

                            <div class="form-group">
                                <label for="tourDate">
                                    <i class="fas fa-calendar"></i> Tour Date
                                </label>
                                <input type="date" id="tourDate" name="tourDate" required>
                            </div>

                            <button type="submit" class="book-btn">
                                <i class="fas fa-check-circle"></i> Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tourId = sessionStorage.getItem('selectedTourId');
            const tourName = sessionStorage.getItem('selectedTourName');
            const tourPrice = sessionStorage.getItem('tourPrice');
            
            if (!tourId || !tourName) {
                alert('No tour selected. Redirecting to tours page...');
                window.location.href = 'tours.php';
                return;
            }

            document.getElementById('tourId').value = tourId;
            document.getElementById('selectedTourInfo').innerHTML = `
                <h2>${tourName}</h2>
                <p class="price">$${tourPrice}</p>
            `;

            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tourDate').min = today;
        });

        function validateForm(event) {
            event.preventDefault();
            let isValid = true;
            const form = document.getElementById('bookingForm');
            
            // Basic validation
            const inputs = form.querySelectorAll('input[required]');
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });

            if (isValid) {
                form.submit();
            }
            
            return false;
        }
    </script>
</body>
</html> 