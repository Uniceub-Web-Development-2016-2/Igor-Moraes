<?php defined('_JEXEC') or die;

// Import library dependencies
jimport('joomla.plugin.plugin');

class plgAjaxRestful extends JPlugin
{
	public function onAjaxRestful()
	{
		$schema = JFactory::getConfig()->get('db');
		$app = JFactory::getApplication()->input;

		if (!empty($app->get('resource'))) {
			return self::getColumns($schema, $app->get('resource'));
		}

		return self::getTablesList($schema);
	}

	/**
	 * Get columns from specific table in database
	 * @param $schema = database schema
	 * @param $resource = table name
	 *
	 * @return mixed
	 */
	private static function getColumns($schema, $resource)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('COLUMN_NAME as `column`, DATA_TYPE as `data_type`')
			->from('INFORMATION_SCHEMA.COLUMNS')
			->where("TABLE_SCHEMA = '" . $schema . "' AND TABLE_NAME = '" . $resource . "'");

		return $db->setQuery($query)->loadObjectList();
	}

	/**
	 * Gets a list of tables in database
	 * @param $schema = database schema
	 *
	 * @return mixed
	 */
	private static function getTablesList($schema)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('TABLE_NAME as `table`')->from('INFORMATION_SCHEMA.TABLES')->where("TABLE_SCHEMA = '" . $schema . "'");

		return $db->setQuery($query)->loadObjectList();
	}
}