<!DOCTYPE html>
<!--suppress HtmlUnknownTarget -->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Teste JSON</title>
		<link href="../treater/css/reset.css" type="text/css" rel="stylesheet"/>
	</head>
	<body>
		<?php
		try {
			require('Config.inc.php');
			$controller = new RequestController();

			echo "<pre>";
			echo json_encode($controller->execute(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			echo "</pre>";

		} catch (Exception $e) {
			PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
			Erro($e->getMessage(), $e->getCode());
		}
		?>
	</body>
</html>

