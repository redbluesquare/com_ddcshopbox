<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<tr id="productRow<?php echo $this->item->ddc_product_id; ?>">
  <td class="col-xs-12">
    <div class="pull-left col-md-2" id="vendor-row-<?php echo $this->item->ddc_product_id; ?>">
    	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=products&layout=product&product_id='.$this->item->ddc_product_id); ?>">
    		<img class="img-rounded" src="<?php echo $this->item->image_link; ?>" style="max-height:100px;margin:0 auto;text-align:center;">
    	</a>
    </div>
    <div class="col-md-10">
    	<div class="col-md-9">
    		
    		<h4 class="header"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=products&layout=product&product_id='.$this->item->ddc_product_id); ?>"><?php echo $this->item->product_name; ?></a></h4>
    		<p><?php echo substr($this->item->product_description,0,160);if(strlen($this->item->description)>160){echo "...";} ?></p>
    	</div>
    	<div class="col-md-3" style="text-align:right;">
    		<ul style="text-decoration:none; list-style:none;padding:0;">
    		<li style="font-size:1.5em;color:#44aaee"><?php echo $this->item->currency_symbol." ".number_format($this->item->product_price,2); ?></li>
    		<li class="clearfix">
    		<button class="btn pull-right btn-primary col-md-4"onclick="ddcUpdateCart(<?php echo $this->item->ddc_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
    		<form id="ddcCart<?php echo $this->item->ddc_product_id; ?>" class="pull-right col-md-8">
				<input type="number" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($this->item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($this->item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($this->item->product_params,'step_order_level'); ?>"/>
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
				<input type="hidden" name="jform[task]" value="shoppingcart.update" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="tmpl" value="component" />
				<input type="hidden" name="jform[ddc_product_id]" value="<?php echo $this->item->ddc_product_id?>" />
			</form>
			</li>
    		<li><i><?php echo $this->item->title; ?></i></li>
    		<li><i><?php echo $this->item->town; ?></i></li>
    	</div>
    </div>
    
  </td>
</tr>
