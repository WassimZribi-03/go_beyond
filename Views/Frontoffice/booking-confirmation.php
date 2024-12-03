<?php
session_start();

// Check if there's a booking confirmation
if (!isset($_SESSION['booking_confirmation'])) {
    header("Location: tours.php");
    exit();
}

// Get the booking details from session
$bookingDetails = $_SESSION['booking_confirmation'];
// Clear the session data after getting it
unset($_SESSION['booking_confirmation']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .confirmation-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .success-icon {
            font-size: 4rem;
            color: #059669;
            margin-bottom: 1rem;
        }

        h1 {
            color: #059669;
            margin-bottom: 1rem;
        }

        p {
            color: #4b5563;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            margin-right: 1rem;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .countdown {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>Booking Confirmed!</h1>
        <p>Thank you for choosing our service. Your tour booking has been successfully confirmed.</p>
        <p>You will receive a confirmation email shortly with your booking details.</p>
        
        <a href="tours.php" class="btn btn-primary">Browse More Tours</a>
        
        <div class="countdown">
            Redirecting to tours in <span id="timer">5</span> seconds...
        </div>
    </div>

    <script>
        // Countdown timer
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');
        
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                window.location.href = 'tours.php';
            }
        }, 1000);
    </script>
</body>
</html> 