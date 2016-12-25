<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<tr id="productRow<?php echo $this->item->ddc_product_id; ?>">
  <td class="col-xs-12">
    <div class="pull-left col-md-2" id="vendor-row-<?php echo $this->item->ddc_product_id; ?>">
    	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$this->item->ddc_vendor_product_id); ?>">
    		<img class="img-rounded" src="<?php echo $this->item->image_link; ?>" style="max-height:100px;margin:0 auto;text-align:center;">
    	</a>
    </div>
    <div class="col-md-10">
    	<div class="col-md-9">
    		
    		<h4 class="header"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$this->item->ddc_vendor_product_id); ?>"><?php echo $this->item->vendor_product_name; ?></a></h4>
    		<p>
    			<?php if($this->model->getpartjsonfield($this->item->product_params,'product_box')){echo JText::_('COM_DDC_PRODUCT_BOX').": ".$this->model->getpartjsonfield($this->item->product_params,'product_box').'<br>';}?>
    			<?php if($this->item->product_weight>0){echo JText::_('COM_DDC_WEIGHT').": ".number_format($this->item->product_weight,2)." ".$this->item->product_weight_uom.'<br>';}?>
    			<?php echo substr($this->item->vp_desc_s,0,160);if(strlen($this->item->vp_desc_s)>160){echo "...";} ?></p>
    	</div>
    	<div class="col-md-3" style="text-align:right;">
    		<ul style="text-decoration:none; list-style:none;padding:0;">
    		<li class="ddcPriceOK"><?php echo $this->item->currency_symbol." ".number_format($this->item->product_price,2); ?></li>
    		<li class="clearfix">
    		<button class="btn pull-right btn-primary col-md-4"onclick="ddcUpdateCart(<?php echo $this->item->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
    		<form id="ddcCart<?php echo $this->item->ddc_vendor_product_id; ?>" class="pull-right col-md-8">
				<input type="number" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>"/>
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
				<input type="hidden" name="jform[task]" value="shoppingcart.update" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="tmpl" value="component" />
				<input type="hidden" name="jform[ddc_vendor_product_id]" value="<?php echo $this->item->ddc_vendor_product_id?>" />
			</form>
			</li>
    		<li><i><?php echo $this->item->vendor_name; ?></i></li>
    		<li><i><?php echo $this->item->city; ?></i></li>
    	</div>
    </div>
    
  </td>
</tr>
