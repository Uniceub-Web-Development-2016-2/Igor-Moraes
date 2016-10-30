<?php

/**
 * <b>Read.class:</b>
 * Class responsible for general readings in the database.
 */
class Read extends DBConnector
{
	/** @var PDOStatement = responsible for query prepared of PDO */
	private $select;

	/** @var array = array of places to be inserted in query (key = value) */
	private $places;

	/** @var array = query result */
	private $result;

	/** @var PDO To get the PDO Connection */
	private $connection;

	/**
	 * <b>Execute Read:</b> Executa uma leitura simplificada com Prepared Statements.
	 * Simply enter the table name, terms of selection and an analysis chain (parseString) to execute.
	 * @param string $table = Table name
	 * @param string $terms = WHERE | ORDER | LIMIT :limit | OFFSET :offset
	 * @param string $params = link={$link}&link2={$link2}
	 */
	public function exeRead($table, $terms = null, $params = null)
	{
		if (!empty($params)) {
			$this->setPlaces($params);
		}
		$this->select = "SELECT * FROM {$table} {$terms}";
		$this->execute();
	}

	/**
	 * Method to pass the query manually and be able to work with inners and joins
	 * @param string $query = full query
	 * @param string|null $queryString
	 */
	public function fullRead($query, $queryString = null)
	{
		$this->select = (string)$query;
		if (!empty($queryString)) {
			$this->places = $queryString;
		}
		$this->execute();
	}

	/**
	 * Retrieves string of prepared statement
	 * @param array $params
	 * @return string = example WHERE name1 = :name1 AND name2 >= :name2
	 */
	public function getConditions($params)
	{
		$vinculos = "WHERE ";
		foreach ($params as $key => $value) {
			if (!in_array($key, unserialize(SORTMAP))) {
				$vinculos .= $key . ' = :' . $key . '  AND ';
			}
		}
		return substr($vinculos, 0, -6) . self::getQuerySort($params);
	}

	/**
	 * @param array $params
	 * @return string = example
	 */
	private function getQuerySort($params)
	{
		$querySort = "";
		foreach ($params as $key => $value) {
			if (in_array($key, unserialize(SORTMAP))) {
				$querySort .= ($key == 'sort') ? " ORDER BY {$value}" : " " . strtoupper($key) . " :{$key} ";
			}
		}
		return $querySort;
	}

	/**
	 * <b>Get result:</b> Retrieves an array of all results obtained. Numeric primary envelope.
	 * To get a result, call the index getResult()[0]
	 * @return array $this = Array ResultSet
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * <b>Count records:</b> Retrieves the number of records found by select query
	 * @return integer $var = Amount of records found
	 */
	public function getRowCount()
	{
		return $this->select->rowCount();
	}

	/**
	 * @param string $params
	 */
	public function setPlaces($params)
	{
		(is_array($params)) ? $this->places = $params : parse_str($params, $this->places);
		$this->checkSort($params);
	}


	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * If sort criteria is setted, it'll unset this element of array to don't be binded in Prepared Statement
	 * @param string $params
	 */
	private function checkSort($params)
	{
		if (!empty($params['sort'])) {
			unset($params['sort']);
			$this->places = $params;
		}
	}

	/**
	 * Get PDO and prepare query
	 */
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->select = $this->connection->prepare($this->select);
		$this->select->setFetchMode(PDO::FETCH_ASSOC);
	}

	/**
	 * Create query syntax to Prepared Statements
	 */
	private function getSyntax()
	{
		if ($this->places) {
			foreach ($this->places as $vinculo => $valor) {
				if (in_array($vinculo, unserialize(SORTMAP)) && $vinculo != 'sort') {
					$valor = intval($valor);
				}
				$this->select->bindValue(":{$vinculo}", $valor, (is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
			}
		}
	}

	/**
	 * Get connection and syntax and executes query
	 */
	private function execute()
	{
		$this->connect();
		try {
			$this->getSyntax();
			$this->select->execute();
			$this->result = $this->select->fetchAll();
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Error reading:</b> {$e->getMessage()}", $e->getCode());
		}
	}

}
