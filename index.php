<?php
    require_once "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="sign_in.css">
</head>
<body>
<form action="index_inc.php" method="post">
    <div class="container">
        <form class="login-form">
            <img src="logo150.png" alt="Logo" class="logo">
           
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit">Log In</button>
            <br><br>
            <h5>Don't have an account ?  <a href="sign_up.php" >sign up</a></h5>
        </form>
    </div>
</form>
    <script src="action.js"></script>
</body>
</html>



