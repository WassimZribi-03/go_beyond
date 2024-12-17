<?php
session_start();

// Initialize the session variables if they don't exist
if (!isset($_SESSION['tour_filters'])) {
    $_SESSION['tour_filters'] = [
        'destination' => '',
        'min_price' => '',
        'max_price' => '',
        'duration' => ''
    ];
}

// Include necessary files
include_once '../../Controllers/TourController.php';

// Initialize TourController
$tourController = new TourController();

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle filter form submission
    if (isset($_POST['filter_tours'])) {
        $_SESSION['tour_filters'] = [
            'destination' => $_POST['destination'] ?? '',
            'min_price' => $_POST['min_price'] ?? '',
            'max_price' => $_POST['max_price'] ?? '',
            'duration' => $_POST['duration'] ?? ''
        ];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle clear filters
    if (isset($_POST['clear_filters'])) {
        $_SESSION['tour_filters'] = [
            'destination' => '',
            'min_price' => '',
            'max_price' => '',
            'duration' => ''
        ];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle favorite toggle
    if (isset($_POST['favorite_action'])) {
        header('Content-Type: application/json');
        try {
            $tour_id = filter_input(INPUT_POST, 'tour_id', FILTER_VALIDATE_INT);
            if (!$tour_id) {
                throw new Exception("Invalid tour ID");
            }
            $result = $tourController->addToFavorites($tour_id);
            echo json_encode($result);
            exit();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit();
        }
    }

    // Handle rating submission
    if (isset($_POST['rating'])) {
        try {
            $tour_id = filter_input(INPUT_POST, 'tour_id', FILTER_VALIDATE_INT);
            $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
            if (!$tour_id || !$rating || $rating < 1 || $rating > 5) {
                throw new Exception("Invalid input");
            }
            
            $comment = $_POST['comment'] ?? null;
            $result = $tourController->addRating($tour_id, $rating, $comment);
            
            if ($result) {
                $_SESSION['message'] = "Rating submitted successfully";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Get filtered tours
try {
    $filters = $_SESSION['tour_filters'];
    if (!empty(array_filter($filters))) {
        $tours = $tourController->getFilteredTours(
            $filters['destination'],
            $filters['min_price'],
            $filters['max_price'],
            $filters['duration']
        );
    } else {
        $tours = $tourController->listTours();
    }
} catch (Exception $e) {
    $tours = [];
    error_log("Error loading tours: " . $e->getMessage());
}

$pageTitle = 'Discover Tours';
$currentPage = 'tours';
include_once 'layout/header.php';
?>

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Discover Our Tours</h2>
                <span>Embark on unforgettable journeys through our carefully curated selection of extraordinary destinations</span>
            </div>
        </div>
    </div>
</div>

<div class="shows-events-schedule">
    <div class="container">
        <!-- Filter Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <form method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Destination</label>
                        <input type="text" name="destination" class="form-control" placeholder="Where to?"
                               value="<?php echo htmlspecialchars($_SESSION['tour_filters']['destination']); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Min Price</label>
                        <input type="number" name="min_price" class="form-control" placeholder="Min Price"
                               value="<?php echo htmlspecialchars($_SESSION['tour_filters']['min_price']); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Max Price</label>
                        <input type="number" name="max_price" class="form-control" placeholder="Max Price"
                               value="<?php echo htmlspecialchars($_SESSION['tour_filters']['max_price']); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Duration (days)</label>
                        <input type="number" name="duration" class="form-control" placeholder="Duration"
                               value="<?php echo htmlspecialchars($_SESSION['tour_filters']['duration']); ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" name="filter_tours" class="main-dark-button me-2">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" name="clear_filters" class="main-button">
                            <i class="fa fa-times"></i> Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tours Grid -->
        <div class="row">
            <?php foreach($tours as $tour): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="event-item">
                        <div class="thumb">
                            <img src="<?php echo htmlspecialchars($tour['image_url'] ?? 'assets/images/default-tour.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($tour['name']); ?>">
                            <div class="price">
                                <span><?php echo htmlspecialchars($tour['price']); ?> DT</span>
                            </div>
                        </div>
                        <div class="down-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4><?php echo htmlspecialchars($tour['name']); ?></h4>
                                <button class="favorite-btn <?php echo ($tourController->isFavorited($tour['id'])) ? 'active' : ''; ?>" 
                                        onclick="toggleFavorite(this, <?php echo (int)$tour['id']; ?>)"
                                        type="button">
                                    <i class="fa fa-heart" style="color: <?php echo ($tourController->isFavorited($tour['id'])) ? '#ff0000' : '#ccc'; ?>"></i>
                                </button>
                            </div>
                            <ul>
                                <li><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($tour['destination']); ?></li>
                                <li><i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($tour['duration']); ?> days</li>
                            </ul>
                            <p><?php echo htmlspecialchars($tour['description']); ?></p>

                            <!-- Rating Section -->
                            <?php 
                            $ratingData = $tourController->getAverageRating($tour['id']);
                            $averageRating = $ratingData['average'];
                            $ratingCount = $ratingData['count'];
                            ?>
                            <div class="rating-section text-center mb-4">
                                <h5>Rating: <?php echo $averageRating; ?> / 5</h5>
                                <div class="stars-display">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $averageRating): ?>
                                            <i class="fa fa-star"></i>
                                        <?php elseif ($i - 0.5 <= $averageRating): ?>
                                            <i class="fa fa-star-half-o"></i>
                                        <?php else: ?>
                                            <i class="fa fa-star-o"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <small>(<?php echo $ratingCount; ?> ratings)</small>
                            </div>

                            <!-- Rating Form -->
                            <form method="POST" class="rating-form mb-4">
                                <input type="hidden" name="tour_id" value="<?php echo (int)$tour['id']; ?>">
                                <div class="stars text-center mb-2">
                                    <?php for($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" name="rating" value="<?php echo $i; ?>" 
                                               id="star<?php echo $tour['id']; ?>-<?php echo $i; ?>">
                                        <label for="star<?php echo $tour['id']; ?>-<?php echo $i; ?>">
                                            <i class="fa fa-star"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                                <textarea name="comment" class="form-control mb-2" placeholder="Write your review (optional)"></textarea>
                                <button type="submit" class="main-button w-100">Submit Rating</button>
                            </form>

                            <div class="main-dark-button">
                                <a href="book-tour.php?tour_id=<?php echo (int)$tour['id']; ?>">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function toggleFavorite(button, tourId) {
    const formData = new FormData();
    formData.append('favorite_action', 'toggle');
    formData.append('tour_id', tourId);
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.toggle('active');
            const heart = button.querySelector('i');
            heart.style.color = button.classList.contains('active') ? '#ff0000' : '#ccc';
            showMessage(data.action === 'added' ? 'Added to favorites!' : 'Removed from favorites!');
        } else {
            throw new Error(data.error || 'Failed to update favorites');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error updating favorites', 'error');
    });
}

function showMessage(message, type = 'success') {
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : '#f44336'};
        color: white;
        padding: 12px 24px;
        border-radius: 4px;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    `;
    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.style.opacity = '0';
        messageDiv.style.transition = 'opacity 0.3s ease';
        setTimeout(() => messageDiv.remove(), 300);
    }, 2000);
}
</script>

<?php include_once 'layout/footer.php'; ?>