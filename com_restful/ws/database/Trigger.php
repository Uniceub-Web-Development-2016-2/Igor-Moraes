<?php
include_once('DBConnector.php');

class Trigger extends DBConnector
{
	/** @var string = Table name to create trigger */
	private $table;

	private $triggerName;

	private $method;

	/** @var boolean = query result */
	private $result;

	/** @var PDOStatement */
	private $trigger;

	/** @var PDO To get the PDO Connection */
	private $connection;


	public function createTrigger($table, $triggerName, $method)
	{
		$this->table = $table;
		$this->triggerName = $triggerName;
		$this->method = $method;
		$this->getSyntax();
		$this->execute();
	}

	private function getSyntax()
	{
		$element = $this->method != 'DELETE' ? "NEW.id" : "OLD.id";
		$this->trigger = "CREATE TRIGGER {$this->triggerName} AFTER {$this->method} ON {$this->table}
			FOR EACH ROW INSERT INTO " . PREFIX . "restful_extsender_logs (resource, id_resource_element, change_time, method, request_sent)
			VALUES ('{$this->table}', {$element}, NOW(), '{$this->method}', 0)";
	}

	/**
	 * Get connection and syntax and executes query
	 */
	private function execute()
	{
		$this->connect();
		try {
			$this->trigger->execute();
			$this->result = true;
		} catch (PDOException $e) {
			$this->result = null;
			Erro("<b>Erro ao criar a Trigger:</b> {$e->getMessage()}", $e->getCode());
		}
	}

	/**
	 * Get PDO and prepare query
	 */
	private function connect()
	{
		$this->connection = parent::getConnection();
		$this->trigger = $this->connection->prepare($this->trigger);
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	public function dropTrigger($triggerName)
	{
		$this->trigger = "DROP TRIGGER IF EXISTS {$triggerName}";
		$this->execute();
	}

	public function generateName($method, $table)
	{
		return "on{$method}{$table}";
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
}