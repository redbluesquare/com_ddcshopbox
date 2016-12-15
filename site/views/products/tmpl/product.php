<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$dim_result = $this->product->product_length*$this->product->product_width*$this->product->product_height;
?>
<div class="row">
	<div class="col-xs-12">
		<h3><?php echo $this->product->product_name; ?></h3>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row">
	<div class="col-xs-3 pull-left img-rounded">
		<img src="<?php echo JRoute::_($this->product->image_link); ?>" class="img-thumbnail" />
	</div>
	<div class="row col-xs-9">
		<div class="col-xs-8">
			<p><?php echo $this->product->product_description; ?></p>
		</div>
		<div class="col-xs-4">
			<p style="text-align: right;padding-right:10px;"><?php echo $this->product->currency_symbol." ".number_format($this->product->product_price,2); ?></p>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row-fluid col-xs-9">
		<div class="col-xs-12">
			<button class="btn pull-right btn-primary"onclick="ddcUpdateCart(<?php echo $this->product->ddc_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
			<form id="ddcCart<?php echo $this->product->ddc_product_id; ?>" class="pull-right col-xs-3">
				<input type="number" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($this->product->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->product->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->product->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($this->product->product_params,'step_order_level'); ?>"/>
				<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
				<input type="hidden" name="jform[task]" value="shoppingcart.update" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="tmpl" value="component" />
				<input type="hidden" name="jform[ddc_product_id]" value="<?php echo $this->product->ddc_product_id?>" />
			</form>
			
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<br>
		<table class="ddctable">
			<tbody>
				<tr><td><?php echo JText::_('COM_DDC_PRODUCT_SKU');?></td><td><?php echo $this->product->product_sku; ?></td></tr>
				<tr><td><?php echo JText::_('COM_DDC_WEIGHT');?></td><td><?php echo $this->model->ddcnumber(number_format($this->product->product_weight,2))." ".$this->product->product_weight_uom; ?></td></tr>
				<?php if($dim_result>0):?><tr><td><?php echo JText::_('COM_DDC_DIMENSIONS');?></td><td><?php echo $this->model->ddcnumber($this->product->product_length)." x ".$this->model->ddcnumber($this->product->product_width)." x ".$this->model->ddcnumber($this->product->product_height); ?></td></tr><?php endif; ?>
				<tr><td><?php echo JText::_('COM_DDC_STORE')?></td><td><?php echo $this->product->title; ?></td></tr>
				<tr><td><?php echo JText::_('COM_DDC_PRODUCT_BOX')?></td><td><?php echo $this->model->getpartjsonfield($this->product->product_params,'product_box'); ?></td></tr>
			</tbody>
		</table>
		
		
	</div>
</div>
