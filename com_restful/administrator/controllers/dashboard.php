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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Restful Controller Dashboard
 *
 * @package Restful
 *
 */
class RestfulControllerDashboard extends JControllerAdmin
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
}
