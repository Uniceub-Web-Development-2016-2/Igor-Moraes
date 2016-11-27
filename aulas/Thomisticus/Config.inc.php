<?php

/**
 * ****************************************
 * ******** CONFIGURAÇÕES DO SITE *********
 * ****************************************
 */
define('HOST', 'localhost');
define('PORT', '8889');
define('USER', 'root');
define('PASS', 'root');
define('DB', 'thomisticus');
define('INTEGRATION', 'true');
define('SORTMAP', serialize(array('sort', 'limit', 'offset')));


/**
 * Auto Load de classes
 * @param $Class
 */
function __autoload($Class)
{
	// Inserindo a pasta
	$cDir = ['database', 'model', 'controller'];
	// Verificar se a inclusão ocorreu
	$iDir = null;

	foreach ($cDir as $dirName) {
		// Verifica primeiro se o diretório não foi incluído, depois se existe a classe e se não é um diretório
		if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . "{$Class}.php") && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . "{$Class}.php")) {
			include_once(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . "{$Class}.php");
			$iDir = true;
		}
	}

	// Quando não conseguiu inserir o arquivo
	if (!$iDir) {
		trigger_error("Não foi possível incluir {$Class}.php", E_USER_ERROR);
		die;
	}
}

/**
 * ****************************************
 * ********* TRATAMENTO DE ERROS **********
 * ****************************************
 */

//CSS constantes :: Mensagens de Erro
define('CSS_ACCEPT', 'accept');
define('CSS_INFORMATION', 'information');
define('CSS_ALERT', 'alert');
define('CSS_ERROR', 'error');

/**
 * Exibe os erros lançados :: Front
 * @param $errMsg
 * @param $errNo
 * @param null $errDie
 */
function Erro($errMsg, $errNo, $errDie = null)
{
	$cssClass = ($errNo == E_USER_NOTICE ? CSS_INFORMATION : ($errNo == E_USER_WARNING ? CSS_ALERT : ($errNo == E_USER_ERROR ? CSS_ERROR : $errNo)));
	echo "<p class=\"trigger {$cssClass}\">{$errMsg}<span class=\"ajax_close\"></span></p>";

	if ($errDie) {
		die;
	}
}

/**
 * Personaliza o gatilho de erro do PHP
 * @param $errNo
 * @param $errMsg
 * @param $errFile
 * @param $errLine
 */
function PHPErro($errNo, $errMsg, $errFile, $errLine)
{
	$cssClass = ($errNo == E_USER_NOTICE ? CSS_INFORMATION : ($errNo == E_USER_WARNING ? CSS_ALERT : ($errNo == E_USER_ERROR ? CSS_ERROR : $errNo)));
	echo "<p class=\"trigger {$cssClass}\">";
	echo "<b>Erro na Linha: #{$errLine} ::</b> {$errMsg}<br>";
	echo "<small>{$errFile}</small>";
	echo "<span class=\"ajax_close\"></span></p>";

	if ($errNo == E_USER_ERROR) {
		die;
	}
}

set_error_handler('PHPErro');
