<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
?>
<div id="productRow<?php echo $this->item->ddc_vendor_product_id; ?>" class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
    <div class="productItemgroup">
    <div class="text-center" style="height:150px;min-width:100%;overflow:hidden;" id="vendor-row-<?php echo $this->item->ddc_product_id; ?>">
    	<a style="height:inherit;width:inherit;overflow:hidden;" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$this->item->ddc_vendor_product_id); ?>">
    		<img src="<?php echo $this->item->image_link; ?>" style="min-width:100%;min-height:100%;object-fit:contain;">
    	</a>
    </div>
    <div class="productDescgroup">
    	<h4 class="header" style="line-height:20px;margin-top:2px;margin-bottom:4px;"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$this->item->ddc_vendor_product_id); ?>"><?php echo $this->item->vendor_product_name; ?></a></h4>
    	<p>
    		<?php if($this->model->getpartjsonfield($this->item->product_params,'product_box')){echo JText::_('COM_DDC_PRODUCT_BOX').": ".$this->model->getpartjsonfield($this->item->product_params,'product_box').'<br>';}?>
    		<?php if($this->item->product_weight>0){echo JText::_('COM_DDC_WEIGHT').": ".number_format($this->item->product_weight,2)." ".$this->item->product_weight_uom.'<br>';}?>
    	<p><span id="product_status<?php echo $this->item->ddc_vendor_product_id; ?>"></span></p>
    </div>
    <div class="productPricegroup col-xs-12">
    	<ul style="text-decoration:none; list-style:none;padding:0;">
    		<?php if($this->item->product_state == 2):?>
    			<li class="ddcPrice"><i><?php echo JText::_('COM_DDC_FROM')." "?></i><span class="ddcPriceOK"><?php echo $this->item->currency_symbol." ".number_format($this->item->product_price,2); ?></span></li>
    		<?php else: ?>
    		<li class="ddcPriceOK"><?php echo $this->item->currency_symbol." ".number_format($this->item->product_price,2); ?></li>
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
    		<button id="ddcCartBtn<?php echo $this->item->ddc_vendor_product_id; ?>" class="btn btn-primary col-xs-6"onclick="ddcUpdateCart(<?php echo $this->item->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
    		<form id="ddcCart<?php echo $this->item->ddc_vendor_product_id; ?>" class="col-xs-6 clearfix">
				<input type="number" style="padding:5px 0px 5px 0px;text-align:center;min-width:50px;" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>"/>
				<input type="hidden" name="jform[product_price]" value="<?php echo number_format($this->item->product_price,2); ?>" />
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
				<input type="hidden" name="jform[task]" value="shoppingcart.update" />
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
    </div>
    <div class="ddcShopData col-xs-12">
    		<i><?php echo $this->item->vendor_name; ?></i><br>
    		<i><?php echo $this->item->city; ?></i><br>
	</div> 
	</div>
</div>
