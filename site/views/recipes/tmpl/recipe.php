<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
$this->session = JFactory::getSession();
$rdModel = new DdcshopboxModelsRecipedetails();
$ingredients = $rdModel->listItems($this->item->ddc_recipe_header_id);
?>
<div class="row">
	<h1><?php echo $this->item->title;?></h1>
	<hr>
	<div class="col-xs-9"><img src="<?php echo $this->item->image_link; ?>" width="100%" /></div>
	<div class="col-xs-3">
		<p><?php echo JText::_('COM_DDC_PREPARATION_TIME').":";?><br>
		<b><?php echo $this->item->prep_time." ".JText::_('COM_DDC_MINS');?></b></p>
		<p><?php echo JText::_('COM_DDC_COOKING_TIME').":";?><br>
		<b><?php echo $this->item->cook_time." ".JText::_('COM_DDC_MINS');?></b></p>
		<p><?php echo JText::_('COM_DDC_SERVES').":";?><br>
		<b><?php echo $this->item->serving_qty;?></b></p>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12">
		<p><?php echo $this->item->description; ?></p>
	</div>
	<div class="col-xs-12">
		<h2 class="col-md-5"><?php echo JText::_('COM_DDC_INGREDIENTS'); ?></h2>
		<div class="col-md-7"><h2><?php echo JText::_('COM_DDC_GET_PRODUCTS');?></h2></div>
		<div class="clearfix"></div>
		<ul class="col-md-5">
			<?php foreach($ingredients as $ingredient):?>
			<li style="border-bottom: 1px solid #fefefe;padding: 3px 3px 15px;"><?php echo $ingredient->item_detail; ?></li>
			<?php endforeach;?>
		</ul>
		<ul class="col-md-7" style="list-style:none;">
			<?php foreach($ingredients as $ingredient):?>
			<div class="row" style="border-bottom: 1px solid #fefefe;padding: 3px 3px 5px;min-height:30px;">
				<?php if(($ingredient->product_id!=0) || ($ingredient->ddc_vendor_product_id!=null)):?>
				<?php 
				if($ingredient->image_link==null)
				{
					$ingredient->image_link = 'images/ddcshopbox/picna_ushbub.png';
				}
				?>
				<div class="col-xs-7">
					<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendorproducts&layout=product&vendorproduct_id='.$ingredient->ddc_vendor_product_id); ?>">
					<div class="pull-left" style="width:35px;height:30px;margin-right:10px;overflow:hidden;"><img class="img-rounded" src="<?php echo $ingredient->image_link; ?>" style="max-height:100%;max-width:100%;text-align:center;"></div>
					<i style="font-size:0.8em;"><?php echo $ingredient->vendor_product_name; ?></i>
					</a>
					<?php $i = null;?>
					<i style="margin-top:3px;font-size:0.8em;"><?php if($this->model->getpartjsonfield($ingredient->product_params,'product_box')){$i=true;echo '- '.JText::_('COM_DDC_PRODUCT_BOX').": ".trim($this->model->getpartjsonfield($ingredient->product_params,'product_box'));}?>
	    			<?php if($ingredient->product_weight>0){if($i==null){echo '- ';}else{echo ', ';}echo JText::_('COM_DDC_WEIGHT').": ".number_format($ingredient->product_weight,2)." ".$ingredient->product_weight_uom;}?></i>
	    			<p style="font-size:0.7em;"><span id="product_status<?php echo $ingredient->ddc_vendor_product_id; ?>"></span></p>
				</div>
				<div class="col-xs-5">
					<button id="ddcCartBtn<?php echo $ingredient->ddc_vendor_product_id; ?>" class="btn btn-primary pull-right" onclick="ddcUpdateCart(<?php echo $ingredient->ddc_vendor_product_id; ?>)"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-shopping-cart"></i></button>
					<form id="ddcCart<?php echo $ingredient->ddc_vendor_product_id; ?>" class="pull-right">
							<input type="number" class="product_qty" id="product_qty<?php echo $ingredient->ddc_vendor_product_id; ?>" onchange="getProdPrice(<?php echo $ingredient->ddc_vendor_product_id; ?>)" class="col-xs-12" min="<?php echo $this->model->getpartjsonfield($ingredient->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($ingredient->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($ingredient->product_params,'step_order_level'); ?>" name="jform[product_quantity]" value="<?php echo $this->model->getpartjsonfield($ingredient->product_params,'min_order_level'); ?>"/>
							<input type="hidden" name="jform[product_price]" value="<?php echo $this->model->getProductPrice($ingredient->ddc_vendor_product_id); ?>" />
							<input type="hidden" name="option" value="com_ddcshopbox" />
							<input type="hidden" name="controller" value="update" />
							<input type="hidden" name="jform[table]" value="ddcshoppingcart" />
							<input type="hidden" name="jform[task]" value="shoppingcart.update" />
							<input type="hidden" name="jform[product_weight]" value="<?php echo $ingredient->product_weight; ?>" />
							<input type="hidden" name="jform[product_weight_uom]" value="<?php echo $ingredient->product_weight_uom; ?>" />
							<input type="hidden" name="format" value="raw" />
							<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
							<input type="hidden" name="jform[shop_post_code]" value="<?php //echo $ingredient->shop_post_code?>" />
							<input type="hidden" name="tmpl" value="component" />
							<input type="hidden" name="jform[ddc_vendor_product_id]" value="<?php echo $ingredient->ddc_vendor_product_id?>" />
						</form>
						<i class="ddcPrice pull-right">&pound; <?php echo number_format($this->model->getProductPrice($ingredient->ddc_vendor_product_id),2); ?> </i>
				</div>
				<?php endif;?>
			</div>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="col-xs-12">
		<h2><?php echo JText::_('COM_DDC_METHOD'); ?></h2>
		<p><?php echo $this->item->method; ?></p>
	</div>
</div>
