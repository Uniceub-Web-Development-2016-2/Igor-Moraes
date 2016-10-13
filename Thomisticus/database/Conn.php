<?php

/**
 * Class Conn [CONEXÃO]
 * Classe abstrata de conexão (para ser herdada pelas classes de crud)
 * Padrão SingleTon (previne que temos apenas uma instância do objeto sendo executada)
 * Retorna um objeto PDO pelo método estático getConn();
 */
abstract class Conn
{

	private static $host = HOST;
	private static $port = PORT;
	private static $user = USER;
	private static $pass = PASS;
	private static $db = DB;

	/**
	 * @var PDO|null
	 */
	private static $conn = null;

	/**
	 * @return PDO = um objeto PDO Singleton Pattern.
	 */
	protected static function getConn()
	{
		return self::Conectar();
	}

	/**
	 * Conecta com o banco de dados com o pattern singleton.
	 * @return PDO = um objeto PDO!
	 */
	private static function Conectar()
	{
		try {
			if (self::$conn == null):
				$dsn = 'mysql:host=' . self::$host . ';port=' . self::$port . ';dbname=' . self::$db;
				// Indice de configuração para o banco de dados trabalhar com UTF8
				$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
				self::$conn = new PDO($dsn, self::$user, self::$pass, $options);
			endif;
		} catch (PDOException $e) {
			PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
			die;
		}

		// Tipo de erros que o PDO irá trabalhar, no caso, o lançamento de exceções.
		self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return self::$conn;
	}

}
