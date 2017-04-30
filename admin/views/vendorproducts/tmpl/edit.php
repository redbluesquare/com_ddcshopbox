<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<div class="span12">
	<form action="<?php echo JRoute::_('index.php'); ?>"
      method="post" name="adminForm" id="adminForm">
      	
                <div class="adminformlist">
                <ul class="nav nav-tabs">
  					<li class="active"><a data-toggle="tab" href="#product_information"><?php echo JText::_('COM_DDC_PRODUCT_INFORMATION'); ?></a></li>
  					<li><a data-toggle="tab" href="#product_images"><?php echo JText::_('COM_DDC_PRODUCT_IMAGES'); ?></a></li>
				</ul>
      	<div class="tab-content">
		<div  id="product_information" class="tab-pane fade in active">
			<fieldset class="adminform">
      			<legend><?php echo JText::_( 'COM_DDC_VENDOR_PRODUCT_DETAILS' ); ?></legend>
	                <div class="span9">
	                	<div class="row-fluid">
						<div class="span4">
						<?php foreach($this->form->getFieldset('product_information_left') as $field): ?>
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
						<?php foreach($this->form->getFieldset('product_information_right') as $field): ?>
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
						<div class="span4">
						<?php foreach($this->form->getFieldset('product_dimensions_left') as $field): ?>
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
						<div class="clearfix"></div>
						</div>
						<div class="row-fluid">
						<div class="span12">
						<?php foreach($this->form->getFieldset('product_description_bottom') as $field): ?>
							<?php if ($field->hidden):// If the field is hidden, just display the input.?>
								<?php echo $field->input;?>
							<?php else:?>
							<div>
								<div>
								<?php echo $field->label; ?>
								<?php if (!$field->required && $field->type != 'Spacer') : ?>
									<span><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
								<?php endif; ?>
								</div>
								<div>
									<?php echo $field->input;?>
								</div>
							</div>
							<?php endif;?>
						<?php endforeach; ?>
						<div class="clearfix"></div>
					</div>
						</div>
					</div>
					<div class="span3">
						<?php foreach($this->form->getFieldset('product_dimensions_right') as $field): ?>
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
					</fieldset>
				</div>
        	
        <?php if($this->form->getFieldset('product_information_left')["jform_ddc_vendor_product_id"]->value!=null):?>
        <div  id="product_images" class="tab-pane fade">
        	<h2><?php echo JText::_('COM_DDC_PRODUCT_IMAGES'); ?></h2>
        		<div class="span6">
					<form id="upload_form" enctype="multipart/form-data" method="post">
		  				<input type="file" id="upload_photo" name="upload_photo" accept="image/*" onchange="uploadPhoto('ddc_products','<?php echo $this->form->getFieldset('product_information_left')["jform_ddc_vendor_product_id"]->value; ?>')" />
		  				<progress id="progressBar" class="progress active" value="0" max="100" style="width:300px;"></progress>
						<h5 id="status"></h5>
					</form>
				</div>
				<div class="span6">
					<div class="row" id="imagetiles">
						<?php foreach($this->productimages as $productimage): ?>
						<div class="span4" style="height:80px;">
							<img src="<?php echo JUri::root().$productimage->image_link; ?>" class="img-thumbnail" onclick="removePhoto(<?php echo $productimage->ddc_image_id; ?>)" />
						</div>
						<?php endforeach; ?>
					</div>
				</div>
        	</div>
        	<?php endif; ?>	
        
        </div>
        <div>
        		<input type="hidden" name="option" value="com_ddcshopbox" />
        		<input type="hidden" name="controller" value="edit" />
                <input type="hidden" name="task" value="vendorproduct.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
</div>
