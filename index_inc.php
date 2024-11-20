<?php
    //require_once "connect.php";
   

    if(require_once "connect.php"){
        echo "connection worked";
    }else{
        echo "connection didn't worked";
    }
   session_start();
   $error='';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
   
      // username and password sent from form 
      $email = mysqli_real_escape_string($db,$_POST['email']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 

      $sql = "SELECT * FROM users WHERE Email = '$email' and Password = '$mypassword'";

      $result = mysqli_query($db,$sql);      
      $row = mysqli_num_rows($result);      
      $count = mysqli_num_rows($result);

      if($count == 1) {
	  
         // session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("Location: add.php");
         exit;
      } else {
         $error = "Your Login Name or Password is invalid";
         echo $error;
         header("Location: index.php");
         exit;
      }
   }
?>