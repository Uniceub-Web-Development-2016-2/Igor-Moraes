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

jimport('joomla.application.component.view');

/**
 * View class for a list of Restful.
 *
 * @since  1.6
 */
class RestfulViewResources extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string $tpl Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}

		RestfulHelpersRestful::addSubmenu('resources');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = RestfulHelpersRestful::getActions();

		JToolBarHelper::title(JText::_('COM_RESTFUL_TITLE_RESOURCES'), 'resources.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/resource';

		if (file_exists($formPath)) {
			if ($canDo->get('core.create')) {
				JToolBarHelper::addNew('resource.add', 'JTOOLBAR_NEW');
				JToolbarHelper::custom('resources.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
			}

			if ($canDo->get('core.edit') && isset($this->items[0])) {
				JToolBarHelper::editList('resource.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state')) {
			if (isset($this->items[0]->state)) {
				JToolBarHelper::divider();
				JToolBarHelper::custom('resources.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('resources.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH',
					true);
			} elseif (isset($this->items[0])) {
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'resources.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state)) {
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('resources.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out)) {
				JToolBarHelper::custom('resources.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state)) {
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
				JToolBarHelper::deleteList('', 'resources.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			} elseif ($canDo->get('core.edit.state')) {
				JToolBarHelper::trash('resources.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_restful');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_restful&view=resources');

		$this->extra_sidebar = '';
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text",
				$this->state->get('filter.state'), true)

		);
		//Filter for the field table
		$select_label = JText::sprintf('COM_RESTFUL_FILTER_SELECT_LABEL', 'Table');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "0";
		$options[0]->text = "--- Selecione ---";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_table',
			JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.table'), true)
		);

		//Filter for the field privileges
		$select_label = JText::sprintf('COM_RESTFUL_FILTER_SELECT_LABEL', 'Privileges');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "create";
		$options[0]->text = "Create";
		$options[1] = new stdClass();
		$options[1]->value = "read";
		$options[1]->text = "Read";
		$options[2] = new stdClass();
		$options[2]->value = "update";
		$options[2]->text = "Update";
		$options[3] = new stdClass();
		$options[3]->value = "delete";
		$options[3]->text = "Delete";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_privileges',
			JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.privileges'), true)
		);

		//Filter for the field columns
		$select_label = JText::sprintf('COM_RESTFUL_FILTER_SELECT_LABEL', 'Columns');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "0";
		$options[0]->text = "--";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_columns',
			JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.columns'), true)
		);

	}

	/**
	 * Method to order fields
	 *
	 * @return void
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'a.`state`' => JText::_('JSTATUS'),
			'a.`table`' => JText::_('COM_RESTFUL_RESOURCES_TABLE'),
			'a.`privileges`' => JText::_('COM_RESTFUL_RESOURCES_PRIVILEGES'),
			'a.`columns`' => JText::_('COM_RESTFUL_RESOURCES_COLUMNS'),
			'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
		);
	}
}
