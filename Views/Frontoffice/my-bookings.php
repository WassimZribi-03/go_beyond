<?php
session_start();
include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';

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
            max-width: 1200px;
            margin: 0 auto;
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 3rem 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 1rem;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .booking-card {
            background: var(--white);
            border: none;
            border-radius: 1.5rem;
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .booking-header {
            border-bottom: 2px solid var(--light-beige);
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .booking-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .booking-info {
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.1rem;
        }

        .booking-info i {
            color: var(--accent-color);
            width: 24px;
            font-size: 1.2rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-size: 1rem;
            background-color: #4CAF50;
            color: var(--white);
            margin-top: 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
            gap: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1.2rem 2.5rem;
            text-decoration: none;
            border-radius: 0.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn i {
            font-size: 1.2rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem;
            background: linear-gradient(135deg, var(--light-beige), #fff);
            border-radius: 1.5rem;
            margin: 3rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
        }

        .empty-state h2 {
            font-size: 2rem;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.2rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            .header {
                padding: 2rem 1rem;
            }

            .booking-card {
                padding: 1.5rem;
            }

            .booking-title {
                font-size: 1.3rem;
            }

            .booking-info {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1>My Bookings</h1>
                <p>Track and manage all your amazing tour adventures in one place</p>
            </div>
        </div>

        <?php if (empty($bookings)): ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h2>No Bookings Found</h2>
                <p>You haven't made any bookings yet.</p>
            </div>
        <?php else: ?>
            <div class="bookings-grid">
                <?php foreach ($bookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3 class="booking-title"><?php echo htmlspecialchars($booking['tour_name']); ?></h3>
                            <div class="booking-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($booking['destination']); ?></span>
                            </div>
                        </div>
                        
                        <div class="booking-info">
                            <i class="fas fa-calendar"></i>
                            <span>Booking Date: <?php echo htmlspecialchars($booking['booking_date']); ?></span>
                        </div>
                        
                        <div class="booking-info">
                            <i class="fas fa-clock"></i>
                            <span>Duration: <?php echo htmlspecialchars($booking['duration']); ?> days</span>
                        </div>
                        
                        <div class="booking-info">
                            <i class="fas fa-tag"></i>
                            <span>Price: <?php echo htmlspecialchars($booking['tour_price']); ?> DT</span>
                        </div>

                        <div class="status-badge">
                            Confirmed
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="button-container">
            <a href="tours.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Tours
            </a>
        </div>
    </div>
</body>
</html> 