<?php defined('_JEXEC') or die;

// Import library dependencies
jimport('joomla.plugin.plugin');

include_once(JPATH_ROOT . '/ws/externalsender/ExternalSender.php');

class plgAjaxLogrestful extends JPlugin
{
	/**
	 * @var Number of rows in Log table
	 */
	private $logsCount;

	/**
	 * Get row's number of Log Table
	 * @return int
	 */
	public function onAjaxLogrestful()
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('COUNT(*)')->from('#__restful_extsender_logs');

		$result = $db->setQuery($query)->loadResult();

		if ($result != $this->logsCount) {
			$this->logsCount = $result;
			(new ExternalSender())->sendMultipleRequests($this->getNoSentRequests(), $result);
		}

		return $result;
	}

	/**
	 * Get array of elements that must and have not been sent yet
	 * @return mixed|array = request that have not been sent yet
	 */
	private function getNoSentRequests()
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('id, resource, id_resource_element, method')->from('#__restful_extsender_logs')
			->where('request_sent = 0');

		$result = $db->setQuery($query)->loadAssocList();

		return $result;
	}

}