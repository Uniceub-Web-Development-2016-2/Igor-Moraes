<?php
include_once('httpful.phar');

$getRequest = 'http://localhost:8888/Igor-Moraes/aulas/aula8/user/search?first_name=' . $_POST['search'];

$response = \Httpful\Request::get($getRequest)->send();

$response = \Httpful\Request::post($uri)
	->sendsJson()
	->body('{ "first_name": "Igor", "last_name": "Moraes", "email": "igor.sgm@gmail.com", "password": "12345678", "gender": "masculino", "birthdate": "2016-05-02" }')
	->send();

echo "A resposta do GET foi: " . $response->body;
