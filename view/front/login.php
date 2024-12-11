<?php
require_once '../../controller/user_controller.php';  // Include the user controller

$controller = new UserController(); // Create an instance of the controller

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $loginSuccess = $controller->login($email, $password);
        
        if (!$loginSuccess) {
            $errorMessage = "Invalid email or password."; // Store error message
        } else {
            // Optionally handle successful login here if needed
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to CSS -->
</head>
<body>
    <div class="container">
        <img src="logo150.png" alt="Logo" class="logo">

        <form action="" method="post" class="login-form"> <!-- Action points to the same page -->
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit">Log In</button>
            <br><br>
            <?php if (isset($errorMessage)): ?> <!-- Display error message if exists -->
                <div style="color: red;"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <h5>Don't have an account? <a href="sign_up.php">Sign up</a></h5>
        </form>
    </div>
    <script src="action.js"></script>
</body>
</html>