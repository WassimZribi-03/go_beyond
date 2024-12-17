<?php
session_start();

// Check if booking confirmation exists
if (!isset($_SESSION['booking_confirmation'])) {
    header('Location: tours.php');
    exit();
}

$booking = $_SESSION['booking_confirmation'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
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
            text-align: center;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 2rem;
        }

        .confirmation-details {
            margin: 2rem 0;
            padding: 2rem;
            background: var(--light-beige);
            border-radius: 0.5rem;
            text-align: left;
        }

        .confirmation-details p {
            margin: 1rem 0;
        }

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-secondary {
            background-color: var(--accent-color);
            color: var(--text-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .success-icon {
            font-size: 4rem;
            color: #4CAF50;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .button-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>Booking Confirmed!</h1>
        
        <div class="confirmation-details">
            <p><strong>Tour:</strong> <?php echo htmlspecialchars($booking['tour_name']); ?></p>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($booking['tour_destination']); ?></p>
            <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($booking['customer_name']); ?></p>
            <p><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></p>
            <p><strong>Price:</strong> <?php echo htmlspecialchars($booking['tour_price']); ?> DT</p>
        </div>

        <p>Thank you for booking with us! A confirmation email has been sent to your email address.</p>
        
        <div class="button-container">
            <a href="my-bookings.php" class="btn btn-primary">
                <i class="fas fa-list-ul"></i> My Bookings
            </a>
            <a href="tours.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Back to Tours
            </a>
        </div>
    </div>

    <?php
    // Clear the booking confirmation from session
    unset($_SESSION['booking_confirmation']);
    ?>
</body>
</html> 