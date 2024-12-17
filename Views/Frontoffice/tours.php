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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Tours</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #D2B48C; /* Tan/Beige */
            --secondary-color: #BC8F8F; /* RosyBrown */
            --accent-color: #DEB887; /* BurlyWood */
            --text-color: #5D4037; /* Dark Brown */
            --light-beige: #F5F5DC; /* Light Beige */
            --white: #FFFFFF;
            --dark-beige: #A0866C; /* Darker Beige for contrast */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-beige);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .tour-card {
            background: var(--white);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            padding: 0;
            border: 1px solid rgba(210,180,140,0.2);
        }

        .tour-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            transition: transform 0.3s ease;
        }

        .tour-content {
            padding: 2rem;
        }

        .tour-card:hover .tour-image {
            transform: scale(1.05);
        }

        .image-container {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .price-tag {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(44, 62, 80, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: bold;
        }

        .destination-tag {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .destination-tag i {
            color: var(--accent-color);
        }

        .tour-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .tour-card h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            padding-right: 40px; /* Space for favorite button */
        }

        .tour-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            color: #666;
        }

        .tour-info i {
            color: var(--accent-color);
            margin-right: 0.5rem;
            width: 20px;
        }

        .description {
            margin: 1rem 0;
            color: #666;
            line-height: 1.6;
        }

        .favorite-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .favorite-btn i {
            color: #ccc;
            transition: color 0.3s ease;
        }

        .favorite-btn.active i {
            color: #ff0000;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
        }

        .rating-section {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .rating-section h3 {
            color: var(--text-color);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .stars input {
            display: none;
        }

        .stars label {
            cursor: pointer;
            font-size: 1.8rem;
            color: #ddd;
            transition: color 0.2s ease;
        }

        .stars:hover label:hover,
        .stars:hover label:hover ~ label,
        .stars input:checked ~ label {
            color: #ffd700;
        }

        .stars:hover label:hover ~ label {
            color: #ffd700;
        }

        .review-form textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 1rem 0;
            resize: vertical;
            min-height: 80px;
        }

        .submit-rating {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 100%;
        }

        .submit-rating:hover {
            background-color: var(--secondary-color);
        }

        .book-btn {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
            transition: background-color 0.2s ease;
            text-align: center;
            width: 100%;
        }

        .book-btn:hover {
            background-color: var(--secondary-color);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .tours-grid {
                grid-template-columns: 1fr;
            }

            .tour-card {
                margin-bottom: 1rem;
            }
        }

        .average-rating {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .stars-display {
            color: #ffd700;
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }

        .stars-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .stars-input input {
            display: none;
        }

        .stars-input label {
            cursor: pointer;
            font-size: 1.8rem;
            color: #ddd;
            transition: color 0.2s ease;
        }

        .stars-input:hover label:hover,
        .stars-input:hover label:hover ~ label,
        .stars-input input:checked ~ label {
            color: #ffd700;
        }

        .filter-section {
            background: var(--white);
            border-radius: 1rem;
            padding: 2.5rem;
            margin-bottom: 3rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-item label {
            font-weight: 600;
            color: var(--text-color);
        }

        .filter-item input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--text-color);
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: var(--dark-beige);
            color: var(--white);
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--text-color);
            padding: 10rem 0; /* Even bigger */
            margin-bottom: 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(45deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%),
                url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
            max-width: 900px; /* Even wider */
        }

        .hero-section h1 {
            font-size: 5rem; /* Bigger */
            margin-bottom: 2rem;
            font-weight: 800; /* Bolder */
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            color: var(--white);
            letter-spacing: 3px;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .hero-section p {
            font-size: 1.6rem;
            opacity: 0.95;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            color: var(--white);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            font-weight: 300; /* Lighter weight for contrast */
        }

        .hero-decorative {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .hero-decorative::before,
        .hero-decorative::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .hero-decorative::before {
            top: -100px;
            left: -100px;
        }

        .hero-decorative::after {
            bottom: -100px;
            right: -100px;
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }

        .hero-section h1 {
            animation: float 6s ease-in-out infinite;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 8rem 0;
            }

            .hero-section h1 {
                font-size: 3rem;
                letter-spacing: 2px;
            }

            .hero-section p {
                font-size: 1.2rem;
                padding: 0 2rem;
            }
        }

        .footer {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 3rem 0 1.5rem 0;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section {
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: var(--white);
            font-size: 1.2rem;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: var(--accent-color);
        }

        .footer-section p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-links a:hover {
            color: var(--white);
            padding-left: 0.5rem;
        }

        .footer-links i {
            font-size: 0.8rem;
            color: var(--accent-color);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: var(--white);
            background: rgba(255, 255, 255, 0.1);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
            }

            .footer-section {
                text-align: center;
            }

            .footer-section h3::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-links {
                justify-content: center;
            }

            .footer-links a {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Add this hero section -->
    <div class="hero-section">
        <div class="hero-decorative"></div>
        <div class="container">
            <h1>Discover Our Tours</h1>
            <p>Embark on unforgettable journeys through our carefully curated selection of extraordinary destinations. Experience the world's most breathtaking locations with our expert-guided tours.</p>
        </div>
    </div>

    <div class="container">
        <div class="filter-section">
            <form method="POST" class="filter-grid">
                <div class="filter-item">
                    <label>Destination</label>
                    <input type="text" name="destination" placeholder="Where to?"
                           value="<?php echo htmlspecialchars($_SESSION['tour_filters']['destination']); ?>">
                </div>
                <div class="filter-item">
                    <label>Min Price</label>
                    <input type="number" name="min_price" placeholder="Min Price"
                           value="<?php echo htmlspecialchars($_SESSION['tour_filters']['min_price']); ?>">
                </div>
                <div class="filter-item">
                    <label>Max Price</label>
                    <input type="number" name="max_price" placeholder="Max Price"
                           value="<?php echo htmlspecialchars($_SESSION['tour_filters']['max_price']); ?>">
                </div>
                <div class="filter-item">
                    <label>Duration (days)</label>
                    <input type="number" name="duration" placeholder="Duration"
                           value="<?php echo htmlspecialchars($_SESSION['tour_filters']['duration']); ?>">
                </div>
                <div class="filter-item">
                    <button type="submit" name="filter_tours" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search Tours
                    </button>
                    <button type="submit" name="clear_filters" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear Filters
                    </button>
                </div>
            </form>
        </div>

        <div class="tours-grid">
            <?php foreach($tours as $tour): ?>
                <div class="tour-card">
                    <div class="image-container">
                        <img src="<?php echo htmlspecialchars($tour['image_url'] ?? 'assets/images/default-tour.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($tour['name']); ?>" 
                             class="tour-image">
                        <div class="destination-tag">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($tour['destination']); ?>
                        </div>
                        <div class="price-tag">
                            <?php echo htmlspecialchars($tour['price']); ?> DT
                        </div>
                    </div>
                    
                    <div class="tour-content">
                        <button class="favorite-btn <?php echo ($tourController->isFavorited($tour['id'])) ? 'active' : ''; ?>" 
                                onclick="toggleFavorite(this, <?php echo (int)$tour['id']; ?>)"
                                type="button">
                            <i class="fas fa-heart" style="color: <?php echo ($tourController->isFavorited($tour['id'])) ? '#ff0000' : '#ccc'; ?>"></i>
                        </button>

                        <h2><?php echo htmlspecialchars($tour['name']); ?></h2>
                        <div class="tour-info">
                            <i class="fas fa-clock"></i>
                            <span><?php echo htmlspecialchars($tour['duration']); ?> days</span>
                        </div>
                        <p class="description">
                            <?php echo htmlspecialchars($tour['description']); ?>
                        </p>

                        <div class="rating-section">
                            <?php 
                            $ratingData = $tourController->getAverageRating($tour['id']);
                            $averageRating = $ratingData['average'];
                            $ratingCount = $ratingData['count'];
                            ?>
                            <div class="average-rating">
                                <h3>Average Rating: <?php echo $averageRating; ?> / 5</h3>
                                <p class="rating-count">(<?php echo $ratingCount; ?> ratings)</p>
                                <div class="stars-display">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $averageRating): ?>
                                            <i class="fas fa-star"></i>
                                        <?php elseif ($i - 0.5 <= $averageRating): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <h3>Rate this Tour</h3>
                            <form method="POST" class="review-form">
                                <input type="hidden" name="tour_id" value="<?php echo (int)$tour['id']; ?>">
                                <div class="stars-input">
                                    <?php for($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" name="rating" value="<?php echo $i; ?>" 
                                               id="star<?php echo $tour['id']; ?>-<?php echo $i; ?>">
                                        <label for="star<?php echo $tour['id']; ?>-<?php echo $i; ?>">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                                <textarea name="comment" placeholder="Write your review (optional)"></textarea>
                                <button type="submit" class="submit-rating">Submit Rating</button>
                            </form>
                        </div>

                        <a href="book-tour.php?tour_id=<?php echo (int)$tour['id']; ?>" class="book-btn">
                            Book Now
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
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
                animation: slideIn 0.3s ease-out;
                z-index: 1000;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            `;
            document.body.appendChild(messageDiv);

            setTimeout(() => {
                messageDiv.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => messageDiv.remove(), 300);
            }, 2000);
        }
    </script>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Go Beyond</h3>
                <p>Discover amazing destinations and create unforgettable memories with our expertly curated tours. We're dedicated to providing exceptional travel experiences.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="tours.php"><i class="fas fa-chevron-right"></i> Tours</a></li>
                    <li><a href="my-bookings.php"><i class="fas fa-chevron-right"></i> My Bookings</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-phone"></i> +216 123 456 789</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i> info@gobeyond.com</a></li>
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Tunisia</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> Go Beyond. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>