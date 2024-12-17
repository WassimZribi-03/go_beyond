<?php
session_start();

// Check if booking confirmation exists
if (!isset($_SESSION['booking_confirmation'])) {
    header('Location: tours.php');
    exit();
}

$booking = $_SESSION['booking_confirmation'];
$pageTitle = 'Booking Confirmation';
$currentPage = 'booking';
include_once 'layout/header.php';
?>

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Booking Confirmed!</h2>
                <span>Thank you for booking with us</span>
            </div>
        </div>
    </div>
</div>

<div class="rent-venue-application">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="venue-content text-center mb-5">
                    <i class="fa fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <div class="booking-details">
                    <div class="event-item">
                        <div class="down-content">
                            <h4>Booking Details</h4>
                            <ul>
                                <li><i class="fa fa-map-marker"></i> Tour: <?php echo htmlspecialchars($booking['tour_name']); ?></li>
                                <li><i class="fa fa-location-arrow"></i> Destination: <?php echo htmlspecialchars($booking['tour_destination']); ?></li>
                                <li><i class="fa fa-user"></i> Customer: <?php echo htmlspecialchars($booking['customer_name']); ?></li>
                                <li><i class="fa fa-calendar"></i> Date: <?php echo htmlspecialchars($booking['booking_date']); ?></li>
                                <li><i class="fa fa-money"></i> Price: <?php echo htmlspecialchars($booking['tour_price']); ?> DT</li>
                            </ul>
                            <p class="mt-4">A confirmation email has been sent to your email address.</p>
                            <div class="main-dark-button mt-4">
                                <a href="my-bookings.php">View My Bookings</a>
                            </div>
                            <div class="main-button mt-3">
                                <a href="tours.php">Back to Tours</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Clear the booking confirmation from session
unset($_SESSION['booking_confirmation']);
include_once 'layout/footer.php';
?> 