<?php

/**
 * Class ResourceController
 */
class ResourceController
{
	private $METHODMAP = ['POST' => 'create', 'GET' => 'read', 'PUT' => 'update', 'DELETE' => 'delete'];

	/**
	 * Calling a function by string, according to which METHODMAP's array key
	 * @param Request $request
	 * @return mixed
	 */
	public function treatRequest($request)
	{
		return $this->{$this->METHODMAP[$request->getMethod()]}($request);
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * Execute an Insert in Database from body request
	 * @param Request $request
	 */
	private function create($request)
	{
		$create = new Create();
		$create->exeCreate($request->getResource(), $request->getBody());
		return $create->getResult();
	}

	/**
	 * Create SQL query SELECT
	 * @param Request $request
	 * @return string
	 */
	private function read($request)
	{
		$read = new Read();
		$read->exeRead($request->getResource(), $read->getConditions($request->getParams()), $request->getParams());
		return $read->getResult();
	}

	/**
	 * Execute an Update in Database
	 * The primary key must be the first element in array, to be used as query criteria
	 * @param Request $request
	 */
	private function update($request)
	{
		$body = $request->getBody();
		$update = new Update();

		// The first key of array, which must be the primary key, for prepared statement. Ex: id = :id
		$term = key($body);

		//String to replacement when query is prepared by PDO. Ex: id = 5
		$criteria = "{$term} = " . reset($body);

		$update->exeUpdate($request->getResource(), $body, "{$term} = :{$term}", $criteria);

		return $update->getResult();
	}

	/**
	 * Execute an Update in Database
	 * Request body must have at least one column=value to be used as query criteria (preferably primary key at array beginning)
	 * @param Request $request
	 */
	private function delete($request)
	{
		$delete = new Delete();
		$delete->exeDelete($request->getResource(), $delete->getConditions($request->getBody()),
			$request->getBody(true));

		return $delete->getResult();
	}
}
