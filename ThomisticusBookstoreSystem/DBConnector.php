<?php

class DBConnector extends PDO
{

	private $engine;
	private $host;
	private $database;
	private $user;
	private $pass;
	private $connector;

	public function __construct()
	{
		$this->engine = 'mysql';
		$this->host = 'localhost:8889';
		$this->database = 'thomisticus';
		$this->user = 'root';
		$this->pass = 'root';
		$dns = $this->engine . ':dbname=' . $this->database . ";host=" . $this->host;
		$this->connector = parent::__construct($dns, $this->user, $this->pass,
			[PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8']);
	}
}