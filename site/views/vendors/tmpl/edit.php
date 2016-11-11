<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$myuser_id = JFactory::getUser()->id;
?>
<?php 
if(isset($this->item->user_id)): ?>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post">
	<legend><?php echo JText::_( 'COM_DDC_VENDOR_DETAILS' ); ?></legend>
		<div class="row-fluid">
			<div class="span8">
					<?php foreach($this->form->getFieldset('main_top') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="control-group span12">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<?php endif;?>
					<?php endforeach; ?>
					<div class="clearfix"></div>
			</div>
			<div class="span4">
					<?php foreach($this->form->getFieldset('main_right') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<?php endif;?>
					<?php endforeach; ?>
			</div>
        <div>
                <input type="hidden" name="task" value="vendor.save" />
                <input type="hidden" name="option" value="com_ddcshopbox" />
                <input type="hidden" name="controller" value="edit" />
                <?php echo JHtml::_('form.token'); ?>
                <button type="submit" class="btn btn-primary"><?php echo JText::_('COM_DDC_SUBMIT'); ?></button>
        </div>
	</form>

<?php 
else:
?>
<div>
	<p><?php echo JText::_('COM_DDC_USER_UNATHORISED');?></p>
</div>
<?php 
endif;
?>