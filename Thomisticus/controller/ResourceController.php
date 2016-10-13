<?php

/**
 * Class ResourceController
 */
class ResourceController
{
	private $METHODMAP = ['GET' => 'search', 'POST' => 'create', 'PUT' => 'update', 'DELETE' => 'remove'];

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function treatRequest($request)
	{
		// Calling a function by string, according to which METHODMAP's array key
		return $this->{$this->METHODMAP[$request->getMethod()]}($request);
	}

	/**
	 * Create SQL query SELECT
	 * @param Request $request
	 * @return string
	 */
	public function search($request)
	{
		$read = new Read();
		$termos = !empty($request->getParams()) ? self::getTermos($request->getParams()) : ' WHERE 1';
		$read->exeRead($request->getPath(), $termos, $request->getParams());

		return $read->getResult();
	}

	/**
	 * Retrieves string of prepared statement
	 * @param array $params
	 * @return string = example WHERE name1 = :name1 AND name2 >= :name2
	 */
	private function getTermos($params)
	{
		$vinculos = "WHERE ";
		foreach ($params as $key => $value) {
			$vinculos .= $key . ' = ' . ':' . $key . ' AND ';
		}

		return substr($vinculos, 0, -5);
	}

	/**
	 * Separate parameters from queryString
	 * @param array $params = Query String ($_SERVER['QUERY_STRING'])
	 * @return string = conditions to SQL query (key = value)
	 */
	public function queryParams($params)
	{
		$query = '';
		foreach ($params as $key => $value) {
			$query .= $key . ' = ' . '"' . $value . '"' . ' AND ';
		}
		return substr($query, 0, -5);
	}

}
