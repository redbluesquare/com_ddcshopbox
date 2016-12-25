<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
$products_total = null;
$params = JComponentHelper::getParams('com_ddcshopbox');
$app = JFactory::getApplication();
?>

<h1><?php echo JText::_('COM_DDC_SHOPPING_CART'); ?></h1>
<form id="ddcshopcart">
<table class="table">
<thead>
	<tr>
		<th><?php echo JText::_('COM_DDC_PRODUCT_NAME'); ?></th>
		<th><?php echo JText::_('COM_DDC_PRODUCT_SKU'); ?></th>
		<th style="text-align: center;"><?php echo JText::_('COM_DDC_PRODUCT_PRICE'); ?></th>
		<th style="text-align: center;"><?php echo JText::_('COM_DDC_QUANTITY'); ?></th>
		<th style="text-align: center;"><?php echo JText::_('COM_DDC_DISCOUNT'); ?></th>
		<th style="text-align: center;"><?php echo JText::_('COM_DDC_TOTAL'); ?></th>
		<td></td>
	</tr>
</thead>
<tbody>
	
	<?php foreach($this->items as $item):?>
	<tr>
		<td style="text-align:bottom;">
			<div class="pull-left" style="width:35px;height:30px;margin-right:10px;overflow:hidden;"><img class="img-rounded" src="<?php echo $item->image_link; ?>" style="max-height:100%;max-width:100%;text-align:center;"></div>
			<i style="font-size:1.2em;font-weight:bold;"><?php echo $item->vendor_product_name; ?></i>
			<?php $i = null;?>
			<i style="margin-top:3px;font-size:0.9em;"><?php if($this->model->getpartjsonfield($item->product_params,'product_box')){$i=true;echo '- '.JText::_('COM_DDC_PRODUCT_BOX').": ".trim($this->model->getpartjsonfield($item->product_params,'product_box'));}?>
    		<?php if($item->product_weight>0){if($i==null){echo '- ';}else{echo ', ';}echo JText::_('COM_DDC_WEIGHT').": ".number_format($item->product_weight,2)." ".$item->product_weight_uom;}?></i>
    					
		</td>
		<td><?php echo $item->vendor_product_sku; ?></td>
		<td style="text-align: center;" id="itemPrice<?php echo $item->ddc_shoppingcart_detail_id; ?>"><?php echo number_format($item->product_price,2); ?></td>
		<td style="text-align: center;"><input name="jform[product_quantity]" id="itemQty<?php echo $item->ddc_shoppingcart_detail_id; ?>" type="number" style="width:50px;" min="<?php echo $this->model->getpartjsonfield($item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($item->product_params,'step_order_level'); ?>" value="<?php echo $item->product_quantity; ?>" onchange="updateCartItem(<?php echo $item->ddc_shoppingcart_detail_id; ?>)" /></td>
		<td style="text-align: center;"><?php echo $item->discount; ?></td>
		<td style="text-align: center;" id="itemTotal<?php echo $item->ddc_shoppingcart_detail_id; ?>"><?php echo number_format($item->product_price*$item->product_quantity,2); ?></td>
		<td><i style="color:#880000" class="glyphicon glyphicon-remove" onclick="removeCartItem(<?php echo $item->ddc_shoppingcart_detail_id; ?>)"></i></td>
	</tr>
	<?php $products_total += $item->product_price*$item->product_quantity; ?>
	<?php endforeach; ?>
	<tr style="font-weight: bold">
		<td colspan="4" style="text-align: right;"><?php echo JText::_('COM_DDC_PRODUCT_TOTALS')?></td>
		<td></td>
		<td id="products_total" style="text-align: center;"><?php echo number_format($products_total,2); ?></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" style="text-align: left;">
			<?php echo JText::_('COM_DDC_SHIPPING_METHOD')?><br>
			
				<input type="radio" id="shipping_method" name="jform[shipping_method]" value="std" checked /><?php echo JText::_('COM_DDC_STANDARD'); ?>
				<input type="hidden" name="jform[delivery_price]" value="3.00" />
				<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->items[0]->ddc_shoppingcart_header_id?>" />
				<input type="hidden" name="jform[table]" value="ddcCheckout" />
				<input type="hidden" name="jform[state]" value="2" />
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="tmpl" value="component" />

		</td>
		<td></td>
		<td style="text-align: center;" id="ship_price"><?php echo number_format(3,2); ?></td>
	</tr>
		<tr style="font-weight: bold">
		<td colspan="4" style="text-align: center;">
			<?php echo JText::_('COM_DDC_TOTAL')?>
		</td>
		<td></td>
		<td style="text-align: center;"><?php echo $this->items[0]->currency_symbol." "; ?><span id="subtotal"></span></td>
	</tr>

</tbody>
</table>
</form>
<input class="btn btn-primary pull-right <?php if($this->items[0]->header_state > 1){ echo 'hide'; }?>" id="processPayment1" name="processPayment" type="button" value="Continue" onclick="checkPayment(1)" />
<form id="deliveryInfo" <?php if($this->items[0]->header_state < 2){ echo 'class="hide"';}?> method="post">
	<table class="table col-md-8">
		<thead>
			<tr>
				<th colspan="2"><h2><?php echo JText::_('COM_DDC_DELIVERY_INFORMATION'); ?></h2></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo JText::_('COM_DDC_DELIVER_TO'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[first_name]" type="text" placeholder="First Name*" value="<?php echo $this->items[0]->first_name ?>" required />
					<input class="form-control" name="jform[last_name]" type="text" placeholder="Last Name*" value="<?php echo $this->items[0]->last_name ?>" required />
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_ADDRESS'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[address_line_1]" type="text" placeholder="Address line 1*" value="<?php echo $this->items[0]->address_line_1 ?>" required />
					<input class="form-control" name="jform[address_line_2]" type="text" placeholder="Address line 2" value="<?php echo $this->items[0]->address_line_2 ?>" required />
					<input class="form-control" name="jform[town]" type="text" placeholder="Town / City*" value="<?php echo $this->items[0]->town ?>" />
					<input class="form-control" name="jform[county]" type="text" placeholder="County*" value="<?php echo $this->items[0]->county ?>" />
					<input class="form-control" name="jform[post_code]" type="text" placeholder="Post Code*" value="<?php echo $this->items[0]->post_code ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_TELEPHONE'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[mobile_no]" type="text" placeholder="Mobile" value="<?php echo $this->items[0]->mobile_no ?>" />
					<input class="form-control" name="jform[telephone_no]" type="text" placeholder="Land Line" value="<?php echo $this->items[0]->telephone_no ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_EMAIL_TO'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[email_to]" type="text" placeholder="E-mail Address*" value="<?php echo $this->items[0]->email_to ?>" /></td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('COM_DDC_PAYMENT_METHOD')?><br>

					<input type="radio" id="payment_method" name="jform[payment_method]" value="<?php echo $params->get('paymentmethod_id')?>" checked /><?php echo JText::_('COM_DDC_PAYPAL'); ?>
					<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->items[0]->ddc_shoppingcart_header_id?>" />
					<input type="hidden" name="jform[state]" value="3" />
					<input type="hidden" name="jform[table]" value="ddcCheckout" />
					<input type="hidden" name="controller" value="update" />
					<input type="hidden" name="option" value="com_ddcshopbox" />
				</td>
				<td><b><?php echo $this->items[0]->currency_symbol." "; ?><span id="subtotal2"></span></b></td>
			</tr>
		</tbody>
	</table>
	<button class="btn btn-primary pull-right" type="submit"><?php echo JText::_('COM_DDC_CONTINUE_TO_PAYPAL'); ?></button>
</form>

<?php 
$paypal = new DdcshopboxModelsDdcpaypal();
if($this->items[0]->header_state==3)
{
	if($app->input->get('paypalsuccess',null)==="true")
	{
		$paypal->makePaypalPayment();
	}
}
?>

<?php echo $this->_customloginShopboxView->render(); ?>
