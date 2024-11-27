<?php
    require_once "connect.php";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="sign_up.css">
</head>
<body>
    <form action="signup_inc.php" method="post" class="sign-up-form">
        <div class="container">
            <!-- Replace with your logo image -->
            <img src="logo150.png" alt="Logo" class="logo">
            
            <input type="text" id="nom" name="nom" placeholder="First Name">
            <input type="text" id="prenom" name="prenom" placeholder="Last Name">
            <input type="text" id="username" name="role" placeholder="Role">
            <input type="text" id="email" name="email" placeholder="Email">
            <input type="password" id="password" name="password" placeholder="Password">
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your Password">
            <button type="submit">Sign Up</button>
            <button type="reset">Clear</button>
            <br>
            <h5>Already have an account? <a href="index.php">Login</a></h5>
            
            <p class="terms">En vous inscrivant, vous acceptez nos <a href="#">Conditions générales</a> et <a href="#">Politique de confidentialité</a>.</p>
        </div>
    </form>   
    <script src="action.js"></script>
</body>
</html>
</body>
</html>
