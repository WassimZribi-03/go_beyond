<?php
include_once '../../Controllers/TourController.php';
include_once '../../Controllers/BookingController.php';

$tourController = new TourController();
$bookingController = new BookingController();

// Use the new joined query for bookings
$bookingsWithTours = $bookingController->listBookingsWithTours();

// Get tour statistics
$tours = $tourController->listTours();
$totalTours = count($tours);
$totalValue = 0;
$averagePrice = 0;

// Calculate total value and average price
if ($totalTours > 0) {
    foreach ($tours as $tour) {
        $totalValue += $tour['price'];
    }
    $averagePrice = $totalValue / $totalTours;
}

// Get booking statistics
$totalBookings = count($bookingsWithTours);
$todayBookings = 0;
$totalEarnings = 0;

// Get today's date
$today = date('Y-m-d');

// Count today's bookings and calculate total earnings
foreach ($bookingsWithTours as $booking) {
    // Compare created_date instead of booking_date
    if ($booking['created_date'] === $today) {
        $todayBookings++;
    }
    $totalEarnings += $booking['tour_price'];
}

// Debug output
echo "Final today's bookings count: " . $todayBookings . "<br>";

// Get only the 5 most recent bookings
$recentBookings = array_slice($bookingsWithTours, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
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
            margin-bottom: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.5));
            transform: skewX(-15deg);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover::after {
            transform: translateX(100%) skewX(-15deg);
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--accent-color);
        }

        .stat-title {
            font-size: 1.1rem;
            color: var(--text-color);
            opacity: 0.8;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            animation: countUp 0.5s ease-out forwards;
        }

        .recent-section {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .recent-section h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            border-bottom: 2px solid var(--light-bg);
            padding-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .recent-section h2 i {
            color: var(--accent-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--light-bg);
        }

        th {
            background-color: var(--light-bg);
            color: var(--primary-color);
            font-weight: 600;
        }

        tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        .navigation-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .nav-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background: var(--white);
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            background: var(--primary-color);
            color: var(--white);
        }

        .nav-btn i {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .header {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .navigation-buttons {
                grid-template-columns: 1fr;
            }
        }

        /* Add these new styles */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--primary-color);
            color: var(--white);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .sidebar-header p {
            opacity: 0.8;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0.2rem 0;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            border-left: 4px solid var(--accent-color);
        }

        .menu-item.active {
            background: var(--accent-color);
            border-left: 4px solid var(--white);
            font-weight: 600;
        }

        .menu-item i {
            width: 20px;
            margin-right: 1rem;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            transition: all 0.3s ease;
            scroll-behavior: smooth;
        }

        .toggle-sidebar {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background: var(--accent-color);
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-sidebar {
                display: block;
            }

            .sidebar.active + .main-content {
                margin-left: 0;
            }
        }

        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <button class="toggle-sidebar">
        <i class="fas fa-bars"></i>
    </button>

    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Go Beyond</h2>
                <p>Tour Management</p>
            </div>
            <nav class="sidebar-menu">
                <a href="dashboard.php" class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="tours-list.php" class="menu-item">
                    <i class="fas fa-map-marked-alt"></i>
                    Tours
                </a>
                <a href="bookings-list.php" class="menu-item">
                    <i class="fas fa-calendar-check"></i>
                    Bookings
                </a>
                <a href="add-tour.php" class="menu-item">
                    <i class="fas fa-plus-circle"></i>
                    Add Tour
                </a>
                <a href="add-booking.php" class="menu-item">
                    <i class="fas fa-calendar-plus"></i>
                    Add Booking
                </a>
                <a href="../Frontoffice/tours.php" class="menu-item">
                    <i class="fas fa-globe"></i>
                    View Website
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="dashboard-container">
                <div class="header">
                    <h1>Admin Dashboard</h1>
                    <p>Welcome to your tour management dashboard</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-suitcase stat-icon"></i>
                            <span class="stat-title">Total Tours</span>
                        </div>
                        <div class="stat-value"><?php echo $totalTours; ?></div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-calendar-alt stat-icon"></i>
                            <span class="stat-title">Total Bookings</span>
                        </div>
                        <div class="stat-value"><?php echo $totalBookings; ?></div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-money-bill-wave stat-icon"></i>
                            <span class="stat-title">Total Earnings</span>
                        </div>
                        <div class="stat-value"><?php echo number_format($totalEarnings, 2); ?> DT</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-clock stat-icon"></i>
                            <span class="stat-title">Today's Bookings</span>
                        </div>
                        <div class="stat-value"><?php echo $todayBookings; ?></div>
                    </div>
                </div>

                <div class="recent-section">
                    <h2><i class="fas fa-map-marked-alt"></i> Recent Tours</h2>
                    <?php if (!empty($tours)): ?>
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
                                <?php foreach (array_slice($tours, 0, 5) as $tour): ?>
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
                        <p>No tours found.</p>
                    <?php endif; ?>
                </div>

                <div class="recent-section">
                    <h2><i class="fas fa-calendar-check"></i> Recent Bookings</h2>
                    <?php if (!empty($bookingsWithTours)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Tour</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($bookingsWithTours, 0, 5) as $booking): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($booking['tour_name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($booking['customer_name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($booking['booking_date'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($booking['tour_price'] ?? '0'); ?> DT</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No recent bookings found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Add active class to current page
        const currentPage = window.location.pathname.split('/').pop();
        document.querySelectorAll('.menu-item').forEach(item => {
            if (item.getAttribute('href').includes(currentPage)) {
                item.classList.add('active');
            }
        });
    </script>
</body>
</html>