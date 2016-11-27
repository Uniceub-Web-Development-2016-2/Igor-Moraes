<?php

/**
 * <b>Create.class:</b>
 * Class responsible for general registers in the database.
 */
class Create extends DBConnector
{
	/** @var string = Table name to insert values */
	private $table;

	/** @var array = array of places to be inserted in query (key = value) */
	private $data;

	/** @var array = query result */
	private $result;

	/** @var PDOStatement = responsible for query prepared of PDO */
	private $create;

	/** @var PDO Pegar a conexão da PDO */
	private $connection;

	/**
	 * <b>Execute Insert:</b> Executes a simplified registry in database using prepared statements.
	 * Simply enter the table name and an attributive array with the column name and value.
	 *
	 * @param string $table = Table name in the database
	 * @param array $data = Attributive array. ( column name => value ).
	 */
	public function exeCreate($table, $data)
	{
		$this->table = (string)$table;
		$this->data = $data;

		$this->getSyntax();
		$this->execute();
	}

	/**
	 * Create query syntax to Prepared Statements
	 */
	private function getSyntax()
	{
		$fields = implode(', ', array_keys($this->data));
		$places = ':' . implode(', :', array_keys($this->data));
		$this->create = "INSERT INTO {$this->table} ({$fields}) VALUES ({$places})";
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * Get connection and executes query
	 */
	private function execute()
	{
		$this->connect();
		try {
			$this->create->execute($this->data);
			$this->result = $this->connection->lastInsertId();
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Erro ao cadastrar:</b> {$e->getMessage()}", $e->getCode());
		}
	}

	/**
	 * Get PDO and prepare query
	 */
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->create = $this->connection->prepare($this->create);
	}

	/**
	 * <b>Get result:</b> Retrieves the ID of inserted registry or FALSE if no record has been entered
	 * @return array|integer|false $variavel = lastInsertId or false
	 */
	public function getResult()
	{
		return $this->result;
	}

}
