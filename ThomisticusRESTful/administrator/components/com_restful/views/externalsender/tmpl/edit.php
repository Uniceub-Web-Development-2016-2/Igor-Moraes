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

//Import JS
$document->addScript(JUri::root() . 'media/com_restful/js/restful.js');
?>
<script type="text/javascript">

	var selectedTable = '<?= $this->item->table; ?>';
	var modelSchema = '<?= $this->item->model_schema_relationship; ?>';

	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'externalsender.cancel') {
			Joomla.submitform(task, document.getElementById('externalsender-form'));
		}
		else {

			if (task != 'externalsender.cancel' && document.formvalidator.isValid(document.id('externalsender-form'))) {

				Joomla.submitform(task, document.getElementById('externalsender-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_restful&layout=edit&id=' . (int)$this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="externalsender-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general',
			JText::_('COM_RESTFUL_TITLE_EXTERNALSENDER', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>"/>
					<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>"/>
					<?php echo $this->form->renderField('url'); ?>
					<?php echo $this->form->renderField('route'); ?>
					<?php echo $this->form->renderField('table'); ?>
					<?php echo $this->form->renderField('model_schema_relationship'); ?>

					<div id="model_schema_relationship" class="span8">

						<table id="tbl-mdl-schema" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>#</th>
								<th>Local database column</th>
								<th>External database column</th>
								<th>From/To</th>
							</tr>
							</thead>
							<tbody id="tbl-mdl-body">

							</tbody>
						</table>
					</div>

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
