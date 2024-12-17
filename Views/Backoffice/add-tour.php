<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../Controllers/TourController.php';
include_once '../../Models/Tour.php';

$tourController = new TourController();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Debug: Print POST data
        var_dump($_POST);
        
        // Create tour object
        $tour = new Tour(
            null,
            $_POST['name'],
            $_POST['destination'],
            intval($_POST['duration']),  // Ensure integer
            floatval($_POST['price']),   // Ensure float
            $_POST['description'],
            null
        );
        
        // Handle image if present
        $image = null;
        if (isset($_FILES['tour_image']) && $_FILES['tour_image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['tour_image'];
        }

        // Try to add the tour
        $result = $tourController->addTour($tour, $image);
        
        if ($result) {
            header('Location: tours-list.php?message=' . urlencode('Tour added successfully'));
            exit();
        } else {
            throw new Exception("Failed to add tour");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        // Debug: Print error
        echo "<div style='color: red; padding: 10px;'>" . htmlspecialchars($error) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #34495E;
            --accent-color: #3498DB;
            --success-color: #2ECC71;
            --warning-color: #F1C40F;
            --danger-color: #E74C3C;
            --text-color: #2C3E50;
            --light-bg: #ECF0F1;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .form-container {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        input, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid var(--light-bg);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .error {
            color: var(--danger-color);
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: var(--white);
        }

        .btn-secondary {
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .message {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            animation: slideIn 0.3s ease;
        }

        .message-success {
            background-color: var(--success-color);
            color: var(--white);
        }

        .message-error {
            background-color: var(--danger-color);
            color: var(--white);
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Add New Tour</h1>
            <p>Create a new tour package</p>
        </div>

        <div class="form-container">
            <form id="tourForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="hidden" name="submit_tour" value="1">
                
                <div class="form-group">
                    <label for="name">Tour Name *</label>
                    <input type="text" id="name" name="name">
                </div>

                <div class="form-group">
                    <label for="destination">Destination *</label>
                    <input type="text" id="destination" name="destination">
                </div>

                <div class="form-group">
                    <label for="duration">Duration (days) *</label>
                    <input type="number" id="duration" name="duration">
                </div>

                <div class="form-group">
                    <label for="price">Price (DT) *</label>
                    <input type="number" id="price" name="price" step="0.01">
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="tour_image">Tour Image</label>
                    <input type="file" id="tour_image" name="tour_image" accept="image/*">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Tour
                    </button>
                    <a href="tours-list.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Tours
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            try {
                // Name validation
                const name = document.getElementById('name').value.trim();
                if (!name || name.length < 3 || name.length > 50) {
                    alert('Tour name must be between 3 and 50 characters');
                    document.getElementById('name').focus();
                    return false;
                }

                // Destination validation
                const destination = document.getElementById('destination').value.trim();
                if (!destination || destination.length < 3 || destination.length > 50) {
                    alert('Destination must be between 3 and 50 characters');
                    document.getElementById('destination').focus();
                    return false;
                }

                // Duration validation
                const duration = document.getElementById('duration').value.trim();
                const durationNum = parseInt(duration);
                if (!duration || isNaN(durationNum) || durationNum < 1 || durationNum > 30) {
                    alert('Duration must be between 1 and 30 days');
                    document.getElementById('duration').focus();
                    return false;
                }

                // Price validation
                const price = document.getElementById('price').value.trim();
                const priceNum = parseFloat(price);
                if (!price || isNaN(priceNum) || priceNum <= 0) {
                    alert('Price must be greater than 0');
                    document.getElementById('price').focus();
                    return false;
                }

                // Description validation
                const description = document.getElementById('description').value.trim();
                if (!description || description.length < 10 || description.length > 1000) {
                    alert('Description must be between 10 and 1000 characters');
                    document.getElementById('description').focus();
                    return false;
                }

                // Debug: Log form submission
                console.log('Form validation passed, submitting...');
                return true;
            } catch (error) {
                console.error('Validation error:', error);
                return false;
            }
        }

        // Add input restrictions
        document.getElementById('duration').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value > 30) this.value = 30;
            if (this.value < 0) this.value = 0;
        });

        document.getElementById('price').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    </script>
</body>
</html>
