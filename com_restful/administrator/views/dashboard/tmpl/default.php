<?php
/**
 * jBackend component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package jBackend
 * @copyright Copyright 2014 - 2016
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 3.1.0
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Load the tooltip behavior
JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Add styles
$document = JFactory::getDocument();
$document->addStyleDeclaration('#quick-icons { clear:both; margin:-1px 0 8px; padding:8px 0; position:relative; z-index:8; }');
$document->addStyleDeclaration('#quick-icons.k2NoLogo { margin:0 0 8px; padding:0; border:none; }');
$document->addStyleDeclaration('#quick-icons div.icon-wrapper { float:left; display: block !important; width: auto !important; height :auto!important; line-height:12px !important; background: none; }');
$document->addStyleDeclaration('#quick-icons div.icon { text-align:center; margin-right:15px; float:left; margin-bottom:15px; }');
$document->addStyleDeclaration('#quick-icons div.icon a { background-color:#fff; background-position:-30px; display:block; float:left; height:97px; width:108px; color:#565656; vertical-align:middle; text-decoration:none; border:1px solid #CCC; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; -webkit-transition-property:background-position, 0 0; -moz-transition-property:background-position, 0 0; -webkit-transition-duration:.8s; -moz-transition-duration:.8s; }');
$document->addStyleDeclaration('#quick-icons div.icon a:hover { background-position:0; -webkit-border-bottom-left-radius:50% 20px; -moz-border-radius-bottomleft:50% 20px; border-bottom-left-radius:50% 20px; -webkit-box-shadow:-5px 10px 15px rgba(0,0,0,0.25); -moz-box-shadow:-5px 10px 15px rgba(0,0,0,0.25); box-shadow:-5px 10px 15px rgba(0,0,0,0.25); position:relative; z-index:10; }');
$document->addStyleDeclaration('#quick-icons div.icon a img { padding:10px 0; margin:0 auto; }');
$document->addStyleDeclaration('#quick-icons div.icon a span { display:block; text-align:center; }');
$document->addStyleDeclaration('.pane-toggler, .pane-toggler-down { background-color: #d9edf7; border-color: #bce8f1; color: #3a87ad; text-shadow: 0 1px 0 rgba(255,255,255,0.5); border: 1px solid #fbeed5; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; padding: 8px 35px 8px 14px; }');

$tables = $this->tablesList;

$user = JFactory::getUser();
?>
<?php if (!empty($this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
		<?php endif; ?>

		<div class="row-fluid">
			<div class="span12">
				<?php var_dump($this->tablesList); ?>
			</div>
		</div>
	</div>