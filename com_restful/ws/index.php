<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: application/json', true);

try {
	require('Config.inc.php');
	$controller = new RequestController();

	echo json_encode($controller->execute(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
	PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
	Erro($e->getMessage(), $e->getCode());
}
