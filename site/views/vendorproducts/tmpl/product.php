<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$dim_result = $this->item->product_length*$this->item->product_width*$this->item->product_height;
?>
<div class="row">
	<div class="col-md-3 img-rounded">
		<img width="90%" src="<?php echo JRoute::_($this->item->image_link); ?>" class="img-thumbnail" />
	</div>
	<div class="row col-md-9">
		<div class="pull-left col-md-8">
			<h3 style="margin-top:10px;"><?php echo $this->item->vendor_product_name; ?></h3>
			<p><?php echo $this->item->vp_desc; ?></p>
		</div>
		<div class="pull-right col-md-4">
			<p class="ddcPriceOK" style="text-align: right;padding-right:10px;"><?php echo $this->item->currency_symbol." ".number_format($this->item->product_price,2); ?></p>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row-fluid col-md-9">
		<div class="col-md-12">
			<button class="btn pull-right btn-primary"onclick="ddcUpdateCart(<?php echo $this->item->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
			<form id="ddcCart<?php echo $this->item->ddc_vendor_product_id; ?>" class="pull-right col-md-3">
				<input type="number" class="col-md-12" min="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>"/>
				<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
				<input type="hidden" name="jform[task]" value="shoppingcart.update" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="tmpl" value="component" />
				<input type="hidden" name="jform[ddc_vendor_product_id]" value="<?php echo $this->item->ddc_vendor_product_id?>" />
			</form>
			
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<br>
		<table class="ddctable">
			<tbody>
				<tr><td width="30%"><?php echo JText::_('COM_DDC_PRODUCT_SKU');?></td><td width="70%"><?php echo $this->item->product_sku; ?></td></tr>
				<tr><td><?php echo JText::_('COM_DDC_WEIGHT');?></td><td><?php echo $this->model->ddcnumber(number_format($this->item->product_weight,2))." ".$this->item->product_weight_uom; ?></td></tr>
				<?php if($dim_result>0):?><tr><td><?php echo JText::_('COM_DDC_DIMENSIONS');?></td><td><?php echo $this->model->ddcnumber($this->item->product_length)." x ".$this->model->ddcnumber($this->item->product_width)." x ".$this->model->ddcnumber($this->item->product_height); ?></td></tr><?php endif; ?>
				<tr><td><?php echo JText::_('COM_DDC_STORE')?></td><td><?php echo $this->item->vendor_name; ?></td></tr>
				<tr><td><?php echo JText::_('COM_DDC_PRODUCT_BOX')?></td><td><?php echo $this->model->getpartjsonfield($this->item->product_params,'product_box'); ?></td></tr>
			</tbody>
		</table>
		
		
	</div>
</div>
