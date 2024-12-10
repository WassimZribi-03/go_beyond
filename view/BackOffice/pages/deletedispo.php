<?php
include '../../../Controller/disponibilitecontroller.php';
$guideC = new DisponibilitesGuidesController();
$guideC->deleteDisponibility($_GET["id"]);
header('Location:disponibilitelist.php');