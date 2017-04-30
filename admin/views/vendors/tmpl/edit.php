<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<div class="span12">
	<form action="<?php echo JRoute::_('index.php?option=com_ddcshopbox&controller=edit'); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_DDC_VENDOR_DETAILS' ); ?></legend>
                <div class="adminformlist">
                <ul class="nav nav-tabs">
  					<li class="active"><a data-toggle="tab" href="#vendor_information"><?php echo JText::_('COM_DDC_VENDOR_INFORMATION'); ?></a></li>
  					<li><a data-toggle="tab" href="#shop_details"><?php echo JText::_('COM_DDC_SHOP_DETAILS'); ?></a></li>
				</ul>
      			<div class="tab-content">
				<div  id="vendor_information" class="tab-pane fade in active">
					<div class="span9">
					<div class="row-fluid">
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
					<div class="row-fluid">
					<?php foreach($this->form->getFieldset('main') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="span12">
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
						</div>
						<?php endif;?>
					<?php endforeach; ?>
					</div>
					<div class="clearfix"></div>

					</div>
					<div class="span3">
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
					</div>
					<div  id="shop_details" class="tab-pane fade in">
					<div class="row-fluid">
					<?php foreach($this->form->getFieldset('page2_shop_details') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="control-group span4">
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
					</div>
				</div>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="vendor.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
</div>
