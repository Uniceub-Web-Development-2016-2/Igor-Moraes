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

jimport('joomla.application.component.controllerform');

/**
 * Externalsender controller class.
 *
 * @since  1.6
 */
class RestfulControllerExternalsender extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'externalsenders';
		parent::__construct();
	}

	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param   JModelLegacy $model The data model object.
	 * @param   array $validData The validated data.
	 *
	 * @return    void
	 *
	 * @since    3.1
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{

	}

}
