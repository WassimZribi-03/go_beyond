<?php
require_once "connect.php"; // Include your database connection

// Check if the email parameter is set in the URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $db->prepare("DELETE FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email); // "s" indicates the type is string

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect back to the members page or display a success message
        header("Location: add2.php?message=Member deleted successfully");
        exit();
    } else {
        // Handle error
        echo "Error deleting member: " . $db->error;
    }

    $stmt->close();
} else {
    echo "No email provided.";
}

$db->close();
?>