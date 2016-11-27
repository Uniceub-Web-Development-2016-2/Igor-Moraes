<?php

/**
 * Class ResourceController
 */
class ResourceController
{
	private $METHODMAP = ['POST' => 'create', 'GET' => 'read', 'PUT' => 'update', 'DELETE' => 'delete'];

	/** @var SingleResource */
	private $resource;

	/**
	 * Calling a function by string, according to which METHODMAP's array key
	 * @param Request $request
	 * @return mixed|null = a json if the request is successful, treated PHP error otherwise.
	 */
	public function treatRequest($request)
	{
		$method = $this->METHODMAP[$request->getMethod()];
		return $this->isValidRequest($request, $method) ? $this->{$method}($request)
			: Erro("<b>Error:</b> This resource is not available or you do not have permission to access it", 403);
	}

	/**
	 * ****************************************
	 * *********** PRIVATE METHODS ************
	 * ****************************************
	 */

	/**
	 * Checks if the request is valid by checking if the method and columns are available
	 * @param Request $request
	 * @param string $method
	 *
	 * @return bool = true if the request is valid, false otherwise
	 */
	private function isValidRequest($request, $method)
	{
		$this->treatResource($request->getResource());

		return ($this->validateParameters($request->getParams()) && !empty($this->resource)) ?
			in_array($method, $this->resource->getPrivileges()) : false;
	}

	/**
	 * Sets resource properties to attribute according to getResourceInfo's return.
	 * @param string $resourceName = the table name without prefix
	 */
	private function treatResource($resourceName)
	{
		$resourceInfo = $this->getResourceInfo($resourceName);
		if (!is_null($resourceInfo)) {
			$this->resource = new SingleResource($resourceInfo['id'], $resourceInfo['table'],
				$resourceInfo['privileges'],
				$resourceInfo['columns']);
		}
	}

	/**
	 * Executes a database consult and retrives an array with resource information (id, state, privileges, columns)
	 * @param string $resourceName
	 *
	 * @return array|null = an array if resource exists and is not empty, null otherwise
	 */
	private function getResourceInfo($resourceName)
	{
		$read = new Read();
		$read->exeRead(PREFIX . "restful_resources", "*", " WHERE `table` = :table AND `state` = :state LIMIT :limit",
			"table=" . PREFIX . $resourceName . "&state=1&limit=1");
		return !empty($read->getResult()) ? $read->getResult()[0] : null;
	}

	/**
	 * Checks if parameters sent by URL are all available
	 * @param array $params = array of parameters from Request [usually received by $request->getParams()]
	 *
	 * @return bool = true if all parameters are available, false otherwise
	 */
	private function validateParameters($params)
	{
		return (!empty($params)) ? !empty(array_intersect(array_keys($params),
			$this->resource->getColumns(true))) : true;
	}

	/**
	 * Execute an Insert in Database from body request
	 * @param Request $request
	 */
	private function create($request)
	{
		$create = new Create();
		$create->exeCreate($this->resource->getTable(), $request->getBody());
		return $create->getResult();
	}

	/**
	 * Create SQL query SELECT
	 * @param Request $request
	 * @return string
	 */
	private function read($request)
	{
//		$this->isAvailableColumns($this->resource->getColumns());
		$read = new Read();
		$read->exeRead($this->resource->getTable(), $this->resource->getColumns(),
			$read->getConditions($request->getParams()), $request->getParams());
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

		$update->exeUpdate($this->resource->getTable(), $body, "{$term} = :{$term}", $criteria);

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
		$delete->exeDelete($this->resource->getTable(), $delete->getConditions($request->getBody()),
			$request->getBody(true));

		return $delete->getResult();
	}
}
