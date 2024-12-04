<?php
require_once "connect.php";
 
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $mypassword = mysqli_real_escape_string($db, $_POST['password']);

    // Use prepared statements to prevent SQL injection
    $stmt = $db->prepare("SELECT Password, Role FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($mypassword, $row['Password'])) {
            // Store user email in session
            $_SESSION['login_user'] = $row['Email'];

            // Redirect based on role
            if ($row['Role'] === 'Admin') {
                header("Location: add2.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            $error = "Your Login Name or Password is invalid";
        }
    } else {
        $error = "Your Login Name or Password is invalid";
    }

    // Redirect back to login page with an error
    header("Location: index.php?error=" . urlencode($error));
    exit();
}
?>