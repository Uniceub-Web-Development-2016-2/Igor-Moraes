<?php

/**
 * <b>Delete.class:</b>
 * Class responsible for general deletes in the database.
 */
class Delete extends DBConnector
{
	/** @var string = Table name to delete values */
	private $table;

	/** @var string = WHERE column = :link AND.. OR.. */
	private $conditions;

	/** @var array = array of places to be inserted in query (key = value) */
	private $places;

	/** @var boolean = query result */
	private $result;

	/** @var PDOStatement */
	private $delete;

	/** @var PDO */
	private $connection;

	/**
	 * <b>Execute Delete:</b> Executes a simplified delete with Prepared Statements.
	 * Simply enter the table name, the conditions and an analysis chain (parseString) to execute.
	 * @param string $table = Table name
	 * @param string $conditions = WHERE column = :link AND.. OR..
	 * @param null|string $params = link={$link}&link2={$link2}
	 */
	public function exeDelete($table, $conditions, $params)
	{
		$this->table = $table;
		$this->conditions = $conditions;
		$this->setPlaces($params);

	}

	/**
	 * <b>Modify Links:</b> Method can be used to update with Stored Procedures. Modifying only condition's values.
	 * You can use this method to edit multiple lines.
	 * @param null|array $params = 'id' => '5'
	 */
	public function setPlaces($parseString)
	{
		(is_array($parseString)) ? $this->places = $parseString : parse_str($parseString, $this->places);
		$this->getSyntax();
		$this->execute();
	}

	/**
	 * Create query syntax to Prepared Statements
	 */
	private function getSyntax()
	{
		$this->delete = "DELETE FROM {$this->table} {$this->conditions}";
	}

	/**
	 * Get connection and syntax and executes query
	 */
	private function execute()
	{
		$this->connect();
		try {
			$this->delete->execute($this->places);
			$this->result = true;
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Erro ao Deletar:</b> {$e->getMessage()}", $e->getCode());
		}
	}

	/**
	 * Get PDO and prepare query
	 */
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->delete = $this->connection->prepare($this->delete);
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * <b>Get result:</b> Retrieves TRUE if no errors occur, or false otherwise.
	 * Even without changing the data, if a query was successful the return is TRUE.
	 * To verify changes, executes getRowCount().
	 * @return bool $var = true or false
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * <b>Count records:</b> Retrieves number of rows deleted in database
	 * @return integer $var = Quantity of rows deleted
	 */
	public function getRowCount()
	{
		return $this->delete->rowCount();
	}

	/**
	 * Retrieves string of prepared statement
	 * @param array $body
	 * @return string = example WHERE name1 = :name1 AND name2 >= :name2
	 */
	public function getConditions($body)
	{
		$link = "WHERE ";
		foreach ($body as $key => $value) {
			if (!in_array($key, unserialize(SORTMAP))) {
				$link .= $key . ' = :' . $key . ' AND ';
			}
		}
		return substr($link, 0, -5);
	}

}
