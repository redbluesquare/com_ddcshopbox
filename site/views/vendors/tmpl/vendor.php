<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = JFactory::getUser()->id;
?>

<div class="row vendor">
	<div class="col-xs-8">
		<div class="row">
			<div class="pull-left img-rounded" style="width:120px;height:100px;border:1px solid #ccc;overflow:hidden" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
			    <img style="margin: 0 auto;min-height:100px;width:100%" class="img-rounded" src="<?php echo $this->item->images; ?>">
			</div>
			<div class="col-xs-8" style="height:100px;position:relative;">
				<p class="title"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
				<p style="margin: 0px"><?php echo substr($this->item->description,0,180)."..."; ?></p>
				<p style="margin: 0px;position:absolute;bottom:0px"><?php echo $this->item->address1." ".$this->item->address2.$this->item->city." "." ".$this->item->post_code; ?></small></p>
			</div>
			<div class="clearfix"></div>
		</div>
		<br>
		<div class="row">
			<?php foreach ($this->products as $product):?>
			<div class="col-xs-12" style="margin-bottom:10px;">
				<div style="position:relative;">
					<img class="pull-left col-xs-3 img-rounded" src="<?php echo JRoute::_($product->image_link); ?>" hspace="7" >
					<span class="pull-right"><?php echo $product->currency_symbol." ".number_format($product->product_price,2); ?></span>
					<a class="title" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=products&layout=default&product_id='.$product->ddc_product_id);?>"><?php echo $product->product_name; ?></a>
					<br>
					<p class="pull-left col-xs-4"><?php echo $product->product_description_small; ?></p>
					<button class="btn pull-right btn-primary"onclick="ddcUpdateCart(<?php echo $product->ddc_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
					<form id="ddcCart<?php echo $product->ddc_product_id; ?>" class="pull-right" style="width:70px">
						<input type="number" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($product->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($product->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($product->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($product->product_params,'step_order_level'); ?>"/>
						<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
						<input type="hidden" name="option" value="com_ddcshopbox" />
						<input type="hidden" name="controller" value="update" />
						<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
						<input type="hidden" name="jform[task]" value="shoppingcart.update" />
						<input type="hidden" name="format" value="raw" />
						<input type="hidden" name="tmpl" value="component" />
						<input type="hidden" name="jform[ddc_product_id]" value="<?php echo $product->ddc_product_id?>" />
					</form>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="span4">
		<?php ?>
		<div class="span12" id="map-canvas" style="height:280px;"></div>
	</div>
</div>
