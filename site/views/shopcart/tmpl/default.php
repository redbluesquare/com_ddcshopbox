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
		<th><?php echo JText::_('COM_DDC_PRODUCT_PRICE'); ?></th>
		<th><?php echo JText::_('COM_DDC_QUANTITY'); ?></th>
		<th><?php echo JText::_('COM_DDC_TAX'); ?></th>
		<th><?php echo JText::_('COM_DDC_DISCOUNT'); ?></th>
		<th style="text-align: center;"><?php echo JText::_('COM_DDC_TOTAL'); ?></th>
	</tr>
</thead>
<tbody>
	
	<?php foreach($this->items as $item):?>
	<tr>
		<td><?php echo $item->product_name; ?></td>
		<td><?php echo $item->product_sku; ?></td>
		<td style="text-align: center;"><?php echo number_format($item->product_price,2); ?></td>
		<td style="text-align: center;"><?php echo $item->product_quantity; ?></td>
		<td><?php //echo $item['product_name']; ?></td>
		<td><?php //echo $item['product_name']; ?></td>
		<td style="text-align: right;"><?php echo number_format($item->product_price*$item->product_quantity,2); ?></td>
	</tr>
	<?php $products_total += $item->product_price*$item->product_quantity; ?>
	<?php endforeach; ?>
	<tr style="font-weight: bold">
		<td colspan="4" style="text-align: right;"><?php echo JText::_('COM_DDC_PRODUCT_TOTALS')?></td>
		<td></td>
		<td></td>
		<td id="products_total" style="text-align: right;"><?php echo number_format($products_total,2); ?></td>
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
		<td></td>
		<td style="text-align: right;" id="ship_price"><?php echo number_format(3,2); ?></td>
	</tr>
		<tr style="font-weight: bold">
		<td colspan="4" style="text-align: right;">
			<?php echo JText::_('COM_DDC_TOTAL')?>
		</td>
		<td></td>
		<td></td>
		<td id="subtotal" style="text-align: right;"></td>
	</tr>

</tbody>
</table>
</form>
<input class="btn btn-primary" id="processPayment1" name="processPayment" type="button" value="Continue" onclick="checkPayment(1)" />
<form id="deliveryInfo" class="hide" method="post">
	<table class="table">
		<thead>
			<tr>
				<th colspan="2"><h2><?php echo JText::_('COM_DDC_DELIVERY_INFORMATION'); ?></h2></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo JText::_('COM_DDC_ADDRESS'); ?></td>
				<td>
					<?php echo $this->profile->address ?><br>
					<?php echo $this->profile->suburb ?><br>
					<?php echo $this->profile->state ?><br>
					<?php echo $this->profile->postcode ?><br>
					
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_TELEPHONE'); ?></td>
				<td><?php echo $this->profile->mobile ?><br>
					<?php echo $this->profile->telephone ?>
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_DDC_EMAIL_TO'); ?></td>
				<td><?php echo $this->profile->email_to ?></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php echo JText::_('COM_DDC_PAYMENT_METHOD')?><br>

					<input type="radio" id="payment_method" name="jform[payment_method]" value="<?php echo $params->get('paymentmethod_id')?>" checked /><?php echo JText::_('COM_DDC_PAYPAL'); ?>
					<input type="hidden" name="jform[ddc_shoppingcart_header_id]" value="<?php echo $this->items[0]->ddc_shoppingcart_header_id?>" />
					<input type="hidden" name="jform[state]" value="3" />
					<input type="hidden" name="jform[table]" value="ddcCheckout" />
					<input type="hidden" name="controller" value="update" />
					<input type="hidden" name="option" value="com_ddcshopbox" />
					<input type="hidden" name="format" value="raw" />
					<input type="hidden" name="tmpl" value="component" />
				</td>
			</tr>
		</tbody>
	</table>
	<button class="btn btn-primary" type="submit"><?php echo JText::_('COM_DDC_CONTINUE_TO_PAYPAL'); ?></button>
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
