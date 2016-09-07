<?php
include('RequestController.php');

$controller = new RequestController();

echo json_encode($controller->createRequest($_SERVER));
echo "<br>Está vindo null porque deu tudo certo, conforme a aula :D (olhar código)";