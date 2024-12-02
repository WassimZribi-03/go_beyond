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
    <title>Tours List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .tour-list { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .actions { margin: 20px 0; }
        .btn { padding: 10px 15px; margin: 0 5px; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .btn-add { background-color: #28a745; }
        .btn-edit { background-color: #007bff; }
        .btn-delete { background-color: #dc3545; }
        .message { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .message-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <h1>Tours List</h1>
    
    <?php
    // Display success message if any
    if (isset($_GET['message'])) {
        echo '<div class="message message-success">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    // Display error message if any
    if (isset($_GET['error'])) {
        echo '<div class="message message-error">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>
    
    <div class="actions">
        <a href="add-tour.php" class="btn btn-add">Add New Tour</a>
    </div>

    <div class="tour-list">
        <?php if ($tours && $tours->rowCount() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Destination</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tour['id']); ?></td>
                            <td><?php echo htmlspecialchars($tour['name']); ?></td>
                            <td><?php echo htmlspecialchars($tour['destination']); ?></td>
                            <td><?php echo htmlspecialchars($tour['duration']); ?> days</td>
                            <td>$<?php echo htmlspecialchars($tour['price']); ?></td>
                            <td><?php echo htmlspecialchars($tour['description']); ?></td>
                            <td>
                                <a href="update-tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="delete-tour.php?id=<?php echo $tour['id']; ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this tour?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tours found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
