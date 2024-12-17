<?php
session_start();
include_once '../../Controllers/TourController.php';

// Get tour ID from URL
$tour_id = isset($_GET['tour_id']) ? (int)$_GET['tour_id'] : 0;

// Initialize TourController
$tourController = new TourController();

// Get tour details
$tour = $tourController->getTourById($tour_id);

// If tour not found, redirect to tours page
if (!$tour) {
    header('Location: tours.php');
    exit();
}

$pageTitle = 'Book Your Tour - ' . $tour['name'];
$currentPage = 'booking';
include_once 'layout/header.php';
?>

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Book Your Tour</h2>
                <span>Complete your booking details below</span>
            </div>
        </div>
    </div>
</div>

<div class="rent-venue-application">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="venue-content">
                    <h4><?php echo htmlspecialchars($tour['name']); ?></h4>
                    <span class="price"><?php echo htmlspecialchars($tour['price']); ?> DT</span>
                    <p><?php echo htmlspecialchars($tour['description']); ?></p>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($tour['destination']); ?></li>
                        <li><i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($tour['duration']); ?> days</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="booking-form">
                    <form id="bookingForm" action="process-booking.php" method="POST" onsubmit="return validateForm(event)">
                        <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="customer_email" id="customer_email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="customer_phone" id="customer_phone" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Booking Date</label>
                            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
                        </div>

                        <div class="main-dark-button">
                            <button type="submit">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm(event) {
    var bookingDate = document.getElementById('booking_date').value;
    var today = new Date().toISOString().split('T')[0];
    
    if (bookingDate < today) {
        alert('Please select a future date for your booking.');
        event.preventDefault();
        return false;
    }
    return true;
}
</script>

<?php include_once 'layout/footer.php'; ?>