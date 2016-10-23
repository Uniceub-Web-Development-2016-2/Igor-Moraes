<?php

/**
 * <b>Update.class:</b>
 * Classe responsável por atualizações genéticas no banco de dados!
 *
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Update extends DBConnector
{
	private $tabela;
	private $dados;
	private $termos;
	private $places;
	private $result;

	/** @var PDOStatement */
	private $update;

	/** @var PDO */
	private $connection;

	/**
	 * <b>Exe Update:</b> Executa uma atualização simplificada com Prepared Statements. Basta informar o
	 * nome da tabela, os dados a serem atualizados em um Array Atribuitivo, as condições e uma
	 * analise em cadeia (ParseString) para executar.
	 * @param string $tabela = Nome da tabela
	 * @param array $dados = [ NomeDaColuna ] => Valor ( Atribuição )
	 * @param string $termos = WHERE coluna = :link AND.. OR..
	 * @param null|string $params = link={$link}&link2={$link2}
	 */
	public function exeUpdate($tabela, array $dados, $termos, $params = null)
	{
		$this->tabela = $tabela;
		$this->dados = $dados;
		$this->termos = $termos;
		$this->setPlaces($params);
	}

	/**
	 * <b>Obter resultado:</b> Retorna TRUE se não ocorrer erros, ou FALSE. Mesmo não alterando os dados se uma query
	 * for executada com sucesso o retorno será TRUE. Para verificar alterações execute o getRowCount();
	 * @return BOOL $Var = True ou False
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * <b>Contar Registros: </b> Retorna o número de linhas alteradas no banco!
	 * @return INT $Var = Quantidade de linhas alteradas
	 */
	public function getRowCount()
	{
		return $this->update->rowCount();
	}

	/**
	 * <b>Modificar Links:</b> Método pode ser usado para atualizar com Stored Procedures. Modificando apenas os valores
	 * da condição. Use este método para editar múltiplas linhas!
	 * @param array $params = 'id' => '5'
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

	//Obtém o PDO e Prepara a query
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->update = $this->connection->prepare($this->update);
	}

	//Cria a sintaxe da query para Prepared Statements
	private function getSyntax()
	{
		$places = array();
		foreach ($this->dados as $key => $value) {
			$places[] = $key . ' = :' . $key;
		}

		$places = implode(', ', $places);
		$this->update = "UPDATE {$this->tabela} SET {$places} WHERE {$this->termos}";
	}

	//Obtém a Conexão e a Syntax, executa a query!
	private function execute()
	{
		$this->connect();
		try {
			$this->update->execute(array_merge($this->dados, $this->places));
			$this->result = true;
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Erro ao Ler:</b> {$e->getMessage()}", $e->getCode());
		}
	}

}
