<?php
include_once '../../Controllers/TourController.php';
include_once '../../Controllers/BookingController.php';

$tourController = new TourController();
$bookingController = new BookingController();

// Use the new joined query for bookings
$bookingsWithTours = $bookingController->listBookingsWithTours();

// Get tour statistics with the existing method
$tours = $tourController->listTours();
$totalTours = $tours ? $tours->rowCount() : 0;
$totalValue = 0;
$averagePrice = 0;

// Store tours in an array for later use
$toursArray = [];
if ($totalTours > 0) {
    while ($tour = $tours->fetch(PDO::FETCH_ASSOC)) {
        $toursArray[] = $tour;
        $totalValue += $tour['price'];
    }
    $averagePrice = $totalValue / $totalTours;
}

// Get booking statistics
$totalBookings = count($bookingsWithTours);
$todayBookings = 0;

// Count today's bookings
foreach ($bookingsWithTours as $booking) {
    if (date('Y-m-d') === $booking['booking_date']) {
        $todayBookings++;
    }
}

// Get only the 5 most recent bookings
$recentBookings = array_slice($bookingsWithTours, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Beyond Dashboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 20px;
            background-color: #f4f6f9;
        }
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .action-btn {
            padding: 15px;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .action-btn:hover {
            background-color: #0056b3;
        }
        .recent-tours {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .dashboard-section {
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .view-all {
            color: #007bff;
            text-decoration: none;
        }
        .view-all:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Go Beyond Dashboard</h1>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Tours</h3>
                <div class="stat-value"><?php echo $totalTours; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Value</h3>
                <div class="stat-value"><?php echo number_format($totalValue, 2); ?> DT</div>
            </div>
            <div class="stat-card">
                <h3>Average Price</h3>
                <div class="stat-value"><?php echo number_format($averagePrice, 2); ?> DT</div>
            </div>
            <div class="stat-card">
                <h3>Total Bookings</h3>
                <div class="stat-value"><?php echo $totalBookings; ?></div>
            </div>
            <div class="stat-card">
                <h3>Today's Bookings</h3>
                <div class="stat-value"><?php echo $todayBookings; ?></div>
            </div>
        </div>

        <div class="actions">
            <a href="tours-list.php" class="action-btn">Manage Tours</a>
            <a href="bookings-list.php" class="action-btn">Manage Bookings</a>
            <a href="add-tour.php" class="action-btn">Add New Tour</a>
            <a href="add-booking.php" class="action-btn">Add New Booking</a>
        </div>

        <div class="dashboard-section">
            <div class="section-header">
                <h2>Recent Tours</h2>
                <a href="tours-list.php" class="view-all">View All Tours</a>
            </div>
            <?php if (!empty($toursArray)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Destination</th>
                            <th>Duration</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($toursArray, 0, 5) as $tour): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($tour['name']); ?></td>
                                <td><?php echo htmlspecialchars($tour['destination']); ?></td>
                                <td><?php echo htmlspecialchars($tour['duration']); ?> days</td>
                                <td><?php echo htmlspecialchars($tour['price']); ?> DT</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No tours available.</p>
            <?php endif; ?>
        </div>

        <div class="dashboard-section">
            <div class="section-header">
                <h2>Recent Bookings</h2>
                <a href="bookings-list.php" class="view-all">View All Bookings</a>
            </div>
            <?php if (!empty($bookingsWithTours)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Tour</th>
                            <th>Destination</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Booking Date</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Take only the 5 most recent bookings
                        $recentBookings = array_slice($bookingsWithTours, 0, 5);
                        foreach ($recentBookings as $booking): 
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['tour_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['destination']); ?></td>
                                <td><?php echo htmlspecialchars($booking['tour_price']); ?> DT</td>
                                <td><?php echo htmlspecialchars($booking['duration']); ?> days</td>
                                <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                                <td><?php echo htmlspecialchars($booking['customer_email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 