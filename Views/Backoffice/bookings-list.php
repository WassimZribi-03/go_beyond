<?php
include_once '../../Controllers/BookingController.php';

$bookingController = new BookingController();
$bookings = $bookingController->listBookingsWithTours();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .header-content p {
            opacity: 0.9;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--white);
        }

        .btn-secondary {
            background-color: var(--white);
            color: var(--primary-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .bookings-section {
            background: var(--white);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1.2rem;
            text-align: left;
            border-bottom: 1px solid var(--light-bg);
        }

        th {
            background-color: var(--light-bg);
            color: var(--primary-color);
            font-weight: 600;
        }

        tr:hover {
            background-color: var(--light-bg);
        }

        .booking-info {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .booking-name {
            font-weight: 600;
            color: var(--primary-color);
        }

        .booking-details {
            font-size: 0.9rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background-color: var(--warning-color);
            color: var(--text-color);
        }

        .delete-btn {
            background-color: var(--danger-color);
            color: var(--white);
        }

        .message {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            background-color: var(--success-color);
            color: var(--white);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            th, td {
                padding: 0.8rem;
            }

            .actions {
                flex-direction: column;
            }

            .action-btn {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1>Manage Bookings</h1>
                <p>View and manage all tour bookings</p>
            </div>
            <div class="action-buttons">
                <a href="add-booking.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Booking
                </a>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <div class="bookings-section">
            <table>
                <thead>
                    <tr>
                        <th>Booking Details</th>
                        <th>Customer Info</th>
                        <th>Tour Details</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>
                                <div class="booking-info">
                                    <span class="booking-name">Booking #<?php echo $booking['id']; ?></span>
                                    <span class="booking-details">
                                        <i class="fas fa-calendar"></i> 
                                        <?php echo htmlspecialchars($booking['booking_date']); ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="booking-info">
                                    <span class="booking-name">
                                        <?php echo htmlspecialchars($booking['customer_name']); ?>
                                    </span>
                                    <span class="booking-details">
                                        <i class="fas fa-envelope"></i> 
                                        <?php echo htmlspecialchars($booking['customer_email']); ?>
                                    </span>
                                    <span class="booking-details">
                                        <i class="fas fa-phone"></i> 
                                        <?php echo htmlspecialchars($booking['customer_phone']); ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="booking-info">
                                    <span class="booking-name">
                                        <?php echo htmlspecialchars($booking['tour_name']); ?>
                                    </span>
                                    <span class="booking-details">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        <?php echo htmlspecialchars($booking['destination']); ?>
                                    </span>
                                    <span class="booking-details">
                                        <i class="fas fa-clock"></i> 
                                        <?php echo htmlspecialchars($booking['duration']); ?> days
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="booking-info">
                                    <span class="booking-name">
                                        <?php echo htmlspecialchars($booking['tour_price']); ?> DT
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="update-booking.php?id=<?php echo $booking['id']; ?>" 
                                       class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete-booking.php?id=<?php echo $booking['id']; ?>" 
                                       class="action-btn delete-btn"
                                       onclick="return confirm('Are you sure you want to delete this booking?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
