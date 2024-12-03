<?php
include_once '../../Controllers/TourController.php';
$tourController = new TourController();
$tours = $tourController->listTours();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Our Tours</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin: 40px 0;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .tour-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .tour-card:hover {
            transform: translateY(-5px);
        }

        .tour-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .tour-content {
            padding: 20px;
        }

        .tour-card h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .tour-info {
            margin: 10px 0;
            color: #34495e;
        }

        .price {
            font-size: 1.4em;
            color: #e74c3c;
            font-weight: bold;
            margin: 15px 0;
        }

        .description {
            color: #7f8c8d;
            margin: 15px 0;
            line-height: 1.6;
        }

        .book-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .book-btn:hover {
            background: #2980b9;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Discover Our Tours</h1>
        <div class="tours-grid">
            <?php while ($tour = $tours->fetch(PDO::FETCH_ASSOC)) : ?>
                <div class="tour-card">
                    <div class="tour-content">
                        <h2><?php echo htmlspecialchars($tour['name']); ?></h2>
                        <div class="tour-info">
                            <p>
                                <i class="fas fa-map-marker-alt"></i>
                                <strong>Destination:</strong> <?php echo htmlspecialchars($tour['destination']); ?>
                            </p>
                            <p>
                                <i class="fas fa-clock"></i>
                                <strong>Duration:</strong> <?php echo htmlspecialchars($tour['duration']); ?> days
                            </p>
                        </div>
                        <div class="price"><?php echo htmlspecialchars($tour['price']); ?> DT</div>
                        <p class="description"><?php echo htmlspecialchars($tour['description']); ?></p>
                        <button class="book-btn" onclick="bookTour(<?php echo $tour['id']; ?>, '<?php echo htmlspecialchars($tour['name']); ?>', <?php echo $tour['price']; ?>)">
                            Book Now
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function bookTour(tourId, tourName, tourPrice) {
            // Store tour info in sessionStorage
            sessionStorage.setItem('selectedTourId', tourId);
            sessionStorage.setItem('selectedTourName', tourName);
            sessionStorage.setItem('tourPrice', `${tourPrice} DT`);
            // Redirect to booking page
            window.location.href = 'book-tour.php';
        }
    </script>
</body>
</html> 