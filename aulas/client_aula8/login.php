<?php
session_start();

include_once('httpful.phar');

$url = 'http://localhost:8888/Igor-Moraes/aulas/aula8/user/login';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
	$loginArray = array('email' => $_POST['email'], 'password' => $_POST['password']);
	$body = json_encode($loginArray);

	$response = \Httpful\Request::post($url)->sendsJson()->body($body)->send();

	$array = json_decode($response->body, true)[0];

	if (!empty($array) && $_POST['email'] == $array['email'] && $_POST['password'] == $array['password']) {
		$_SESSION['email'] = $array['email'];
		$_SESSION['name'] = $array['first_name'] . ' ' . $array['last_name'];
		$_SESSION['cebola'] = 'tomate seco';
		header("Location: perfil.php");
	}
}

?>
