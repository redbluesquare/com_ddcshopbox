<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$myuser_id = JFactory::getUser()->id;
?>
<?php 
if(isset($this->vendor->user_id)): ?>
<form class="ddcform">
	<legend><?php echo JText::_( 'COM_DDC_PRODUCT_DETAILS' ); ?></legend>
	<ul class="nav nav-tabs">
  		<li class="active"><a data-toggle="tab" href="#product_information"><?php echo JText::_('COM_DDC_PRODUCT_INFORMATION'); ?></a></li>
  		<li><a data-toggle="tab" href="#product_description"><?php echo JText::_('COM_DDC_PRODUCT_DESCRIPTION'); ?></a></li>
  		<li><a data-toggle="tab" href="#product_dims_and_weight"><?php echo JText::_('COM_DDC_PRODUCT_DIMENSIONS_WEIGHT'); ?></a></li>
  		<?php if($this->product->ddc_product_id>0):?>
  		<li><a data-toggle="tab" href="#product_images"><?php echo JText::_('COM_DDC_PRODUCT_IMAGES'); ?></a></li>
  		<?php endif; ?>
	</ul>
		<div class="tab-content">
			<div  id="product_information" class="tab-pane fade in active">
			<h2><?php echo JText::_('COM_DDC_PRODUCT_INFORMATION'); ?></h2>
			<div class="row">
				<div class="col-xs-6">
					<?php foreach($this->form->getFieldset('product_information_left') as $field): ?>
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
			<div class="col-xs-6">
					<?php foreach($this->form->getFieldset('product_information_right') as $field): ?>
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
			<div class="clearfix"></div>
        </div>
        <h2><?php echo JText::_('COM_DDC_PRODUCT_PRICES'); ?></h2>
        <div class="row">
				<div class="col-xs-6">
					<?php foreach($this->form->getFieldset('product_price_left') as $field): ?>
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
			<div class="col-xs-6">
					<?php foreach($this->form->getFieldset('product_price_right') as $field): ?>
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
			<div class="clearfix"></div>
        </div>
        </div>
        	<div  id="product_description" class="tab-pane fade">
        	<h2><?php echo JText::_('COM_DDC_DESCRIPTIONS'); ?></h2>
        	<div class="row">
        	<div class="col-xs-12 clearfix">
					<?php foreach($this->form->getFieldset('product_description') as $field): ?>
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
        	</div>
        	<div  id="product_dims_and_weight" class="tab-pane fade">
        	<h2><?php echo JText::_('COM_DDC_PRODUCT_DIMENSIONS_WEIGHT'); ?></h2>
        	<div class="row">
        		<div class="col-xs-6">
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
			<div class="col-xs-6">
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
        	</div>
        	</div>
        	<div  id="product_images" class="tab-pane fade">
        	<h2><?php echo JText::_('COM_DDC_PRODUCT_IMAGES'); ?></h2>
        	<div class="row">
        		<div class="col-xs-6">
					<form id="upload_form" enctype="multipart/form-data" method="post">
		  				<input type="file" id="upload_photo" name="upload_photo" accept="image/*" onchange="uploadPhoto('ddc_products','<?php echo $this->product->ddc_product_id; ?>')" />
		  				<progress id="progressBar" class="progress active" value="0" max="100" style="width:300px;"></progress>
						<h5 id="status"></h5>
					</form>
				</div>
				<div class="col-xs-6">
					<div class="row" id="imagetiles">
						<?php foreach($this->productimages as $productimage): ?>
						<div class="col-xs-4" style="height:80px;">
							<img src="<?php echo JRoute::_($productimage->image_link); ?>" class="img-thumbnail" />
						</div>
						<?php endforeach; ?>
					</div>
				</div>
        	</div>
        	</div>
        		<input type="hidden" id="jform_vendor_id" name="jform[vendor_id]" value="<?php echo $this->vendor->ddc_vendor_id; ?>" />
                <input type="hidden" name="option" value="com_ddcshopbox" />
                <input type="hidden" name="controller" value="edit" />
                <?php echo JHtml::_('form.token'); ?>
                <br>
        	</div>
	</form>
	<button onclick="ddcsubmit('product.save')" class="btn btn-success"><?php echo JText::_('COM_DDC_SUBMIT'); ?></button>

<?php 
else:
?>
<div>
	<p><?php echo JText::_('COM_DDC_USER_UNATHORISED');?></p>
</div>
<?php 
endif;
?>
