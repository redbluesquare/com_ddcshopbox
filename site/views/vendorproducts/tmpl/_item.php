<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
if($this->item->image_link==null)
{
	$this->item->image_link = 'images/ddcshopbox/picna_ushbub.png';
}
?>
<?php if($this->item->product_type<=2):?>
<div id="productRow<?php echo $this->item->ddc_vendor_product_id; ?>" class="col-xs-6 col-sm-12 col-md-12 col-lg-12">
    <div class="productItembar">
    <div class="itembar pull-left" id="vendor-row-<?php echo $this->item->ddc_vendor_product_id; ?>">
    	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$this->item->ddc_vendor_product_id); ?>">
    		<img src="<?php echo $this->item->image_link; ?>">
    	</a>
    </div>
    <div class="productDescbar pull-left col-xs-12 col-sm-4 col-md-6 col-lg-6">
    	<h4 class="header" style="line-height:20px;margin-top:2px;margin-bottom:4px;"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$this->item->ddc_vendor_product_id); ?>"><?php echo $this->item->vendor_product_name; ?></a></h4>
    	<p>
    		<?php if($this->model->getpartjsonfield($this->item->product_params,'product_box')){echo JText::_('COM_DDC_PRODUCT_BOX').": ".$this->model->getpartjsonfield($this->item->product_params,'product_box').'<br>';}?>
    		<?php if($this->item->product_weight>0){echo JText::_('COM_DDC_WEIGHT').": ".number_format($this->item->product_weight,2)." ".$this->item->product_weight_uom.'<br>';}?>
    		<?php if($this->model->getpartjsonfield($this->item->product_params,'min_order_level')>1){echo JText::_('COM_DDC_MIN_ORDER_LEVEL').": ". $this->model->getpartjsonfield($this->item->product_params,'min_order_level').'<br>';} ?>
    	<p><span id="product_status<?php echo $this->item->ddc_vendor_product_id; ?>"></span></p>
    </div>
    <div class="productPricebar pull-right col-xs-12 col-sm-4 col-md-3 col-lg-3">
    	<ul style="text-decoration:none; list-style:none;padding:0;text-align:right;">
    		<?php 
    			if($this->item->product_state == 2):?>
    			<li><i><?php echo JText::_('COM_DDC_FROM')." "?></i><span class="ddcPriceOK"><?php echo $this->item->currency_symbol." ".number_format(($this->model->getpartjsonfield($this->item->product_params,'min_order_level')*$this->model->getPriceItem($this->item->product_price,$this->model->getpartjsonfield($this->item->product_params,'price_weight_based'),$this->item->product_weight,$this->item->product_weight_uom)),2); ?></span></li>
    		<?php else: ?>
    			<li><span class="ddcPriceOK"><?php echo $this->item->currency_symbol." <span id=\"productPrice".$this->item->ddc_vendor_product_id."\">".number_format(($this->model->getpartjsonfield($this->item->product_params,'min_order_level')*$this->model->getPriceItem($this->item->product_price,$this->model->getpartjsonfield($this->item->product_params,'price_weight_based'),$this->item->product_weight,$this->item->product_weight_uom)),2); ?></span></span>
    			<?php if($this->model->getpartjsonfield($this->item->product_params,'product_price_estimate')==1):
				echo '<i class="priceEstimate" data-trigger="hover" title="Estimated Price" data-content="The final price may vary due to the actual weight of the product. We will inform you if it is more than 3% in difference" data-toggle="popover" data-placement="bottom" >est.</i>';
				endif;?>
    			</li>
	    		<?php if($this->item->product_weight>0): ?><li><small><?php echo "(".$this->item->currency_symbol." ".number_format($this->model->getPricePerKg($this->item->product_price,$this->model->getpartjsonfield($this->item->product_params,'price_weight_based'),$this->item->product_weight,$this->item->product_weight_uom),2); ?> / kg)</small></li><?php endif; ?>
    		<?php
    		$val = 0;
    		if($this->session->get('ddclocation',null)==null): 
    			$val = 1;
			elseif($this->item->distance/1000 < $params->get('distance_limit')):
				$val = 1;
			endif;
			if($val == 1):
			?>
			<li class="clearfix">
    		<button id="ddcCartBtn<?php echo $this->item->ddc_vendor_product_id; ?>" class="pull-right btn btn-primary col-xs-6"onclick="ddcUpdateCart(<?php echo $this->item->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
    		<form id="ddcCart<?php echo $this->item->ddc_vendor_product_id; ?>" class="pull-right col-xs-6 clearfix">
				<input type="number" name="jform[product_quantity]" id="product_qty<?php echo $this->item->ddc_vendor_product_id; ?>" onchange="getProdPrice(<?php echo $this->item->ddc_vendor_product_id; ?>)" style="padding:5px 0px 5px 0px;text-align:center;min-width:50px;" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>" value="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>"/>
				<input type="hidden" name="jform[product_price]" value="<?php echo number_format($this->model->getPriceItem($this->item->product_price,$this->model->getpartjsonfield($this->item->product_params,'price_weight_based'),$this->item->product_weight,$this->item->product_weight_uom),2); ?>" />
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
				<input type="hidden" name="jform[task]" value="shoppingcart.update" />
				<input type="hidden" name="jform[product_weight]" value="<?php echo $this->item->product_weight; ?>" />
				<input type="hidden" name="jform[product_weight_uom]" value="<?php echo $this->item->product_weight_uom; ?>" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
				<input type="hidden" name="jform[shop_post_code]" value="<?php echo $this->item->shop_post_code?>" />
				<input type="hidden" name="tmpl" value="component" />
				<input type="hidden" name="jform[ddc_vendor_product_id]" value="<?php echo $this->item->ddc_vendor_product_id?>" />
			</form>
			</li>
			<?php else: ?>
			<li><i><?php echo '~'.number_format($this->item->distance/1000,2).' km'; ?></i></li>
			<li><?php echo JText::_('COM_DDC_SHOP_OUT_OF_DELIVERY_RANGE'); ?></li>
			<?php endif; ?>
			<?php endif; ?>
    	</ul>
    		<div style="width:100%;line-height:9px;"><i class="ddcShopData pull-right" style="width:100%;"><?php echo $this->item->vendor_name; ?></i></div>
    		<div style="width:100%;"><i class="ddcShopData pull-right" style="width:100%;"><?php echo $this->item->city; ?></i></div>
	</div> 
	</div>
</div>
<?php endif; ?>