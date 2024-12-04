<?php
require_once "connect.php"; // Include your database connection

function fetchMembers($db) {
    $sql = "SELECT FisrtName, LastName, Email FROM users"; // Adjust the query based on your table structure
    $result = $db->query($sql);

    if (!$result) {
        die("Query failed: " . $db->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="list-item">';
            echo '<span class="member-name">' . htmlspecialchars($row['FisrtName']) . ' ' . htmlspecialchars($row['LastName']) . '</span>';
            echo ' , ';
            echo '<span class="member-email">' . htmlspecialchars($row['Email']) . '</span>';
            echo '   ';
            echo '<button class="btn btn-delete" onclick="deleteMember(\'' . htmlspecialchars($row['Email']) . '\')">Delete</button>'; // Pass the email for deletion
            echo '</div>';
        }
    } else {
        echo '<div class="list-item">No members found</div>';
    }
}

fetchMembers($db); // Call the function to output the members
?>