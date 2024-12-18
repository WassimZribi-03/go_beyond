<?php
include '../config.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Authors</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<!-- Begin authors section -->
<section class="authors">

   <h1 class="heading">Authors</h1>

   <div class="box-container">

   <?php
      // Select authors from the admin table
      $select_author = $conn->prepare("SELECT * FROM `admin`");
      $select_author->execute();

      // If authors are found, display their details
      if ($select_author->rowCount() > 0) {
         while ($fetch_authors = $select_author->fetch(PDO::FETCH_ASSOC)) {

            // Count the active posts for each author
            $count_admin_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
            $count_admin_posts->execute([$fetch_authors['id'], 'active']);
            $total_admin_posts = $count_admin_posts->rowCount();

            // Count likes and comments for each author
            $count_admin_likes = $conn->prepare("SELECT * FROM `likes` WHERE admin_id = ?");
            $count_admin_likes->execute([$fetch_authors['id']]);
            $total_admin_likes = $count_admin_likes->rowCount();

            $count_admin_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
            $count_admin_comments->execute([$fetch_authors['id']]);
            $total_admin_comments = $count_admin_comments->rowCount();
   ?>
   
   <div class="box">
      <p>Author: <span><?= $fetch_authors['name']; ?></span></p>
      <p>Total Posts: <span><?= $total_admin_posts; ?></span></p>
      <p>Posts Likes: <span><?= $total_admin_likes; ?></span></p>
      <p>Posts Comments: <span><?= $total_admin_comments; ?></span></p>
      <a href="author_posts.php?author=<?= $fetch_authors['name']; ?>" class="btn">View Posts</a>
   </div>

   <?php
         }
      } else {
         echo '<p class="empty">No authors found.</p>';
      }
   ?>

   </div>

</section>

<!-- JavaScript for functionality, if necessary -->
<script src="../assets/js/script.js"></script>

</body>
</html>
