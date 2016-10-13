<?php

/**
 * <b>Read.class:</b>
 * Classe responsável por leituras genéricas no banco de dados.
 */
class Read extends Conn
{

	private $select;
	private $places;
	private $result;

	/** @var PDOStatement */
	private $read;

	/** @var PDO */
	private $conn;

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
//			parse_str($queryString, $this->places);
			$this->places = $params;
		}

		$this->select = "SELECT * FROM {$tabela} {$termos}";
		$this->execute();
	}

	/**
	 * <b>Obter resultado:</b> Retorna um array com todos os resultados obtidos. Envelope primário numérico. Para obter
	 * um resultado chame o índice getResult()[0]!
	 * @return array $this = Array ResultSet
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * <b>Contar Registros:</b> Retorna o número de registros encontrados pelo select
	 * @return integer $var = Quantidade de registros encontrados
	 */
	public function getRowCount()
	{
		return $this->read->rowCount();
	}

	/**
	 * Método para passar a query manualmente e poder trabalhar com inners e joins
	 * @param string $query
	 * @param string|null $queryString
	 */
	public function fullRead($query, $queryString = null)
	{
		$this->select = (string)$query;
		if (!empty($queryString)) {
//			parse_str($queryString, $this->places);
			$this->places = $queryString;
		}
		$this->execute();
	}

	/**
	 * <b>Full Read:</b> Executa leitura de dados via query que deve ser montada manualmente para possibilitar
	 * seleção de multiplas tabelas em uma única query
	 * @param string $queryString = query Select Syntax --> ex: link={$link}&link2={$link2}
	 */
	public function setPlaces($queryString)
	{
		parse_str($queryString, $this->places);
		$this->execute();
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * Obtém o PDO e prepara a query
	 */
	private function connect()
	{
		$this->conn = parent::getConn();
		$this->read = $this->conn->prepare($this->select);
		$this->read->setFetchMode(PDO::FETCH_ASSOC);
	}

	/**
	 * Obtém a conexão e a syntax e executa a query.
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
			Erro("<b>Erro ao Ler:</b> {$e->getMessage()}", $e->getCode());
		}
	}

	/**
	 * Cria a sintaxe da query para Prepared Statements
	 */
	private function getSyntax()
	{
		if ($this->places) {
			foreach ($this->places as $vinculo => $valor) {
				if ($vinculo == 'limit' || $vinculo == 'offset') {
					$valor = intval($valor);
				}
				$this->read->bindValue(":{$vinculo}", $valor, (is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
			}
		}
	}

}
