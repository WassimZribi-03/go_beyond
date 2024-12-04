<?php
include '../../../controller/eventcontroller.php';
$eventC = new eventController();
$eventC->deleteevent($_GET["id"]);
header('Location:listeevent.php');
