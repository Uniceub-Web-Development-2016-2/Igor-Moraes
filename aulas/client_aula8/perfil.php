<?php
session_start();
?>

<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
		      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Perfil</title>
	</head>
	<body>
		<h3>Seja bem vindo, <?php echo $_SESSION['name'] ?></h3>
	</body>
</html>
