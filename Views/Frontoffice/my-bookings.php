<?php
include_once '../../Controllers/BookingController.php';
include_once '../../Models/Booking.php';

$bookingController = new BookingController();
$bookings = $bookingController->listBookingsWithTours();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.5em;
        }

        .bookings-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .booking-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .booking-header {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            padding: 20px;
            position: relative;
        }

        .booking-header h3 {
            margin: 0;
            font-size: 1.4em;
            margin-bottom: 10px;
        }

        .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
            background: rgba(255,255,255,0.2);
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .booking-details {
            padding: 20px;
        }

        .booking-details p {
            margin: 10px 0;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .booking-details strong {
            color: #333;
            min-width: 100px;
        }

        .booking-details i {
            color: #6B73FF;
            width: 20px;
        }

        .no-bookings {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .no-bookings p {
            color: #666;
            margin-bottom: 20px;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: transform 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .bookings-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Bookings</h1>
        
        <?php if ($bookings && $bookings->rowCount() > 0): ?>
            <div class="bookings-list">
                <?php while($booking = $bookings->fetch()): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3><?php echo htmlspecialchars($booking['tour_name']); ?></h3>
                            <p class="price">$<?php echo htmlspecialchars($booking['tour_price']); ?></p>
                        </div>
                        <div class="booking-details">
                            <p><i class="fas fa-map-marker-alt"></i><strong>Destination:</strong> <?php echo htmlspecialchars($booking['destination']); ?></p>
                            <p><i class="fas fa-clock"></i><strong>Duration:</strong> <?php echo htmlspecialchars($booking['duration']); ?> days</p>
                            <p><i class="fas fa-user"></i><strong>Customer:</strong> <?php echo htmlspecialchars($booking['customer_name']); ?></p>
                            <p><i class="fas fa-envelope"></i><strong>Email:</strong> <?php echo htmlspecialchars($booking['customer_email']); ?></p>
                            <p><i class="fas fa-calendar"></i><strong>Booking Date:</strong> <?php echo date('F j, Y', strtotime($booking['booking_date'])); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-bookings">
                <p>You haven't made any bookings yet.</p>
                <a href="tours.php" class="cta-button">Browse Available Tours</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 