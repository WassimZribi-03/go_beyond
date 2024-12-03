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
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #2d3436;
            margin-bottom: 40px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .bookings-list {
            display: grid;
            gap: 30px;
        }

        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .booking-header h3 {
            font-size: 1.5em;
            color: #2d3436;
            font-weight: 600;
        }

        .price {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 8px 15px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            font-size: 1.2em;
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
        }

        .detail-item i {
            font-size: 1.2em;
            color: #667eea;
            width: 24px;
        }

        .detail-label {
            font-weight: 600;
            color: #2d3436;
            margin-right: 8px;
        }

        .detail-value {
            color: #636e72;
        }

        .no-bookings {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .no-bookings h2 {
            color: #2d3436;
            margin-bottom: 15px;
        }

        .no-bookings p {
            color: #636e72;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .booking-details {
                grid-template-columns: 1fr;
            }
            
            .booking-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Travel Bookings</h1>
        
        <?php if (!empty($bookings)): ?>
            <div class="bookings-list">
                <?php foreach($bookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3><?php echo htmlspecialchars($booking['tour_name']); ?></h3>
                            <span class="price"><?php echo htmlspecialchars($booking['tour_price']); ?> DT</span>
                        </div>
                        <div class="booking-details">
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <span class="detail-label">Destination:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($booking['destination']); ?></span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <span class="detail-label">Duration:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($booking['duration']); ?> days</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-user"></i>
                                <div>
                                    <span class="detail-label">Customer:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($booking['customer_name']); ?></span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($booking['customer_email']); ?></span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <div>
                                    <span class="detail-label">Booking Date:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($booking['booking_date']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-bookings">
                <h2>No Bookings Found</h2>
                <p>You haven't made any travel bookings yet. Start planning your next adventure!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 