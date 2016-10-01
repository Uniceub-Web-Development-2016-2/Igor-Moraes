<?php
include('RequestController.php');
$controller = new RequestController();

echo "<pre>";
echo json_encode($controller->execute(), JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
echo "</pre>";
