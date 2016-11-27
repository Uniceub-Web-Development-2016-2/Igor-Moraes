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
class RestfulViewKeys extends JViewLegacy
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

		RestfulHelpersRestful::addSubmenu('keys');

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

		JToolBarHelper::title(JText::_('COM_RESTFUL_TITLE_KEYS'), 'keys.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/key';

		if (file_exists($formPath)) {
			if ($canDo->get('core.create')) {
				JToolBarHelper::addNew('key.add', 'JTOOLBAR_NEW');
				JToolbarHelper::custom('keys.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
			}

			if ($canDo->get('core.edit') && isset($this->items[0])) {
				JToolBarHelper::editList('key.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state')) {
			if (isset($this->items[0]->state)) {
				JToolBarHelper::divider();
				JToolBarHelper::custom('keys.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('keys.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH',
					true);
			} elseif (isset($this->items[0])) {
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'keys.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state)) {
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('keys.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out)) {
				JToolBarHelper::custom('keys.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state)) {
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
				JToolBarHelper::deleteList('', 'keys.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			} elseif ($canDo->get('core.edit.state')) {
				JToolBarHelper::trash('keys.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_restful');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_restful&view=keys');

		$this->extra_sidebar = '';
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text",
				$this->state->get('filter.state'), true)

		);
		//Filter for the field user_id
		$this->extra_sidebar .= '<div class="other-filters">';
		$this->extra_sidebar .= '<small><label for="filter_user_id">User</label></small>';
		$this->extra_sidebar .= JHtmlList::users('filter_user_id', $this->state->get('filter.user_id'), 1,
			'onchange="this.form.submit();"');
		$this->extra_sidebar .= '</div>';
		$this->extra_sidebar .= '<hr class="hr-condensed">';

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
			'a.`key`' => JText::_('COM_RESTFUL_KEYS_KEY'),
			'a.`user_id`' => JText::_('COM_RESTFUL_KEYS_USER_ID'),
			'a.`daily_requests`' => JText::_('COM_RESTFUL_KEYS_DAILY_REQUESTS'),
			'a.`expiration_date`' => JText::_('COM_RESTFUL_KEYS_EXPIRATION_DATE'),
			'a.`comment`' => JText::_('COM_RESTFUL_KEYS_COMMENT'),
			'a.`hits`' => JText::_('COM_RESTFUL_KEYS_HITS'),
			'a.`last_visit`' => JText::_('COM_RESTFUL_KEYS_LAST_VISIT'),
			'a.`current_day`' => JText::_('COM_RESTFUL_KEYS_CURRENT_DAY'),
			'a.`current_hits`' => JText::_('COM_RESTFUL_KEYS_CURRENT_HITS'),
		);
	}
}
