<?php

include '../config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'like_post.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
   

<?php include '../view/frontoffice/user_header.php'; ?>





<section class="categories">

   <h1 class="heading">post categories</h1>

   <div class="box-container">
      <div class="box"><span>01</span><a href="category.php?category=Destinations">Destinations</a></div>
      <div class="box"><span>02</span><a href="category.php?category=Astuces et Conseils de Voyage">Astuces et Conseils de Voyage</a></div>
      <div class="box"><span>04</span><a href="category.php?category=Expériences Client">Expériences Client</a></div>
      <div class="box"><span>05</span><a href="category.php?category=Guides Pratiques">Guides Pratiques</a></div>
      <div class="box"><span>06</span><a href="category.php?category=Voyages Responsables et Écologiques"> Voyages Responsables et Écologiques</a></div>
      <div class="box"><span>07</span><a href="category.php?category=Offres et Promotions">Offres et Promotions</a></div>
      <div class="box"><span>08</span><a href="category.php?category=Culture et Traditions">Culture et Traditions</a></div>
      <div class="box"><span>09</span><a href="category.php?category=Voyages par Thèmes">Voyages par Thèmes</a></div>
      <div class="box"><span>10</span><a href="category.php?category=Technologie et Voyage"> Technologie et Voyage</a></div>
      <div class="box"><span>11</span><a href="category.php?category=Voyages de Luxe">Voyages de Luxe</a></div>
      <div class="box"><span>12</span><a href="category.php?category=Aventures et Activités en Plein Air">Aventures et Activités en Plein Air</a></div>
      <div class="box"><span>13</span><a href="category.php?category= Voyages Spirituels et Bien-être"> Voyages Spirituels et Bien-être</a></div>
      <div class="box"><span>14</span><a href="category.php?category=Voyages en Famille">Voyages en Famille</a></div>
      <div class="box"><span>15</span><a href="category.php?category= Voyages de Groupe"> Voyages de Groupe</a></div>
      <div class="box"><span>16</span><a href="category.php?category=Voyages Gastronomiques">Voyages Gastronomiques</a></div>
      <div class="box"><span>17</span><a href="category.php?category=Transports et Logistique">Transports et Logistique</a></div>
      <div class="box"><span>18</span><a href="category.php?category=Voyages à Petit Budget">Voyages à Petit Budget</a></div>
      <div class="box"><span>19</span><a href="category.php?category=Voyages Insolites"> Voyages Insolites</a></div>
      <div class="box"><span>20</span><a href="category.php?category=Voyages Historiques"> Voyages Historiques</a></div>
   </div>

</section>













<script src="../assets/js/script.js"></script>

</body>
</html>