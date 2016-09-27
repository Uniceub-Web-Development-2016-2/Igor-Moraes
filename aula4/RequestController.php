<?php

class RequestController
{
	const VALID_METHODS = array('GET', 'POST', 'PUT', 'DELETE');
	const VALID_PROTOCOL = array('HTTP/1.1', 'HTTPS/1.1');
	const VALID_SERVER_NAME = 'localhost';
	const VALID_PATH = '/DW/Igor-Moraes/aula4/';

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

		if (!self::isValidServerName($requestInfo['SERVER_NAME'])) {
			return array(
				"code" => "400",
				"message" => "Bad Request: The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, too large size, invalid request message framing, or deceptive request routing)"
			);
		}

		if (!self::isValidPath($requestInfo['REQUEST_URI'])) {
			return array(
				"code" => "406",
				"message" => "Not Acceptable: The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request."
			);
		}


//        $requestInfo['REQUEST_METHOD'];
//        $requestInfo['SERVER_PROTOCOL'];
//        $requestInfo['SERVER_NAME'];
//        $requestInfo['REMOTE_ADDR'];
//        $requestInfo["REQUEST_URI"];
//        $requestInfo['QUERY_STRING'];
//        file_get_contents('php://input');
//
//        return new Request();
	}

	public function isValidMethod($method)
	{
		if (is_null($method) || !in_array($method, self::VALID_METHODS)) {
			return false;
		}

		return true;
	}

	public function isValidProtocol($protocol)
	{
		if (is_null($protocol) || !in_array($protocol, self::VALID_PROTOCOL)) {
			return false;
		}

		return true;
	}

	public function isValidServerName($serverName)
	{
		if (is_null($serverName) || !self::VALID_SERVER_NAME) {
			return false;
		}

		return true;
	}

	public function isValidPath($requestURI)
	{
		$path = parse_url($requestURI)['path'];
		if (is_null($path) || !self::VALID_PATH) {
			return false;
		}

		return true;
	}


}
