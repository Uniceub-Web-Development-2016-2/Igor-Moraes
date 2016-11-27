<?php
require_once(JPATH_ROOT . '/ws/externalsender/httpful.phar');
include_once JPATH_ROOT . '/ws/Config.inc.php';
require_once(JPATH_ROOT . '/ws/database/Update.php');
require_once(JPATH_ROOT . '/ws/database/Read.php');

class ExternalSender
{
	private $read;
	private $update;
	private $METHODMAP = ['INSERT' => 'post', 'UPDATE' => 'put', 'DELETE' => 'delete'];

	/**
	 * ExternalSender constructor.
	 */
	public function __construct()
	{
		$this->read = new Read();
		$this->update = new Update();
	}

	/**
	 * Send multiples Http Request to another server
	 *
	 * @param $items = Items to be sent trough http request
	 * @param $result = number of rows at log table
	 *
	 * @return int|string $result = The result is returned to Ajax function
	 */
	public function sendMultipleRequests($items, $result)
	{
		foreach ($items as $key => $item) {
			$this->sendRequest($this->getExternalSenderURL($item['resource']),
				$this->getItemJson($item), $this->METHODMAP[$item['method']]);

			$this->updateRequestSentLog($item['id']);
		}
		return $result;
	}

	/**
	 * @param string $url = URL to send the request
	 * @param string|mixed $json = Request Body
	 * @param string $method = Request method (post, put)
	 *
	 * @return mixed|object = Resultado da Request (Httpful object)
	 */
	public function sendRequest($url, $json, $method)
	{
		$response = \Httpful\Request::$method($url)->sendsJson()->body($json)->send();
		return $response;
	}

	/**
	 * Retrieves the URL to be sent as http request to external server
	 * @param $resource = table name
	 *
	 * @return string = url to sent Request (usually external WS)
	 */
	public function getExternalSenderURL($resource)
	{
		$this->read->exeRead(PREFIX . "restful_external_senders", "url", " WHERE `table` = :resource",
			"resource={$resource}");
		return $this->read->getResult()[0]['url'];
	}

	/**
	 * This method get information of updated/inserted/deleted element on triggered table
	 * based on resource and id_resource_element from log table
	 * @param $item = element in log table
	 *
	 * @return mixed|string = json to Http Request (body)
	 */
	public function getItemJson($item)
	{
		$this->read->exeRead($item['resource'], "*", " WHERE `id` = :id", "id=" . $item['id_resource_element']);
		$element = !empty($this->read->getResult()) ? $this->read->getResult()[0] : '';

		if ($item['method'] != 'UPDATE' && !empty($element)) {
			unset($element['id']);
		}

		return (!empty($element)) ? json_encode($element) : '';
	}

	/**
	 * Method to update Log Database, saying that specific request has already been sent to external url
	 * @param $id = primary key's row of log database
	 */
	public function updateRequestSentLog($id)
	{
		$this->update->exeUpdate(PREFIX . 'restful_extsender_logs', array('request_sent' => 1), "id={$id}");
		$this->update->getResult();
	}
}
