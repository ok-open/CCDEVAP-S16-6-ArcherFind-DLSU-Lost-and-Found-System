LocationController.php

<?php

require_once "../../db.php";
require_once "../../models/Location.php";

$locationModel = new Location($conn);

$buildings = $locationModel->getBuildings();
$rooms = $locationModel->getRooms();
$areas = $locationModel->getAreas();

?>