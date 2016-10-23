<?php

/**
 * Class ResourceController
 */
class ResourceController
{
	private $METHODMAP = ['GET' => 'read', 'POST' => 'create', 'PUT' => 'update', 'DELETE' => 'remove'];

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
	 * Create SQL query SELECT
	 * @param Request $request
	 * @return string
	 */
	private function read($request)
	{
		$read = new Read();
		$read->exeRead($request->getResource(), $read->getTerms($request->getParams()), $request->getParams());
		return $read->getResult();
	}

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
	 * Execute an Update in Database
	 * The primary key must be the first element in array, to be used as query criteria
	 * @param Request $request
	 */
	private function update($request)
	{
		$update = new Update();
		$term = key($request->getBody());
		$criteria = http_build_query(array_slice($request->getBody(), 0, 1));
		$update->exeUpdate($request->getResource(), $request->getBody(), "{$term} = :{$term}", $criteria);
		return $update->getResult();
	}
}
