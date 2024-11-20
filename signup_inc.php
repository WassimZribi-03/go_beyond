<?php
//require_once "connect.php";
if(require_once "connect.php"){
    echo "connection worked";
}else{
    echo "connection didn't worked";
}


$Fname = mysqli_real_escape_string($db, $_POST['nom']);
$Lname = mysqli_real_escape_string($db, $_POST['prenom']);
$role = mysqli_real_escape_string($db, $_POST['role']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$confirm_password = mysqli_real_escape_string($db, $_POST['confirm-password']);

// Ensure the query string is correct
$sql = "INSERT INTO users (FisrtName, LastName, Email, Password, Role) VALUES ('$Fname', '$Lname', '$email', '$password', '$role')";

$result = mysqli_query($db, $sql);

if ($result) {
    header("location: index.php");
    echo "User registered successfully!";
} else {
    echo "Error: " . mysqli_error($db);
}
?>