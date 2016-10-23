<?php

/**
 * <b>Update.class:</b>
 * Class responsible for general updates in the database.
 */
class Update extends DBConnector
{
	/** @var string = Table name to update values */
	private $table;

	/** @var array = array of places to be inserted in query (key = value) */
	private $data;

	/** @var string = WHERE column = :link AND.. OR.. */
	private $terms;

	/** @var array = array of places to be inserted in query (key = value) */
	private $places;

	/** @var boolean = query result */
	private $result;

	/** @var PDOStatement */
	private $update;

	/** @var PDO To get the PDO Connection */
	private $connection;

	/**
	 * <b>Execute Update:</b> Executes a simplified update with Prepared Statements.
	 * Simply enter the table name, data to be update in a attributive array, the conditions and an analysis chain (parseString) to execute.
	 * @param string $table = Table name
	 * @param array $data = [ columnName ] => Value ( Attribution )
	 * @param string $terms = WHERE column = :link AND.. OR..
	 * @param null|string $params = link={$link}&link2={$link2}
	 */
	public function exeUpdate($table, array $data, $terms, $params = null)
	{
		$this->table = $table;
		$this->data = $data;
		$this->terms = $terms;
		$this->setPlaces($params);
	}

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
	 * <b>Count records:</b> Retrieves number of rows updated in database
	 * @return integer $var = Quantity of rows updated
	 */
	public function getRowCount()
	{
		return $this->update->rowCount();
	}

	/**
	 * <b>Modify Links:</b> Method can be used to update with Stored Procedures. Modifying only condition's values
	 * You can use this method to edit multiple lines.
	 * @param null|array $params = 'id' => '5'
	 */
	public function setPlaces($params)
	{
		(is_array($params)) ? $this->places = $params : parse_str($params, $this->places);
		$this->getSyntax();
		$this->execute();
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * Get PDO and prepare query
	 */
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->update = $this->connection->prepare($this->update);
	}

	/**
	 * Create query syntax to Prepared Statements
	 */
	private function getSyntax()
	{
		$places = array();
		foreach ($this->data as $key => $value) {
			$places[] = $key . ' = :' . $key;
		}

		$places = implode(', ', $places);
		$this->update = "UPDATE {$this->table} SET {$places} WHERE {$this->terms}";
	}

	/**
	 * Get connection and syntax and executes query
	 */
	private function execute()
	{
		$this->connect();
		try {
			$this->update->execute(array_merge($this->data, $this->places));
			$this->result = true;
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Erro ao Ler:</b> {$e->getMessage()}", $e->getCode());
		}
	}

}
