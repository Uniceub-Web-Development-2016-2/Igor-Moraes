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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_restful')) {
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

//Adding juri_base to be used by ajax plugins
$document = JFactory::getDocument();
$document->addScriptDeclaration("var juri_base = '" . JUri::root() . "';");

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Restful', JPATH_COMPONENT_ADMINISTRATOR);

$controller = JControllerLegacy::getInstance('Restful');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
