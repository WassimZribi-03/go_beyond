<?php
include '../../../Controller/disponibilitecontrolle.php';
$guideC = new DisponibilitesGuidesController();
$guideC->deleteDisponibility($_GET["id"]);
header('Location:disponibilitelist.php')