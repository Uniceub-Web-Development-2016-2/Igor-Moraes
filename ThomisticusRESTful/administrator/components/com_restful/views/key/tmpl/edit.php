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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_restful/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'key.cancel') {
			Joomla.submitform(task, document.getElementById('key-form'));
		}
		else {

			if (task != 'key.cancel' && document.formvalidator.isValid(document.id('key-form'))) {

				Joomla.submitform(task, document.getElementById('key-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_restful&layout=edit&id=' . (int)$this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="key-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_RESTFUL_TITLE_KEY', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					<?php echo $this->form->renderField('id'); ?>
					<?php echo $this->form->renderField('state'); ?>
					<?php echo $this->form->renderField('key'); ?>
					<?php echo $this->form->renderField('user_id'); ?>
					<?php echo $this->form->renderField('daily_requests'); ?>
					<?php echo $this->form->renderField('expiration_date'); ?>
					<?php echo $this->form->renderField('comment'); ?>
					<?php echo $this->form->renderField('hits'); ?>
					<?php echo $this->form->renderField('last_visit'); ?>
					<?php echo $this->form->renderField('current_day'); ?>
					<?php echo $this->form->renderField('current_hits'); ?>
					<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>"/>
					<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>"/>
					<input type="hidden" name="jform[checked_out_time]"
					       value="<?php echo $this->item->checked_out_time; ?>"/>

					<?php echo $this->form->renderField('created_by'); ?>
					<?php echo $this->form->renderField('modified_by'); ?>

					<?php if ($this->state->params->get('save_history', 1)) : ?>
						<div class="control-group">
							<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
							<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
						</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php if (JFactory::getUser()->authorise('core.admin', 'restful')) : ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions',
				JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
			<?php echo $this->form->getInput('rules'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
