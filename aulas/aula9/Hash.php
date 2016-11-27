<?php

class Crypt
{
	public function generateHash($string)
	{
		$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
		return crypt($string, $salt);
	}

	public function verify($userInput, $serverOutPut)
	{
		return crypt($userInput, $serverOutPut) == $serverOutPut;
	}
}

$user = '123456';
$bd = (new Crypt())->generateHash("123456");

if ((new Crypt())->verify($user, $bd)) {
	echo "Logou";
} else {
	echo "Não logou";
}