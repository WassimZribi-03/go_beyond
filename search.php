<?php
require_once "connect.php"; // Include your database connection

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = mysqli_real_escape_string($db, $_POST['keyword']);
    
    // Query to search for members
    $sql = "SELECT FisrtName, LastName, Email FROM users WHERE FisrtName LIKE '%$keyword%' OR LastName LIKE '%$keyword%' OR Email LIKE '%$keyword%'";
    $result = $db->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $db->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="list-item">';
            echo '<span class="member-name">' . htmlspecialchars($row['FisrtName']) . ' ' . htmlspecialchars($row['LastName']) . '</span>';
            echo ' , ';
            echo '<span class="member-email">' . htmlspecialchars($row['Email']) . '</span>';
            echo '  ';
            echo '<button class="btn btn-delete" onclick="deleteMember(\'' . htmlspecialchars($row['Email']) . '\')">Delete</button>';
            echo '</div>';
        }
    } else {
        echo '<div class="list-item">No members found</div>';
    }
}
?>