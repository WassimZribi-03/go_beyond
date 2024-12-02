<?php
include_once '../../Controllers/TourController.php';
include_once '../../Models/Tour.php';

$tourController = new TourController();
$error = "";
$tour = null;

if (isset($_GET['id'])) {
    $tour = $tourController->showTour($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $tour = new Tour(
            $_GET['id'],
            $_POST['name'],
            $_POST['destination'],
            $_POST['duration'],
            $_POST['price'],
            $_POST['description']
        );
        
        $tourController->updateTour($tour, $_GET['id']);
        header('Location: tours-list.php');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tour</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        label, input, textarea { display: block; width: 100%; margin: 10px 0; }
        button { padding: 10px 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Update Tour</h1>
    
    <form id="updateForm" method="POST" onsubmit="return validateForm(event)">
        <div>
            <label for="name">Tour Name</label>
            <input type="text" id="name" name="name" value="<?php echo $tour['name'] ?? ''; ?>">
        </div>

        <div>
            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" value="<?php echo $tour['destination'] ?? ''; ?>">
        </div>

        <div>
            <label for="duration">Duration (days)</label>
            <input type="number" id="duration" name="duration" value="<?php echo $tour['duration'] ?? ''; ?>">
        </div>

        <div>
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo $tour['price'] ?? ''; ?>">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo $tour['description'] ?? ''; ?></textarea>
        </div>

        <button type="submit">Update Tour</button>
    </form>

    <script>
        function validateForm(event) {
            event.preventDefault();
            
            // Name validation
            const name = document.getElementById('name').value.trim();
            if (name.length < 3 || name.length > 50) {
                alert('Tour name must be between 3 and 50 characters');
                document.getElementById('name').focus();
                return false;
            }

            // Destination validation
            const destination = document.getElementById('destination').value.trim();
            if (destination.length < 3 || destination.length > 50) {
                alert('Destination must be between 3 and 50 characters');
                document.getElementById('destination').focus();
                return false;
            }

            // Duration validation
            const duration = parseInt(document.getElementById('duration').value);
            if (isNaN(duration) || duration < 1 || duration > 30) {
                alert('Duration must be between 1 and 30 days');
                document.getElementById('duration').focus();
                return false;
            }

            // Price validation
            const price = parseFloat(document.getElementById('price').value);
            if (isNaN(price) || price <= 0) {
                alert('Price must be greater than 0');
                document.getElementById('price').focus();
                return false;
            }

            // Description validation
            const description = document.getElementById('description').value.trim();
            if (description.length < 10 || description.length > 1000) {
                alert('Description must be between 10 and 1000 characters');
                document.getElementById('description').focus();
                return false;
            }

            // If all validations pass, submit the form
            document.getElementById('updateForm').submit();
            return true;
        }
    </script>
</body>
</html>
