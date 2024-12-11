<?php
require_once '../../controller/user_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $firstName = htmlspecialchars($_POST['nom']);
    $lastName = htmlspecialchars($_POST['prenom']);
    $role = htmlspecialchars($_POST['role']) ?: 'User'; // Default to 'User' if not provided
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Simple validation
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Create a new user object (assumed you have a User class)
        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPassword($password); // Raw password to be hashed in addUser
        $user->setRole($role); // Set the user role
        $user->setUserID(uniqid()); // Generate a unique UserID

        // Initialize UserController and add the user
        $userController = new UserController();
        $userController->addUser($user);

        // Redirect or display a success message
        header('Location: login.php'); // Redirect to login after signup
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="sign_up.css">
</head>
<body>
    <form action="sign_up.php" method="post" class="sign-up-form">
        <div class="container">
            <img src="logo150.png" alt="Logo" class="logo">
            
            <input type="text" id="nom" name="nom" placeholder="First Name" required>
            <input type="text" id="prenom" name="prenom" placeholder="Last Name" required>
            <input type="text" id="username" name="role" placeholder="Role (optional)">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your Password" required>
            <button type="submit">Sign Up</button>
            <button type="reset">Clear</button>
            <br>
            <h5>Already have an account? <a href="login.php">Login</a></h5>
            <p class="terms">En vous inscrivant, vous acceptez nos <a href="#">Conditions générales</a> et <a href="#">Politique de confidentialité</a>.</p>
        </div>
    </form>   
    <script src="action.js"></script>
</body>
</html>