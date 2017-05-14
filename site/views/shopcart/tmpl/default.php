<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
//check if shopping cart is published
if(isset($this->items[0])):
$products_total = null;
$params = JComponentHelper::getParams('com_ddcshopbox');
$app = JFactory::getApplication();
$date = date('w');
if($date == 3)
{
	$leadtime = 60*60*24*4;
	$today = strtotime('today');
}
else 
{
	$leadtime = 60*60*24*3;
	$today = strtotime('today');
}
$del_date = Date('D. d M. Y',$leadtime+$today);
$del_date_form = Date('Y-m-d',$leadtime+$today);
$pmModel = new DdcshopboxModelsPaymentmethods();
$this->pmethod = $pmModel->getItem(2);
if($this->model->getpartjsonfield($this->pmethod->payment_params, 'paymentmethod_mode')=='live')
{
	$api_key = 'api_key';
}
else
{
	$api_key = 'test_api_key';
}
?>

<h1><?php echo JText::_('COM_DDC_SHOPPING_CART'); ?></h1>
<form id="ddcshopcart">
<table class="table">
<thead>
	<tr>
		<th><?php echo JText::_('COM_DDC_PRODUCT_NAME'); ?></th>
		<th><?php echo JText::_('COM_DDC_PRODUCT_SKU'); ?></th>
		<th style="text-align:center;"><?php echo JText::_('COM_DDC_PRODUCT_PRICE'); ?></th>
		<th style="text-align:center;"><?php echo JText::_('COM_DDC_QUANTITY'); ?></th>
		<th style="text-align:center;"><?php echo JText::_('COM_DDC_DISCOUNT'); ?></th>
		<th style="text-align:center;"><?php echo JText::_('COM_DDC_TOTAL'); ?></th>
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
		<td style="text-align: center;" id="itemPrice<?php echo $item->ddc_shoppingcart_detail_id; ?>"><input type="hidden" name="jform[product_price]" value="<?php echo number_format($this->model->getPriceItem($item->product_price,$this->model->getpartjsonfield($item->product_params,'price_weight_based'),$item->product_weight,$item->product_weight_uom),2); ?>" /><?php echo number_format($this->model->getPriceItem($item->product_price,$this->model->getpartjsonfield($item->product_params,'price_weight_based'),$item->product_weight,$item->product_weight_uom),2); ?></td>
		<td style="text-align: center;"><input name="jform[product_quantity]" id="itemQty<?php echo $item->ddc_shoppingcart_detail_id; ?>" type="number" style="width:50px;" min="<?php echo $this->model->getpartjsonfield($item->product_params,'min_order_level'); ?>" max="<?php echo $this->model->getpartjsonfield($item->product_params,'max_order_level'); ?>" step="<?php echo $this->model->getpartjsonfield($item->product_params,'step_order_level'); ?>" value="<?php echo $item->product_quantity; ?>" onchange="updateCartItem(<?php echo $item->ddc_shoppingcart_detail_id; ?>)" /></td>
		<td style="text-align: center;"><?php echo $item->discount; ?></td>
		<td style="text-align: center;" id="itemTotal<?php echo $item->ddc_shoppingcart_detail_id; ?>"><?php echo number_format(($this->model->getPriceItem($item->product_price,$this->model->getpartjsonfield($item->product_params,'price_weight_based'),$item->product_weight,$item->product_weight_uom)*$item->product_quantity),2); ?></td>
		<td><i style="color:#880000" class="glyphicon glyphicon-remove removeCartItem" onclick="removeCartItem(<?php echo $item->ddc_shoppingcart_detail_id; ?>)"></i></td>
	</tr>
	<?php $products_total += $this->model->getPriceItem($item->product_price,$this->model->getpartjsonfield($item->product_params,'price_weight_based'),$item->product_weight,$item->product_weight_uom)*$item->product_quantity; ?>
	<?php endforeach; ?>
	<tr style="font-weight: bold">
		<td colspan="4" style="text-align: right;"><?php echo JText::_('COM_DDC_PRODUCT_TOTALS')?></td>
		<td></td>
		<td id="products_total" style="text-align: center;"><?php echo number_format($products_total,2); ?></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="1" style="text-align: left;">
			<?php echo JText::_('COM_DDC_SHIPPING_METHOD')?><br>
			
				<input type="radio" id="shipping_method" name="jform[shipping_method]" value="1" checked /> <?php echo JText::_('COM_DDC_STANDARD'); ?>
				<input type="hidden" id="jform_delivery_price" name="jform[delivery_price]" value="4.00" />
				<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->session->get('shoppingcart_header_id',null); ?>" />
				<input type="hidden" name="jform[table]" value="ddcCheckout" />
				<input type="hidden" name="jform[state]" value="2" />
				<input type="hidden" id="jform_free_del_stop" name="jform[free_del_stop]" value="<?php echo $params->get('free_del_stop'); ?>"> 
				<input type="hidden" name="controller" value="update" />
				<input type="hidden" name="option" value="com_ddcshopbox" />
				<input type="hidden" name="format" value="raw" />
				<input type="hidden" name="tmpl" value="component" />
				<input type="hidden" id="coupon_value" name="jform[coupon_value]" value="<?php echo $item->coupon_value; ?>" />
				<input type="hidden" name="jform[delivery_date]" value="<?php echo $del_date_form;?>" />
				<input type="hidden" name="jform[delivery_time]" value="12:00:00" />

		</td>
		<td colspan="4">
			<?php 
				echo JText::_('COM_DDC_DELIVERY')." ";
				echo $del_date;
			?>
		</td>
		<td style="text-align: center;" id="ship_price"><?php echo number_format(4,2); ?></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="3">
			<span id="coupon_code_info">
			<?php if($item->coupon_value==null):?>
			<input class="form-control" style="width:70%;margin-right:5px;display:inline;" type="text" name="jform[coupon_code]" id="jform_coupon_code" placeholder="<?php echo JText::_('COM_DDC_COUPON_CODE'); ?>" />
			<input type="button" class="btn" id="addCouponbtn" value="Update" onclick="addCoupon()" />
			<?php else: ?>
				<p><?php echo $item->coupon_code; ?></p>
			<?php endif; ?>
			</span>
		</td>
		<td style="text-align: right;">
			<?php echo JText::_('COM_DDC_DISCOUNT')?>
		</td>
		<td></td>
		<td style="text-align: center;">
			<span id="discountValue">
				<?php 
				$item->coupon_value = $item->coupon_value ? number_format($item->coupon_value,2) : number_format(0,2);
				if($item->coupon_value<=($products_total+4))
				{
					echo $item->coupon_value;
				}
				else 
				{
					echo number_format($products_total+4,2);
				}
				 ?>
			</span>
		</td>
		<td></td>
	</tr>
	<tr style="font-weight: bold">
		<td colspan="3">
			<span id="shopcart_status_msg"></span>
		</td>
		<td style="text-align: right;">
			<?php echo JText::_('COM_DDC_TOTAL')?>
		</td>
		<td></td>
		<td style="text-align: center;"><?php echo $params->get('default_currency')." "; ?><span id="subtotal"></span></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="7"><?php echo $params->get('delivery_info'); ?></td>
	</tr>
</tbody>
</table>
</form>
<input class="btn btn-primary pull-right <?php if(isset($this->items[0]) and ($this->items[0]->header_state > 1)){ echo 'hide'; }?>" id="processPayment1" name="processPayment" type="button" value="Continue" onclick="checkPayment(1)" />
<form id="deliveryInfo" <?php if($this->items[0]->header_state < 2){ echo ' class="hide"';}?> method="post">
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
					<input class="form-control" name="jform[first_name]" type="text" placeholder="First Name*" value="<?php if($this->items[0]->first_name==null): echo $this->profile->first_name; else: echo $this->items[0]->first_name; endif; ?>" required />
					<input class="form-control" name="jform[last_name]" type="text" placeholder="Last Name*" value="<?php if($this->items[0]->last_name==null): echo $this->profile->last_name; else: echo $this->items[0]->last_name; endif; ?>" required />
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_ADDRESS'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[address_line_1]" type="text" placeholder="Address line 1*" value="<?php if($this->items[0]->address_line_1==null): echo $this->profile->address_1; else: echo $this->items[0]->address_line_1; endif; ?>" required />
					<input class="form-control" name="jform[address_line_2]" type="text" placeholder="Address line 2" value="<?php echo $this->items[0]->address_line_2 ?>" />
					<input class="form-control" name="jform[town]" type="text" placeholder="Town / City*" value="<?php if($this->items[0]->town==null): echo $this->profile->city; else: echo $this->items[0]->town; endif; ?>" />
					<input class="form-control" name="jform[county]" type="text" placeholder="County*" value="<?php if($this->items[0]->county==null): echo $this->profile->county; else: echo $this->items[0]->county; endif; ?>" />
					<input class="form-control" name="jform[post_code]" type="text" placeholder="Post Code*" value="<?php if($this->items[0]->post_code==null): echo $this->session->get('ddclocation', null); else: echo $this->items[0]->post_code; endif; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_TELEPHONE'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[mobile_no]" type="text" placeholder="Mobile*" value="<?php if($this->items[0]->mobile_no==null){echo $this->profile->phone_2;}else{echo $this->items[0]->mobile_no;} ?>" />
					<input class="form-control" name="jform[telephone_no]" type="text" placeholder="Land Line" value="<?php echo $this->items[0]->telephone_no ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_EMAIL_TO'); ?></td>
				<td class="small-input-margin">
					<input class="form-control" name="jform[email_to]" type="text" id="jform_email_to" placeholder="E-mail Address*" value="<?php if($this->items[0]->email_to==null): echo $this->profile->email; else: echo $this->items[0]->email_to; endif; ?>" required="true" validate="email" /></td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_COMMENT'); ?></td>
				<td class="small-input-margin">
					<textarea class="form-control" name="jform[comment]" type="textarea" placeholder="<?php echo JText::_('COM_DDC_PLEASE_ADD_INSTRUCTIONS');?>" rows="5" cols="20" ><?php echo $this->items[0]->comment; ?></textarea></td>
			</tr>
			<tr>
				<td class="payMethods">
					<?php echo JText::_('COM_DDC_PAYMENT_METHOD')?><br>

					<input type="hidden" name="jform[payment_method]" value="<?php echo $params->get('paymentmethod_id')?>" />
					<input type="radio" name="jform[payment_method]" value="2" checked /> <?php echo JText::_('COM_DDC_CARD'); ?>
					<div class="stripeCard">
						<span id="stripePayWith">
						<input type="radio" name="jform[change_card]" id="jform_change_card_1" value="1" checked /> <?php echo JText::_('COM_DDC_PAY_WITH')?> <b><span id="stripeBrand"></span> <span id="stripeExpire"></span> <span id="stripeLast4"></span></b><br></span>
						<input type="radio" name="jform[change_card]" id="jform_change_card_0" value="0" /> <?php echo JText::_('COM_DDC_CHANGE_CARD')?>
						
					</div>
					<input type="hidden" name="jform[ddc_shoppingcart_header_id]" id="jform_ddc_shoppingcart_header_id" value="<?php echo $this->items[0]->ddc_shoppingcart_header_id?>" />
					<input type="hidden" id="jform_delivery_price2" name="jform[delivery_price]" value="4.00" />
					<input type="hidden" name="jform[state]" value="3" />
					<input type="hidden" name="jform[table]" value="ddcCheckout" />
					<input type="hidden" name="controller" value="update" />
					<input type="hidden" name="option" value="com_ddcshopbox" />
				</td>
				<td style="text-align:right;padding-right:50px;"><b><?php echo $this->items[0]->currency_symbol." "; ?><span id="subtotal2"></span></b></td>
			</tr>
		</tbody>
	</table>
	<?php if($app->input->get('paypalsuccess',null)!="true"):?>
		<span id="payBtn">
			<button id="paypal_payment" class="btn btn-primary pull-right hide" type="submit"><?php echo JText::_('COM_DDC_PAY'); ?></button>
		</span>
		<script src="https://checkout.stripe.com/checkout.js"></script>

		<input name="jform[stripeCusToken]" id="jform_stripeCustToken" value="false" type="hidden" />
		<input name="jform[stripeApiToken]" id="jform_stripeApiToken" value="<?php echo $this->model->getpartjsonfield($this->pmethod->payment_params, $api_key); ?>" type="hidden" />
		<input name="jform[stripeToken]" id="jform_stripeToken" value="" type="hidden" />
	<?php endif; ?>
	<button id="cardPaymentbtn" class="btn btn-primary pull-right"><?php echo JText::_('COM_DDC_PAY'); ?></button>
</form>

<script>
var handler = StripeCheckout.configure({
	  key: jQuery('#jform_stripeApiToken').val(),
	  image: 'https://ushbub.co.uk/images/headers/logo_ushbub.png',
	  locale: 'auto',
	  token: function(token) {
			jQuery('#jform_stripeToken').val(token.id);
			submitDel();
		  
	  }
});
checkCardPmnt();
</script>

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

<?php 
//end of check if shopping cart is published
else:
?>
<p><?php echo JText::_('COM_DDC_SHOPPINGCART_EMPTY'); ?></p>
<?php
endif; 
?>

<?php echo $this->_customloginShopboxView->render(); ?>
