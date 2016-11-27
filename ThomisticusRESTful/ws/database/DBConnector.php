<?php

/**
 * Class DBConnector [CONEXÃO]
 * Abstract connection class (to be inherited by crud classes)
 * SingleTon Pattern (ensures that only one instance of this object is being executed)
 * Retrieves a PDO object through the static method getConnection();
 */
abstract class DBConnector
{

	private static $host = HOST;
	private static $user = USER;
	private static $pass = PASS;
	private static $db = DB;

	/**
	 * @var PDO|null
	 */
	private static $connection = null;

	/**
	 * @return PDO = a PDO Singleton Pattern object.
	 */
	protected static function getConnection()
	{
		return self::singleConnection();
	}

	/**
	 * Connects to the database using SingleTon Pattern
	 * @return PDO = a PDO object.
	 */
	private static function singleConnection()
	{
		try {
			if (self::$connection == null):
				$dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$db;
				// Configuration index to database works with UTF8
				$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
				self::$connection = new PDO($dsn, self::$user, self::$pass, $options);
			endif;
		} catch (PDOException $e) {
			PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
		}

		// Type of erros that PDO will work, in case, sending exceptions
		self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return self::$connection;
	}

}
