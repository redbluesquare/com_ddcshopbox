<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div id="profileaddressModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="profileaddressModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDC_PROFILE_ADDRESS'); ?></h3>
  </div>
  <div class="modal-body">
	<div class="row-fluid">
		<form id="contactAddressForm" style="height:300px;overflow:scroll;">
			<?php foreach($this->form->getFieldset('profile_fields') as $field): ?>
					<div class="row-fluid">
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="col-xs-4 control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
						</div>
						<div class="col-xs-8">
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<div class="clearfix" style="padding-bottom:3px;"></div>
						<?php endif;?>
					</div>
					<?php endforeach; ?>
					<?php foreach($this->form->getFieldset('address_fields') as $field): ?>
					<div class="row-fluid">
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="col-xs-4 control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
						</div>
						<div class="col-xs-8">
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<div class="clearfix" style="padding-bottom:3px;"></div>
						<?php endif;?>
					</div>
					<?php endforeach; ?>
					<?php foreach($this->form->getFieldset('contact_fields') as $field): ?>
					<div class="row-fluid">
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="col-xs-4 control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
						</div>
						<div class="col-xs-8">
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<div class="clearfix" style="padding-bottom:3px;"></div>
						<?php endif;?>
					</div>
					<?php endforeach; ?>
					<?php foreach($this->form->getFieldset('hidden_fields') as $field): ?>
					<div class="row-fluid">
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="col-xs-4 control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
						</div>
						<div class="col-xs-8">
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<div class="clearfix" style="padding-bottom:3px;"></div>
						<?php endif;?>
					</div>
					<?php endforeach; ?>
			<input name="jform[task]" type="hidden" value="edit" />
			
		</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="saveContactAddress()"><?php echo JText::_('COM_DDC_SAVE'); ?></button>
  </div>
  </div>
  </div>
</div>
