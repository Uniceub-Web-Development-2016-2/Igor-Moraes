<?php
include('request.php');

$method = $_SERVER['REQUEST_METHOD'];
$protocol = $_SERVER['SERVER_PROTOCOL'];
$server = $_SERVER['SERVER_NAME'];
$remote_ip = $_SERVER['REMOTE_ADDR'];
$resource = $_SERVER["REQUEST_URI"];
$params = $_SERVER['QUERY_STRING'];

$request = new Request($method, $protocol, $server, $remote_ip, $resource, $params);

echo "<pre>";
var_dump($request);
echo "</pre>";
