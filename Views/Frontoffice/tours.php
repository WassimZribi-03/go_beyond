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

// Handle filter form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['filter_tours'])) {
        $_SESSION['tour_filters'] = [
            'destination' => $_POST['destination'] ?? '',
            'min_price' => $_POST['min_price'] ?? '',
            'max_price' => $_POST['max_price'] ?? '',
            'duration' => $_POST['duration'] ?? ''
        ];
    } elseif (isset($_POST['clear_filters'])) {
        $_SESSION['tour_filters'] = [
            'destination' => '',
            'min_price' => '',
            'max_price' => '',
            'duration' => ''
        ];
    }
}

// Include necessary files
include_once '../../Controllers/TourController.php';

// Initialize TourController
$tourController = new TourController();

// Get filtered tours or all tours if no filters
$filters = $_SESSION['tour_filters'];
try {
    if (!empty(array_filter($filters))) {
        // If there are active filters, use getFilteredTours
        $tours = $tourController->getFilteredTours(
            $filters['destination'],
            $filters['min_price'],
            $filters['max_price'],
            $filters['duration']
        );
    } else {
        // If no filters, get all tours
        $tours = $tourController->listTours()->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    // Handle any errors
    $tours = [];
    echo "<script>alert('Error loading tours: " . addslashes($e->getMessage()) . "');</script>";
}

// Ensure $tours is always an array
if (!is_array($tours)) {
    $tours = [];
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
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --text-color: #1f2937;
            --light-gray: #f3f4f6;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .hero-section {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 4rem 0;
            margin-bottom: 3rem;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .filter-section {
            background: var(--white);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
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
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .filter-item input:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6b7280;
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: #4b5563;
            transform: translateY(-2px);
        }

        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .tour-card {
            background: var(--white);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .tour-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .tour-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .tour-price {
            position: absolute;
            right: 1rem;
            top: 1rem;
            background: rgba(37, 99, 235, 0.9);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
        }

        .tour-content {
            padding: 1.5rem;
        }

        .tour-title {
            font-size: 1.25rem;
            color: var(--text-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .tour-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: #6b7280;
        }

        .tour-info i {
            color: var(--accent-color);
        }

        .tour-actions {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .hero-section {
                padding: 2rem 1rem;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .tours-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <h1>Discover Our Tours</h1>
            <p>Find your perfect adventure from our carefully curated selection</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
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

        <!-- Tours Grid -->
        <div class="tours-grid">
            <?php foreach($tours as $tour): ?>
                <div class="tour-card">
                    <div class="tour-image" 
                         style="background-image: url('<?php echo htmlspecialchars($tour['image_url'] ?? 'default.jpg'); ?>')">
                        <div class="tour-price"><?php echo htmlspecialchars($tour['price']); ?> DT</div>
                    </div>
                    <div class="tour-content">
                        <h3 class="tour-title"><?php echo htmlspecialchars($tour['name']); ?></h3>
                        <div class="tour-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($tour['destination']); ?></span>
                        </div>
                        <div class="tour-info">
                            <i class="fas fa-clock"></i>
                            <span><?php echo htmlspecialchars($tour['duration']); ?> days</span>
                        </div>
                        <div class="tour-actions">
                            <a href="book-tour.php?tour_id=<?php echo $tour['id']; ?>" class="btn btn-primary">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>