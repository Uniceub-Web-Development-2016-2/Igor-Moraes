<?php
include_once('request.php');

$params = array("user" => 'igorsgm', "userType" => 'admin');
$method = "POST";
$requestTest = new Request($method, "http", "cebola.com.br", "resource", $params);

echo $requestTest->toString();