<?php

/**
 * Class RequestController
 */
class RequestController
{
	const VALID_METHODS = array('GET', 'POST', 'PUT', 'DELETE');
	const VALID_PROTOCOLS = array('HTTP/1.1', 'HTTPS/1.1');

	/**
	 * Execute a request
	 * @return mixed
	 */
	public function execute()
	{
		$request = self::createRequest($_SERVER);
		$resourceController = new ResourceController();
		return $resourceController->treatRequest($request);
	}

	/**
	 * Construct a request
	 * @param array $requestInfo = Server and execution environment information
	 * @return array|Request
	 */
	public function createRequest($requestInfo)
	{
		if (!self::isValidMethod($requestInfo['REQUEST_METHOD'])) {
			return array(
				"code" => "405",
				"message" => "Method Not Allowed: A request method is not supported for the requested resource; for example, a GET request on a form which requires data to be presented via POST, or a PUT request on a read-only resource."
			);
		}

		if (!self::isValidProtocol($requestInfo['SERVER_PROTOCOL'])) {
			return array(
				"code" => "400",
				"message" => "Bad Request: The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, too large size, invalid request message framing, or deceptive request routing)"
			);
		}

		if (!self::isValidServerAddress($requestInfo['SERVER_NAME'])) {
			return array(
				"code" => "400",
				"message" => "Bad Request: The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, too large size, invalid request message framing, or deceptive request routing)"
			);
		}

//		if (!self::isValidPath($requestInfo['REQUEST_URI'])) {
//			return array(
//				"code" => "400",
//				"message" => "Bad Request: The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, too large size, invalid request message framing, or deceptive request routing)"
//			);
//		}
//
//		if (!self::isValidQueryString($requestInfo['QUERY_STRING'])) {
//			return array(
//				"code" => "400",
//				"message" => "Bad Request: The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, too large size, invalid request message framing, or deceptive request routing)"
//			);
//		}

		return new Request($requestInfo['REQUEST_METHOD'], $requestInfo['SERVER_PROTOCOL'], $requestInfo['SERVER_NAME'],
			$requestInfo['REMOTE_ADDR'], $requestInfo["REQUEST_URI"], $requestInfo['QUERY_STRING'],
			file_get_contents('php://input'));
	}

	/**
	 * Check if the request method is valid
	 * @param string $method = Which request method was used to access the page
	 * @return bool
	 */
	public function isValidMethod($method)
	{
		return (!is_null($method) || in_array($method, self::VALID_METHODS)) ? true : false;
	}

	/**
	 * Check if the request protocol is valid
	 * @param string $protocol = Name and revision of the information protocol via which the page was requested.
	 * @return bool
	 */
	public function isValidProtocol($protocol)
	{
		return (!is_null($protocol) || in_array($protocol, self::VALID_PROTOCOLS)) ? true : false;
	}

	/**
	 * Check if the name of the server host is valid
	 * @param string $serverAddress = The name of the server host under which the current script is executing. If the script is running
	 * on a virtual host, this will be the value defined for that virtual host.
	 * @return bool
	 */
	public function isValidServerAddress($serverAddress)
	{
		return (filter_var($serverAddress, FILTER_VALIDATE_IP) === true || $serverAddress = 'localhost') ? true : false;
	}

	/**
	 * Check if the user's IP address is valid
	 * @param string $clientAddress = The IP address from which the user is viewing the current page.
	 * @return bool
	 */
	public function isValidClientAddress($clientAddress)
	{
		return (filter_var($clientAddress, FILTER_VALIDATE_IP) === true) ? true : false;
	}

	/**
	 * Check if the URI is valid
	 * @param string $path = The URI which was given in order to access this page; for instance, '/index.html'.
	 * @return bool
	 */
	public function isValidPath($path)
	{
		return (filter_var($path, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === true) ? true : false;
	}

	/**
	 * Check if the query string is valid
	 * @param string $queryString = The query string, if any, via which the page was accessed.
	 * @return bool
	 */
	public function isValidQueryString($queryString)
	{
		return (filter_var($queryString, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED) === true) ? true : false;
	}

}
