<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = JFactory::getUser()->id;
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
$this->session = JFactory::getSession();
?>

<div class="row vendor">
	<div class="col-xs-8">
		<div class="row">
			<div class="pull-left img-rounded col-xs-4" style="height:180px;overflow:hidden" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
			    <img style="text-align:center;max-height:160px;min-width:100%" class="img-rounded" src="<?php echo $this->item->images; ?>">
			</div>
			<div class="col-xs-8" style="height:100px;">
				<?php
	    		$val = 0;
	    		if($this->session->get('ddclocation',null)==null): 
	    			$val = 1;
				elseif($this->item->distance/1000 < $params->get('distance_limit')):
					$val = 1;
				endif;
				if($val == 0):
				?>
				<p class="col-xs-4 pull-right" style="font-size:0.8em;line-height:20px;text-align:right;">
					<?php echo JText::_('COM_DDC_SHOP_OUT_OF_DELIVERY_RANGE'); ?><br>
					<i><?php echo '~'.number_format($this->item->distance/1000,2).' km'; ?></i>
				</p>
				<?php endif; ?>
				<h4 class="title col-xs-8"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
						
				<p style="margin: 0px;position:absolute;bottom:0px"><?php echo $this->item->address1." ".$this->item->address2.$this->item->city." "." ".$this->item->post_code; ?></small></p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-xs-4 shopMap">
		<?php ?>
		<div class="col-xs-12" id="map-canvas" style="height:180px;"></div>
	</div>
	<div class="clearfix"></div>
</div>
<hr>
<div class="row">
	<div class="col-md-12" style="margin-bottom:10px;">
		<p style="margin: 0px"><?php echo $this->item->description; ?></p>
	</div>
	<hr/>
	<div class="clearfix"></div>
	<?php foreach ($this->products as $product):?>
	<div class="col-md-12" style="margin-bottom:10px;">
		<div class="col-xs-9" style="position:relative;">
			<img class="pull-left col-xs-3 img-rounded" src="<?php echo JRoute::_($product->image_link); ?>" >
			<a class="title" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$product->ddc_vendor_product_id);?>"><?php echo $product->vendor_product_name; ?></a>
			<br>
			<p>
				<?php if($this->model->getpartjsonfield($product->product_params,'product_box')){echo JText::_('COM_DDC_PRODUCT_BOX').": ".$this->model->getpartjsonfield($product->product_params,'product_box').'<br>';}?>
    			<?php if($product->product_weight>0){echo JText::_('COM_DDC_WEIGHT').": ".number_format($product->product_weight,2)." ".$product->product_weight_uom.'<br>';}?>
    			<?php echo substr($product->vp_desc_s,0,160);if(strlen($product->vp_desc_s)>160){echo "...";} ?>
    		</p>
    		<p><span id="product_status<?php echo $product->ddc_vendor_product_id; ?>"></span></p>
    	</div>
    	<div class="col-xs-3">
    				
    		<ul style="text-decoration:none; list-style:none;padding:0;text-align:right;">
    			<?php if($product->product_state == 2):?>
    				<li><i><?php echo JText::_('COM_DDC_FROM')." "?></i><span class="ddcPriceOK"><?php echo $product->currency_symbol." ".number_format($product->product_price,2); ?></span></li>
    			<?php else: ?>
		    		<li class="ddcPriceOK"><?php echo $product->currency_symbol." ".number_format($product->product_price,2); ?></li>
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
		    		<form id="ddcCart<?php echo $product->ddc_vendor_product_id; ?>" class="col-md-8 clearfix">
						<input type="number" class="col-xs-12" style="margin-bottom: 5px;" min="<?php echo $this->model->getpartjsonfield($product->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($product->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($product->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($product->product_params,'step_order_level'); ?>"/>
						<input type="hidden" name="jform[product_price]" value="<?php echo number_format($product->product_price,2); ?>" />
						<input type="hidden" name="option" value="com_ddcshopbox" />
						<input type="hidden" name="controller" value="update" />
						<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
						<input type="hidden" name="jform[task]" value="shoppingcart.update" />
						<input type="hidden" name="format" value="raw" />
						<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
						<input type="hidden" name="jform[shop_post_code]" value="<?php echo $product->shop_post_code?>" />
						<input type="hidden" name="tmpl" value="component" />
						<input type="hidden" name="jform[ddc_vendor_product_id]" value="<?php echo $product->ddc_vendor_product_id?>" />
					</form>
					<button id="ddcCartBtn<?php echo $product->ddc_vendor_product_id; ?>" class="btn btn-primary col-md-4" onclick="ddcUpdateCart(<?php echo $product->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
					</li>
					<?php endif; ?>
				
				<?php endif; ?>
	    	</ul>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php endforeach; ?>
</div>
