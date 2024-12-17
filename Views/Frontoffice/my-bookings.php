<?php
$pageTitle = 'My Bookings';
$currentPage = 'my-bookings';
include_once 'layout/header.php';
include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';

$bookingController = new BookingController();
$bookings = $bookingController->listBookingsWithTours();
?>

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>My Bookings</h2>
                <span>Track and manage all your amazing tour adventures</span>
            </div>
        </div>
    </div>
</div>

<div class="shows-events-schedule">
    <div class="container">
        <?php if (empty($bookings)): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="empty-state text-center">
                        <i class="fa fa-calendar-times fa-4x mb-4"></i>
                        <h3>No Bookings Found</h3>
                        <p class="mb-4">You haven't made any bookings yet.</p>
                        <a href="tours.php" class="main-dark-button">Explore Tours</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($bookings as $booking): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="event-item">
                            <div class="thumb">
                                <img src="assets/images/tour-default.jpg" alt="Tour Image">
                            </div>
                            <div class="down-content">
                                <h4><?php echo htmlspecialchars($booking['tour_name']); ?></h4>
                                <ul>
                                    <li><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($booking['destination']); ?></li>
                                    <li><i class="fa fa-calendar"></i> <?php echo htmlspecialchars($booking['booking_date']); ?></li>
                                    <li><i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($booking['duration']); ?> days</li>
                                    <li><i class="fa fa-money"></i> <?php echo htmlspecialchars($booking['tour_price']); ?> DT</li>
                                </ul>
                                <div class="main-dark-button">
                                    <a href="tours.php">Book Another Tour</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'layout/footer.php'; ?> 