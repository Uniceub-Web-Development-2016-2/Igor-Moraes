<?php
include('RequestController.php');
$controller = new RequestController();

echo json_encode($controller->execute());
