<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div id="schDetailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="schDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel"><?php echo JText::_('COM_DDC_SHOPPING_CART_DETAIL_UPDATE'); ?></h3>
	  </div>
	  <div class="modal-body">
			<form id="schDetailForm" style="height:300px;overflow:scroll;">
				<?php foreach($this->form->getFieldset('schdetail_fields') as $field): ?>
						<div style="padding-left:50px;">
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
							<div class="span4 control-group">
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
							<div class="clearfix" style="padding-bottom:3px;"></div>
							<?php endif;?>
						</div>
						<?php endforeach; ?>
				<input name="jform[task]" type="hidden" value="edit" />
			</form>
	  </div>
	  <div class="modal-footer">
	    <button class="btn btn-primary" onclick="saveschDeatailForm()"><?php echo JText::_('COM_DDC_SAVE'); ?></button>
	  </div>
  </div>
</div>
