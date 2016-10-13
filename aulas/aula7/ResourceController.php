<?php
include_once('Request.php');
include_once('DBConnector.php');

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
	private function search($request)
	{
		$query = 'SELECT * FROM ' . $request->getPath() . ' WHERE ' . self::queryParams($request->getParams());
		$conn = (new DBConnector())->query($query);
		$result = $conn->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	/**
	 * Separate parameters from queryString
	 * @param array $params = Query String ($_SERVER['QUERY_STRING'])
	 * @return string = conditions to SQL query (key = value)
	 */
	private function queryParams($params)
	{
		$query = '';
		foreach ($params as $key => $value) {
			$query .= $key . ' = ' . '"' . $value . '"' . ' AND ';
		}
		return substr($query, 0, -5);
	}

	/**
	 * @param Request $request
	 */
	private function create($request)
	{
		$body = $request->getBody();
		$resource = $request->getResource();
		$query = 'INSERT INTO ' . $resource . ' (' . $this->getColumns($body) . ') VALUES (' . $this->getValues($body) . ')';

		var_dump($query);
	}

	private function getColumns($json)
	{
		$array = json_decode($json, true);
		return implode(",", array_keys($array));
	}

	private function getValues($json)
	{
		$array = json_decode($json, true);
		return "'" . implode("','", array_values($array)) . "'";
	}

	/**
	 * @param Request $request
	 */
	private function update($request)
	{
		$body = $request->getBody();
		$resource = $request->getResource();
		$query = 'UPDATE ' . $resource . ' SET ' . $this->getUpdateCriteria($body);

		var_dump($query);
	}

	private function getUpdateCriteria($json)
	{
		$criteria = "";
		$where = " WHERE ";
		$array = json_decode($json, true);
		foreach ($array as $key => $value) {
			if ($key != 'id') {
				$criteria .= $key . "='" . $value . "',";
			}
		}
		return substr($criteria, 0, -1) . $where . "id=" . $array['id'];
	}

}
