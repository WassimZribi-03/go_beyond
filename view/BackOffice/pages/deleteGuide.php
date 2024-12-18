<?php
include '../../../Controller/guidecontroller.php';
$guideC = new GuideTouristiqueController();
$guideC->deleteGuide($_GET["id"]);
header('Location:guideList.php');
