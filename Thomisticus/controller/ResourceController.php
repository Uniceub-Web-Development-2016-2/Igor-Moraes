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
	 * @param Request $request
	 */
	private function create($request)
	{
		$create = new Create();
		$create->exeCreate($request->getResource(), $request->getBody());
		return $create->getResult();
	}
}
