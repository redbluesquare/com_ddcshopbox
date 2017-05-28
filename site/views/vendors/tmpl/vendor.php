<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = JFactory::getUser()->id;
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
$this->session = JFactory::getSession();

$document = JFactory::getDocument();
$document->setTitle($this->item->title);
$document->setMetaData("image",$this->item->images);
$document->setMetaData("geo.placename",$this->item->address1.", ".$this->item->address2." ".$this->item->city.", ".$this->item->county.", ".$this->item->post_code.", ".$this->item->country_name);
$document->setDescription($this->item->introduction);
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=122601401136";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="row vendor-header">
	<div class="col-xs-8">
		<div class="row">
			<div class="pull-left img-rounded col-xs-4" style="height:180px;overflow:hidden" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
			    <img style="text-align:center;max-height:160px;min-width:100%" class="img-rounded" src="<?php echo $this->item->images; ?>">
			</div>
			<div class="pull-left col-xs-8" style="height:100px;padding-left:10px;">
				<?php
	    		$val = 0;
	    		if($this->session->get('ddclocation',null)==null): 
	    			$val = 1;
				elseif($this->item->distance/1000 < $params->get('distance_limit')):
					$val = 1;
				endif;
				if($val == 0):
				?>
				<p class="pull-right" style="font-size:0.8em;line-height:20px;text-align:right;">
					<?php echo JText::_('COM_DDC_SHOP_OUT_OF_DELIVERY_RANGE'); ?><br>
					<i><?php echo '~'.number_format($this->item->distance/1000,2).' km'; ?></i>
				</p>
				<?php endif; ?>
				<h4 class="title"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_1_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Mon</div>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_2_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Tue</div>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_3_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Wed</div>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_4_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Thu</div>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_5_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Fri</div>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_6_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Sat</div>
				<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_0_open')==1){$class = 'vendor-available';}else{$class = 'vendor-unavailable';} ?>
				<div class="<?php echo $class;?> pull-left">Sun</div>
				<p class="vendor-address"><small><?php echo $this->item->address1.", ".$this->item->address2." ".$this->item->city.", ".$this->item->post_code; ?></small><br>
					<?php echo $this->model->getpartjsonfield($this->item->contact_numbers,'contact_tel'); ?>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-sm-4 shopMap tablet-visible">
		<?php ?>
		<div class="col-xs-12" id="map-canvas" style="height:180px;"></div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row">
	<div class="col-md-12" style="margin-bottom:10px;">
		<p style="margin: 0px"><?php echo $this->item->description; ?></p>
	</div>
	
	<!-- Nav tabs -->
  	<ul class="nav nav-tabs" role="tablist">
    	<li role="presentation" class="active"><a href="#ddcshop" aria-controls="ddcshop" role="tab" data-toggle="tab"><?php echo JText::_('COM_DDC_SHOP'); ?></a></li>
    	<li role="presentation"><a href="#ddcevents" aria-controls="ddcevents" role="tab" data-toggle="tab"><?php echo JText::_('COM_DDC_EVENTS'); ?></a></li>
    	<?php if($this->item->allow_bookings == 1):?>
    		<li role="presentation"><a href="#ddcbookings" aria-controls="ddcbookings" role="tab" data-toggle="tab"><?php echo JText::_('COM_DDC_BOOKINGS'); ?></a></li>
    	<?php endif; ?>
    	<li role="presentation"><a href="#ddcreviews" aria-controls="ddcreviews" role="tab" data-toggle="tab"><?php echo JText::_('COM_DDC_REVIEWS'); ?></a></li>
  	</ul>
	<!-- Tab panes -->
  	<div class="tab-content" style="min-height:200px;">
	<div class="tab-pane active" style="margin-bottom:10px;" role="tabpanel" id="ddcshop">
		<?php foreach ($this->products as $product):?>
			<?php if($product->product_type<=2):?>
			<?php 
			if($product->image_link==null)
			{
				$product->image_link = 'images/ddcshopbox/picna_ushbub.png';
			}
			?>
			<div class="col-xs-9" style="position:relative;margin:10px 0px 0px 0px;">
				<img class="pull-left col-xs-3 img-rounded" src="<?php echo JRoute::_($product->image_link); ?>" >
				<h4 class="header" style="line-height:20px;margin-top: 2px;margin-bottom:4px"><a class="title" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$product->ddc_vendor_product_id);?>"><?php echo $product->vendor_product_name; ?></a></h4>
				<p>
					<?php if($this->model->getpartjsonfield($product->product_params,'product_box')){echo JText::_('COM_DDC_PRODUCT_BOX').": ".$this->model->getpartjsonfield($product->product_params,'product_box').'<br>';}?>
	    			<?php if($product->product_weight>0){echo JText::_('COM_DDC_WEIGHT').": ".number_format($product->product_weight,2)." ".$product->product_weight_uom.'<br>';}?>
	    			<?php echo JText::_('COM_DDC_MIN_ORDER_LEVEL').": ". $this->model->getpartjsonfield($product->product_params,'min_order_level').'<br>'; ?>
	    			<?php echo substr($product->vp_desc_s,0,160);if(strlen($product->vp_desc_s)>160){echo "...";} ?>
	    		</p>
	    		<p><span id="product_status<?php echo $product->ddc_vendor_product_id; ?>"></span></p>
	    	</div>
	    	<div class="col-xs-3">
	    				
	    		<ul style="text-decoration:none; list-style:none;padding:0;text-align:right;">
	    			<?php 
    				if($product->product_state == 2):?>
    					<li><i><?php echo JText::_('COM_DDC_FROM')." "?></i><span class="ddcPriceOK"><?php echo $product->currency_symbol." ".number_format(($this->model->getpartjsonfield($product->product_params,'min_order_level')*$this->model->getPriceItem($product->product_price,$this->model->getpartjsonfield($product->product_params,'price_weight_based'),$product->product_weight,$product->product_weight_uom)),2); ?></span></li>
    				<?php else: ?>
    					<li><span class="ddcPriceOK"><?php echo $product->currency_symbol." <span id=\"productPrice".$product->ddc_vendor_product_id."\">".number_format(($this->model->getpartjsonfield($product->product_params,'min_order_level')*$this->model->getPriceItem($product->product_price,$this->model->getpartjsonfield($product->product_params,'price_weight_based'),$product->product_weight,$product->product_weight_uom)),2); ?></span></span>
    				<?php if($this->model->getpartjsonfield($product->product_params,'product_price_estimate')==1):
						echo '<i class="priceEstimate" data-trigger="hover" title="Estimated Price" data-content="The final price may vary due to the actual weight of the product. We will inform you if it is more than 3% in difference" data-toggle="popover" data-placement="bottom" >est.</i>';
					endif;?>
    					</li>
	    				<?php if($product->product_weight>0): ?><li><small><?php echo "(".$product->currency_symbol." ".number_format($this->model->getPricePerKg($product->product_price,$this->model->getpartjsonfield($product->product_params,'price_weight_based'),$product->product_weight,$product->product_weight_uom),2); ?> / kg)</small></li><?php endif; ?>
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
							<input type="number" id="product_qty<?php echo $product->ddc_vendor_product_id; ?>" onchange="getProdPrice(<?php echo $product->ddc_vendor_product_id; ?>)" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($product->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($product->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($product->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($product->product_params,'min_order_level'); ?>"/>
							<input type="hidden" name="jform[product_price]" value="<?php echo number_format(($this->model->getpartjsonfield($product->product_params,'min_order_level')*$this->model->getPriceItem($product->product_price,$this->model->getpartjsonfield($product->product_params,'price_weight_based'),$product->product_weight,$product->product_weight_uom)),2); ?>" />
							<input type="hidden" name="option" value="com_ddcshopbox" />
							<input type="hidden" name="controller" value="update" />
							<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
							<input type="hidden" name="jform[task]" value="shoppingcart.update" />
							<input type="hidden" name="jform[product_weight]" value="<?php echo $product->product_weight; ?>" />
							<input type="hidden" name="jform[product_weight_uom]" value="<?php echo $product->product_weight_uom; ?>" />
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
			<?php endif;?>
			<div class="clearfix"></div>
			<?php endforeach; ?>
		</div>
		<div class="tab-pane" style="margin-bottomn:10px;" role="tabpanel" id="ddcevents">
			<?php foreach ($this->products as $product):?>
			<?php if($product->product_type==3):?>
			<div class="col-xs-12" style="position:relative;margin:10px 0px 0px 0px;">
				<?php echo $product->vendor_product_name; ?>
			</div>
			<?php endif;?>
			<div class="clearfix"></div>
			<?php endforeach; ?>
			<div class="col-xs-6 pull-right">
			<?php if($this->model->getpartjsonfield($this->item->vendor_details,'social_site_1')==1):?>
				<div class="fb-page" 
				  data-href="<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'social_url_1')?>"
				  data-tabs="timeline,events,messages"
				  data-width="500" 
				  data-hide-cover="false"
				  data-show-facepile="false" 
				  data-show-posts="true">
				</div>
			<?php endif; ?>
			</div>
		</div>
		<?php if($this->item->allow_bookings == 1):?>
		<div class="tab-pane" style="margin-bottom:10px;" role="tabpanel" id="ddcbookings">
			<?php
			$this->_vendorBookingView->form = $this->form;
			$this->_vendorBookingView->type = 'form';
			$this->_vendorBookingView->item = $this->item;
			$this->_vendorBookingView->type = 'item';
			echo $this->_vendorBookingView->render();
			?>
			
			<div class="col-xs-4" style="padding-top:20px;">
				
				
				<div class="clearfix"></div>
			</div>
			<div class="col-xs-8">
				
			</div>
			<div class="clearfix"></div>
		</div>
		<?php endif;?>
		<div class="tab-pane" style="margin-bottomn:10px;" role="tabpanel" id="ddcreviews">
			<div class="row">
				<?php 
				foreach($this->postings as $posting):
				?>
				<div class="col-xs-12 ddcreview_bar">
					<div class="col-xs-10">
						<p><?php echo $posting->message;?></p>
					</div>
					<?php 
					if($posting->state==0):
					?>
					<div class="col-xs-2">
						<button class="btn" style="margin-bottom:5px;" onclick="updateReview(1,<?php echo $posting->ddc_posting_id?>)"><?php echo JText::_('COM_DDC_APPROVE'); ?></button>
						<button class="btn" onclick="updateReview(-2,<?php echo $posting->ddc_posting_id?>)"><?php echo JText::_('COM_DDC_REJECT'); ?></button>
					</div>
					<?php 
					endif;
					?>
				</div>
				<form id="reviewPost<?php echo $posting->ddc_posting_id?>">
				<input name="jform[ddc_posting_id]" type="hidden" value="<?php echo $posting->ddc_posting_id?>" />
				<input name="option" type="hidden" value="com_ddcshopbox" />
				<input name="jform[table]" type="hidden" value="ddcpostings" />
				<input name="controller" type="hidden" value="edit" />
				<input name="format" type="hidden" value="raw" />
				<input name="task" type="hidden" value="review.approval" />
				</form>
				<div class="clearfix"></div>
				<?php 
				endforeach;
				?>
			</div>
			<div class="row">
				<h4><?php echo JText::_('COM_DDC_ADD_A_REVIEW'); ?></h4>
				<?php 
				if(JFactory::getUser()->id!=0):
				?>
				<div class="col-xs-10">
				<form id="reviewPost">
				<textarea name="jform[message]" rows="4" cols="30" class="form-control" placeholder="Place a review now :)"></textarea>
				<input name="jform[ddc_posting_id]" type="hidden" value="" />
				<input name="jform[vendor_id]" type="hidden" value="<?php echo $this->item->ddc_vendor_id; ?>" />
				<input name="option" type="hidden" value="com_ddcshopbox" />
				<input name="jform[table]" type="hidden" value="ddcpostings" />
				<input name="controller" type="hidden" value="edit" />
				<input name="format" type="hidden" value="raw" />
				<input name="task" type="hidden" value="review.save" />
				</form>
				<div id="reviewPostStatus"></div>
				</div>
				<div class="col-xs-2">
					<input class="btn btn-primary col-xs-12 btnReview" onclick="postReview(0)" type="button" value="Add Review" />
				</div>
				<?php else: ?>
				<p><?php echo JText::_('COM_DDC_LOGIN_TO_POST_REVIEW');?></p>
				<?php endif; ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
