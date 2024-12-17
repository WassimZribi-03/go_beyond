<?php
$pageTitle = 'Tours List';
$currentPage = 'tours';
include_once 'layout/header.php';
include_once '../../Controllers/TourController.php';

$tourController = new TourController();

// Initialize search filters
$filters = [
    'name' => $_GET['name'] ?? '',
    'destination' => $_GET['destination'] ?? '',
    'min_price' => $_GET['min_price'] ?? '',
    'max_price' => $_GET['max_price'] ?? '',
    'duration' => $_GET['duration'] ?? ''
];

// Get filtered tours
$tours = $tourController->getFilteredTours(
    $filters['destination'],
    $filters['min_price'],
    $filters['max_price'],
    $filters['duration'],
    $filters['name']
);

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
            <h6 class="mb-0">Tours List</h6>
          </div>
          <div class="col-6 text-end">
            <a href="add-tour.php" class="btn bg-gradient-dark mb-0">
              <i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Tour
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
            <label class="form-label">Tour Name</label>
            <input type="text" name="name" class="form-control" placeholder="Search by name" 
                   value="<?php echo htmlspecialchars($filters['name']); ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" placeholder="Search by destination" 
                   value="<?php echo htmlspecialchars($filters['destination']); ?>">
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
          <div class="col-md-2">
            <label class="form-label">Duration (days)</label>
            <input type="number" name="duration" class="form-control" placeholder="Duration" 
                   value="<?php echo htmlspecialchars($filters['duration']); ?>">
          </div>
          <div class="col-md-12 text-end">
            <button type="submit" class="btn bg-gradient-info">
              <i class="fas fa-search"></i> Search
            </button>
            <a href="tours-list.php" class="btn bg-gradient-secondary">
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
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tour Name</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Destination</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Duration</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tours as $tour): ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($tour['name']); ?></h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($tour['destination']); ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($tour['duration']); ?> days</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold"><?php echo htmlspecialchars($tour['price']); ?> DT</span>
                </td>
                <td class="align-middle text-center">
                  <a href="update-tour.php?id=<?php echo $tour['id']; ?>" class="text-secondary font-weight-bold text-xs mx-2" data-toggle="tooltip" data-original-title="Edit tour">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="delete-tour.php?id=<?php echo $tour['id']; ?>" class="text-danger font-weight-bold text-xs mx-2" data-toggle="tooltip" data-original-title="Delete tour" onclick="return confirm('Are you sure you want to delete this tour?');">
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
