<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
$dim_result = $this->item->product_length*$this->item->product_width*$this->item->product_height;

$document =JFactory::getDocument();
$document->setTitle($this->item->vendor_product_name);
$document->setMetaData("image",$this->item->image_link);
$document->setMetaData("geo.placename",$this->item->address1.", ".$this->item->address2." ".$this->item->city.", ".$this->item->county.", ".$this->item->shop_post_code.", ".$this->item->country_name);
$document->setDescription($this->item->vp_desc);

?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=122601401136";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="row">
	<div class="col-xs-4 img-rounded product_image">
		<img style="min-height:100%;min-width:100%;" src="<?php echo JRoute::_($this->item->image_link); ?>" class="img-thumbnail" />
	</div>
	<div class="row col-xs-8">
		<div class="pull-left col-md-8">
			<h3 style="margin-top:10px;"><?php echo $this->item->vendor_product_name; ?></h3>
			<p><?php echo $this->item->vp_desc; ?></p>
			<br>
			<p><span id="product_status<?php echo $this->item->ddc_vendor_product_id; ?>"></span></p>
		</div>
		<div class="pull-right col-md-4" style="text-align:right;">
			<ul style="text-decoration:none; list-style:none;padding:0;">
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
	    		<button id="ddcCartBtn<?php echo $this->item->ddc_vendor_product_id; ?>" data-trigger="hover" title="Add to Cart" data-content="Click to add this product to your shopping cart on the left" data-toggle="popover" data-placement="bottom" class="btn btnCart pull-right btn-primary col-md-4" onclick="ddcUpdateCart(<?php echo $this->item->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
	    		<form id="ddcCart<?php echo $this->item->ddc_vendor_product_id; ?>" class="pull-right col-md-8 clearfix">
					<input type="number" id="product_qty<?php echo $this->item->ddc_vendor_product_id; ?>" onchange="getProdPrice(<?php echo $this->item->ddc_vendor_product_id; ?>)" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>"/>
					<input type="hidden" name="jform[product_price]" value="<?php echo number_format($this->item->product_price,2); ?>" />
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
				<li style="font-size:0.8em;line-height:13px;"><i><?php echo '~'.number_format($this->item->distance/1000,2).' km'; ?></i></li>
				<li style="font-size:0.8em;line-height:13px;color:#990000;"><?php echo JText::_('COM_DDC_SHOP_OUT_OF_DELIVERY_RANGE'); ?></li>
				<?php endif; ?>
			<?php endif; ?>
    		</ul>
    		<!-- Your like button code -->
			  <div class="fb-like" 
			  	data-href="<?php echo JUri::current(); ?>" data-layout="button_count" data-action="like"
			  	data-size="small" data-show-faces="false" data-share="false"></div>
		</div>
		<div class="clearfix"></div>
		<table class="ddctable">
			<tbody>
				<tr><td><?php echo JText::_('COM_DDC_STORE')?></td><td><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->vendor_id); ?>"><?php echo $this->item->vendor_name; ?></a>, <i><?php echo $this->item->city; ?></i></td></tr>
				<?php if($this->model->getpartjsonfield($this->item->product_params,'product_box')!=null): ?><tr><td><?php echo JText::_('COM_DDC_PRODUCT_BOX')?></td><td><?php echo $this->model->getpartjsonfield($this->item->product_params,'product_box'); ?></td></tr><?php endif; ?>
				<tr><td><?php echo JText::_('COM_DDC_MIN_ORDER_LEVEL')?></td><td><?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?></td></tr>
				<tr><td><?php echo JText::_('COM_DDC_WEIGHT');?></td><td><?php echo $this->model->ddcnumber(number_format($this->item->product_weight,2))." ".$this->item->product_weight_uom; ?></td></tr>
				<?php if($dim_result>0):?><tr><td><?php echo JText::_('COM_DDC_DIMENSIONS');?></td><td><?php echo $this->model->ddcnumber($this->item->product_length)." x ".$this->model->ddcnumber($this->item->product_width)." x ".$this->model->ddcnumber($this->item->product_height); ?></td></tr><?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="clearfix"></div>
	<br>
</div>
<div class="row">
	<div class="col-md-12">
		<br>
		
		
	
	</div>
	<div class="col-md-12">
		<h2><?php echo JText::_('COM_DDC_MOST_POPULAR_PRODUCTS'); ?></h2>
		<?php 
		$i=0;
		foreach($this->cart_items as $item): ?>
			<div class="col-md-3 col-sm-4 col-xs-6" style="padding:3px;">
			<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$item->ddc_vendor_product_id); ?>" style="text-decoration:none;">
			<div style="height:250px;border:1px solid #efefef;border-radius:10px;overflow:hidden;padding:0px;margin:2px;">
			<img src="<?php echo JRoute::_().$item->image_link; ?>" width="100%" /><br>
			<h4 style="text-align:center;"><?php echo $item->vendor_product_name; ?></h4>
			<p style="text-align:right;padding-right:10px;color:#333;"><span class="ddcPrice"><?php echo $item->currency_symbol." ".number_format($item->product_price,2); ?></span>
			<small><?php if($item->product_base_uom==1): echo "/each"; elseif($item->product_base_uom==2): echo "/set"; elseif($item->product_base_uom==3): echo "/pack"; else: echo "/pair"; endif; ?></small>
			</p>
			</div>
			</a>
			</div>
			<?php $i++; ?>
			<?php if($i==4):
				break;
			endif; ?>
		<?php endforeach; ?>
	</div>
</div>
