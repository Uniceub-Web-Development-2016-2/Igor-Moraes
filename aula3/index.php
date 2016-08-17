<?php
include('request.php');

var_dump($_SERVER); die;

$method = $_SERVER['REQUEST_METHOD'];
$protocol = $_SERVER['SERVER_PROTOCOL'];
$server = $_SERVER['SERVER_NAME'];
$remote_ip = $_SERVER['REMOTE_ADDR'];
$resource = substr(substr($_SERVER['SCRIPT_NAME'], 0, -10), 16);
$params = $_SERVER['QUERY_STRING'];

$request = new Request($method, $protocol, $server, $remote_ip, $resource, $params);

echo "<pre>";
var_dump($request);
echo "</pre>";
