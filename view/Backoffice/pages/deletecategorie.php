<?php
include '../../../controller/categoriecontroller.php';
$categorieC = new categorieventController();
$categorieC->deletecategorie($_GET["id"]);
header('Location:listecategorie.php');
