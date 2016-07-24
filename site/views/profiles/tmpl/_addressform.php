<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div id="profileaddressModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="profileaddressModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDC_PROFILE_ADDRESS'); ?></h3>
  </div>
  <div class="modal-body">
	<div class="row-fluid">
		<form id="contactAddressForm">
			<?php foreach($this->form->getFieldset('profile_address') as $field): ?>
					<div class="row-fluid">
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="span4">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
						</div>
						<div class="span8">
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<div class="clearfix"></div>
						<?php endif;?>
					</div>
					<?php endforeach; ?>
			<input name="jform[table]" type="hidden" value="contactaddress" />
			<input name="jform[task]" type="hidden" value="edit" />
			
		</form>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="saveContactAddress()"><?php echo JText::_('COM_DDC_SAVE'); ?></button>
  </div>
</div>
