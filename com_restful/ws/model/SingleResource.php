<?php

/**
 * Class Resource
 */
class SingleResource
{
	/** @var integer = Resource ID */
	private $id;

	/** @var string = Table with prefix that this resource represents */
	private $table;

	/** @var $string = The privileges that this resource (table) will have for those who access the webservice. */
	private $privileges;

	/** @var string = The columns that appear in JSON, for those who access the webservice. */
	private $columns;

	/**
	 * SingleResource constructor.
	 * @param int $id
	 * @param string $table
	 * @param string $privileges
	 * @param string $columns
	 */
	public function __construct($id, $table, $privileges, $columns)
	{
		$this->id = $id;
		$this->table = $table;
		$this->setPrivileges($privileges);
		$this->setColumns($columns);
	}

	/**
	 * @param mixed $privileges = The privileges that this resource (table) will have for those who access the webservice.
	 */
	private function setPrivileges($privileges)
	{
		$this->privileges = is_array($privileges) ? $privileges : explode(",", $privileges);
	}

	/**
	 * @param string $columns = The columns that appear in JSON, for those who access the webservice.
	 */
	private function setColumns($columns)
	{
		$this->columns = $columns;
	}

	/**
	 * @return int = Resource ID
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string = Table with prefix that this resource represents.
	 */
	public function getTable()
	{
		return $this->table;
	}

	/**
	 * @return mixed = The privileges that this resource (table) will have for those who access the webservice.
	 */
	public function getPrivileges()
	{
		return $this->privileges;
	}

	/**
	 * @return string = The columns that appear in JSON, for those who access the webservice
	 */
	public function getColumns($assoc = false)
	{
		return ($assoc == true) ? explode(",", $this->columns) : $this->columns;
	}

}