<?php

/**
 * Class ResourceController
 */
class ResourceController
{
	private $METHODMAP = ['GET' => 'search', 'POST' => 'create', 'PUT' => 'update', 'DELETE' => 'remove'];

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
	 * Create SQL query SELECT
	 * @param Request $request
	 * @return string
	 */
	public function search($request)
	{
		$read = new Read();
		$termos = !empty($request->getParams()) ? self::getTerms($request->getParams()) : ' WHERE 1';
		$read->exeRead($request->getPath(), $termos, $request->getParams());

		return $read->getResult();
	}

	/**
	 * Retrieves string of prepared statement
	 * @param array $params
	 * @return string = example WHERE name1 = :name1 AND name2 >= :name2
	 */
	private function getTerms($params)
	{
		$vinculos = "WHERE ";
		foreach ($params as $key => $value) {
			if (!in_array($key, unserialize(SORTMAP))) {
				$vinculos .= $key . ' = :' . $key . ' AND ';
			}
		}
		return substr($vinculos, 0, -5) . $this->getQuerySort($params);
	}

	/**
	 * @param array $params
	 * @return string = example
	 */
	private function getQuerySort($params)
	{
		$querySort = "";
		foreach ($params as $key => $value) {
			if (in_array($key, unserialize(SORTMAP))) {
				$querySort .= ($key == 'sort') ? " ORDER BY {$value}" : " " . strtoupper($key) . " :{$key} ";
			}
		}
		return $querySort;
	}
}
