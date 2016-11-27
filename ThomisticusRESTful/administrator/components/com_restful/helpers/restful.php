<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Restful
 * @author     Igor Moraes <igor.sgm@gmail.com>
 * @copyright  2016 Igor Moraes
 * @license    GNU General Public License
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Restful helper.
 *
 * @since  1.6
 */
class RestfulHelpersRestful
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string $vName string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_RESTFUL_TITLE_DASHBOARD'),
			'index.php?option=com_restful&view=dashboard',
			$vName == 'dashboard'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_RESTFUL_TITLE_RESOURCES'),
			'index.php?option=com_restful&view=resources',
			$vName == 'resources'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_RESTFUL_TITLE_EXTERNALSENDERS'),
			'index.php?option=com_restful&view=externalsenders',
			$vName == 'externalsenders'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_RESTFUL_TITLE_KEYS'),
			'index.php?option=com_restful&view=keys',
			$vName == 'keys'
		);

	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int $pk The item's id
	 *
	 * @param   string $table The table's name
	 *
	 * @param   string $field The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int)$pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_restful';

		$actions = array(
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.edit.own',
			'core.edit.state',
			'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * Gets a list of tables in database
	 * @return array
	 */
	public static function getTablesList()
	{
		$db = JFactory::getDbo();
		$config = JFactory::getConfig();

		$query = $db->getQuery(true);
		$query->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where("TABLE_SCHEMA = '" . $config->get('db') . "'");
		return $db->setQuery($query)->loadObjectList();
	}
}


class RestfulHelper extends RestfulHelpersRestful
{

}
