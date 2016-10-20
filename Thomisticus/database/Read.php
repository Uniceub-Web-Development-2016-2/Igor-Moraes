<?php

/**
 * <b>Read.class:</b>
 * Class responsible for general readings in the database.
 */
class Read extends DBConnector
{

	/** @var string = string SELECT query */
	private $select;

	/** @var array = array of places to be inserted in query (key = value) */
	private $places;

	/** @var array = query result */
	private $result;

	/** @var PDOStatement */
	private $read;

	/** @var PDO */
	private $connection;

	/**
	 * <b>Execute Read:</b> Executa uma leitura simplificada com Prepared Statements. Basta informar o nome da tabela,
	 * os termos da seleção e uma análise em cadeia (ParseString) para executar.
	 * @param string $tabela = Nome da tabela
	 * @param string $termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
	 * @param string $params = link={$link}&link2={$link2}
	 */
	public function exeRead($tabela, $termos = null, $params = null)
	{
		if (!empty($params)) {
			$this->setPlaces($params);
		}
		$this->select = "SELECT * FROM {$tabela} {$termos}";
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
		return $this->read->rowCount();
	}

	/**
	 * @param string $queryString
	 */
	public function setPlaces($queryString)
	{
		if (!empty($queryString['sort'])) {
			unset($queryString['sort']);
		}
		$this->places = $queryString;
	}


	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * Get the PDO and prepare query
	 */
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->read = $this->connection->prepare($this->select);
		$this->read->setFetchMode(PDO::FETCH_ASSOC);
	}

	/**
	 * Get connection and syntax and execute query
	 */
	private function execute()
	{
		$this->connect();
		try {
			$this->getSyntax();
			$this->read->execute();
			$this->result = $this->read->fetchAll();
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Error reading:</b> {$e->getMessage()}", $e->getCode());
		}
	}

	/**
	 * Create query syntax to the Prepared Statements
	 */
	private function getSyntax()
	{
		if ($this->places) {
			foreach ($this->places as $vinculo => $valor) {
				if (in_array($vinculo, unserialize(SORTMAP)) && $vinculo != 'sort') {
					$valor = intval($valor);
				}
				$this->read->bindValue(":{$vinculo}", $valor, (is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
			}
		}
	}

}
