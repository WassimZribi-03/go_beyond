<?php
$pageTitle = 'Bookings List';
$currentPage = 'bookings';
include_once 'layout/header.php';
include_once '../../Controllers/BookingController.php';

$bookingController = new BookingController();

// Initialize search filters
$filters = [
    'customer_name' => $_GET['customer_name'] ?? '',
    'tour_name' => $_GET['tour_name'] ?? '',
    'date_from' => $_GET['date_from'] ?? '',
    'date_to' => $_GET['date_to'] ?? '',
    'min_price' => $_GET['min_price'] ?? '',
    'max_price' => $_GET['max_price'] ?? ''
];

// Get filtered bookings
$bookings = $bookingController->listBookingsWithTours($filters);

// Handle success/error messages
$message = isset($_GET['message']) ? $_GET['message'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-6 d-flex align-items-center">
            <h6 class="mb-0">Bookings List</h6>
          </div>
          <div class="col-6 text-end">
            <a href="add-booking.php" class="btn bg-gradient-dark mb-0">
              <i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Booking
            </a>
          </div>
        </div>
      </div>
      
      <?php if ($message): ?>
      <div class="alert alert-success mx-4 mt-4" role="alert">
        <?php echo htmlspecialchars($message); ?>
      </div>
      <?php endif; ?>

      <?php if ($error): ?>
      <div class="alert alert-danger mx-4 mt-4" role="alert">
        <?php echo htmlspecialchars($error); ?>
      </div>
      <?php endif; ?>

      <!-- Advanced Search Form -->
      <div class="card-body pt-0">
        <form method="GET" class="row g-3 mb-4">
          <div class="col-md-3">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" placeholder="Search by name" 
                   value="<?php echo htmlspecialchars($filters['customer_name']); ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label">Tour Name</label>
            <input type="text" name="tour_name" class="form-control" placeholder="Search by tour" 
                   value="<?php echo htmlspecialchars($filters['tour_name']); ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label">Date From</label>
            <input type="date" name="date_from" class="form-control" 
                   value="<?php echo htmlspecialchars($filters['date_from']); ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label">Date To</label>
            <input type="date" name="date_to" class="form-control" 
                   value="<?php echo htmlspecialchars($filters['date_to']); ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label">Min Price</label>
            <input type="number" name="min_price" class="form-control" placeholder="Min price" 
                   value="<?php echo htmlspecialchars($filters['min_price']); ?>">
          </div>
          <div class="col-md-2">
            <label class="form-label">Max Price</label>
            <input type="number" name="max_price" class="form-control" placeholder="Max price" 
                   value="<?php echo htmlspecialchars($filters['max_price']); ?>">
          </div>
          <div class="col-md-12 text-end">
            <button type="submit" class="btn bg-gradient-info">
              <i class="fas fa-search"></i> Search
            </button>
            <a href="bookings-list.php" class="btn bg-gradient-secondary">
              <i class="fas fa-times"></i> Clear Filters
            </a>
          </div>
        </form>
      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tour</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Booking Date</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bookings as $booking): ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($booking['customer_name']); ?></h6>
                      <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($booking['customer_email']); ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($booking['tour_name']); ?></p>
                  <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($booking['destination']); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($booking['booking_date']); ?></span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($booking['tour_price']); ?> DT</span>
                </td>
                <td class="align-middle text-center">
                  <a href="update-booking.php?id=<?php echo $booking['id']; ?>" class="text-secondary font-weight-bold text-xs mx-2" data-toggle="tooltip" data-original-title="Edit booking">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="delete-booking.php?id=<?php echo $booking['id']; ?>" class="text-danger font-weight-bold text-xs mx-2" data-toggle="tooltip" data-original-title="Delete booking" onclick="return confirm('Are you sure you want to delete this booking?');">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'layout/footer.php'; ?>
