<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Restful
 * @author     Igor Moraes <igor.sgm@gmail.com>
 * @copyright  2016 Igor Moraes
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//require_once JPATH_COMPONENT . '/helpers/restful.php';

/**
 * HTML View class for the Restful Dashboard component
 *
 * @package Restful
 *
 */
class RestfulViewDashboard extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal') {
			RestfulHelpersRestful::addSubmenu('dashboard');
		}

		// Initialise variables
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->tablesList = RestfulHelpersRestful::getTablesList();
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors
		if (count($errors = $this->get('Errors'))) {
//			JError::raiseError(500, implode("\n", $errors));
			throw new Exception(500, implode("\n", $errors));
		}

		// We don't need toolbar in the modal window.
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar
	 *
	 */
	protected function addToolbar()
	{
		JToolbarHelper::title(JText::_('Restful Manager'), 'restful.png');

		require_once JPATH_COMPONENT . '/helpers/restful.php';
		$canDo = RestfulHelpersRestful::getActions();

		if ($canDo->get('core.admin')) {
			JToolbarHelper::preferences('com_restful');
		}

		JHtmlSidebar::setAction('index.php?option=com_restful&view=dashboard');

	}

}
