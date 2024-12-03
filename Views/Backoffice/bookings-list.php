<?php
include_once '../../Controllers/BookingController.php';

$bookingController = new BookingController();
$bookings = $bookingController->listBookingsWithTours();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $bookingController->deleteBooking($_GET['id']);
    header('Location: bookings-list.php?message=Booking deleted successfully');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f6f9;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .add-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            color: white;
        }
        .edit-btn {
            background-color: #007bff;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
        }
        .tour-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .tour-name {
            font-weight: bold;
            color: #007bff;
        }
        .tour-details {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Manage Bookings</h1>
            <a href="add-booking.php" class="add-btn">Add New Booking</a>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="message">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Tour Details</th>
                    <th>Booking Date</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['customer_email']); ?></td>
                        <td>
                            <div class="tour-info">
                                <span class="tour-name"><?php echo htmlspecialchars($booking['tour_name']); ?></span>
                                <span class="tour-details">
                                    Destination: <?php echo htmlspecialchars($booking['destination']); ?><br>
                                    Duration: <?php echo htmlspecialchars($booking['duration']); ?> days
                                </span>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['tour_price']); ?> DT</td>
                        <td class="actions">
                            <a href="edit-booking.php?id=<?php echo $booking['id']; ?>" class="edit-btn">Edit</a>
                            <a href="?action=delete&id=<?php echo $booking['id']; ?>" 
                               class="delete-btn" 
                               onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
