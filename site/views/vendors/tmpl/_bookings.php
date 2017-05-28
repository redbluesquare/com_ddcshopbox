<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$this->session = JFactory::getSession();
$params = JComponentHelper::getParams('com_ddcshopbox');
$productModel = new DdcshopboxModelsVendorproducts();
$products = $productModel->listItems();
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
$today = date('D');
?>
<form class="form-group" id="newBookingService">
<div class="productServices">
	<div class="row">
	<?php 
	foreach ($products as $product)
	{
		if($product->product_type==4)
		{
			?>
			<div class="productItemBox pull-left" id="productItemBox<?php echo $product->ddc_vendor_product_id; ?>" onclick="clickMe(<?php echo $product->ddc_vendor_product_id; ?>)">
				<p id="serviceName<?php echo $product->ddc_vendor_product_id; ?>"><?php echo $product->vendor_product_name;?></p>
				<p id="priceName<?php echo $product->ddc_vendor_product_id; ?>"><?php echo $product->currency_symbol.' '.number_format($product->product_price,2);?></p>
			</div>
			<?php
		}
	}
	?>
	</div>
</div>
<div class="servicesPane daysBox hide">
	<div id="<?php echo lcfirst($today);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($today)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($today);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($today)).'_open');?>)">
		<p><?php echo $today; ?></p>
		<span id="<?php echo $today; ?>dateNm" class="hide"><?php echo date('d m Y',strtotime($today)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($today)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
	<?php 
	$nextDay = date('D',strtotime('+1 day',strtotime($today)));
	?>
	<div id="<?php echo lcfirst($nextDay);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($nextDay);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open');?>)">
		<p><?php echo $nextDay; ?></p>
		<span id="<?php echo $nextDay; ?>dateNm" class="hide"><?php echo date('d m Y', strtotime($nextDay)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
	<?php 
	$nextDay = date('D',strtotime('+1 day',strtotime($nextDay)));
	?>
	<div id="<?php echo lcfirst($nextDay);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($nextDay);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open');?>)">
		<p><?php echo $nextDay; ?></p>
		<span id="<?php echo $nextDay; ?>dateNm" class="hide"><?php echo date('d m Y', strtotime($nextDay)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
	<?php 
	$nextDay = date('D',strtotime('+1 day',strtotime($nextDay)));
	?>
	<div id="<?php echo lcfirst($nextDay);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($nextDay);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open');?>)">
		<p><?php echo $nextDay; ?></p>
		<span id="<?php echo $nextDay; ?>dateNm" class="hide"><?php echo date('d m Y', strtotime($nextDay)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
	<?php 
	$nextDay = date('D',strtotime('+1 day',strtotime($nextDay)));
	?>
	<div id="<?php echo lcfirst($nextDay);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($nextDay);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open');?>)">
		<p><?php echo $nextDay; ?></p>
		<span id="<?php echo $nextDay?>dateNm" class="hide"><?php echo date('d m Y', strtotime($nextDay)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
	<?php 
	$nextDay = date('D',strtotime('+1 day',strtotime($nextDay)));
	?>
	<div id="<?php echo lcfirst($nextDay);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($nextDay);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open');?>)">
		<p><?php echo $nextDay?></p>
		<span id="<?php echo $nextDay?>dateNm" class="hide"><?php echo date('d m Y', strtotime($nextDay)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
	<?php 
	$nextDay = date('D',strtotime('+1 day',strtotime($nextDay)));
	?>
	<div id="<?php echo lcfirst($nextDay);?>Date" class="<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo 'shopClosed';}?>" onclick="Dayclick('<?php echo lcfirst($nextDay);?>',<?php echo $this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open');?>)">
		<p><?php echo $nextDay?></p>
		<span id="<?php echo $nextDay?>dateNm" class="hide"><?php echo date('d m Y', strtotime($nextDay)); ?></span>
		<?php if($this->model->getpartjsonfield($this->item->vendor_details,'day_'.date('w',strtotime($nextDay)).'_open')==0){echo '<p>Closed</p>';}?>
	</div>
</div>
<div class="servicesPane earlyLateBox hide">
	<div id="amCheck" onclick="elclick('am')">
		<p>AM</p>
	</div>
	<div id="pmCheck" onclick="elclick('pm')">
		<p>PM</p>
	</div>
</div>
<div class="servicesPane amBox hide">
	<div id="08time" class="" onclick="addTime('08',0)">
		<p>08:00</p>
	</div>
	<div id="09time" class="" onclick="addTime('09',0)">
		<p>09:00</p>
	</div>
	<div id="10time" class="" onclick="addTime('10',0)">
		<p>10:00</p>
	</div>
	<div id="11time" class="" onclick="addTime('11',0)">
		<p>11:00</p>
	</div>
</div>
<div class="servicesPane pmBox hide">
	<div id="12time" class="" onclick="addTime('12',0)">
		<p>12:00</p>
	</div>
	<div id="13time" class="" onclick="addTime('13',0)">
		<p>13:00</p>
	</div>
	<div id="14time" class="" onclick="addTime('14',0)">
		<p>14:00</p>
	</div>
	<div id="15time" class="" onclick="addTime('15',0)">
		<p>15:00</p>
	</div>
	<div id="16time" class="" onclick="addTime('16',0)">
		<p>16:00</p>
	</div>
</div>
<div class="summaryBox hide">
	<h3><?php echo JText::_('COM_DDC_BOOKING_SUMMARY')?></h3>
	<div class="col-xs-6">
		<p class="col-xs-12"><span class="pull-left" style="padding-top:7px;"><?php echo JText::_('COM_DDC_FIRST_NAME_LABEL').": "; ?></span><span class="col-xs-9 pull-right"><input name="jform[first_name]" id="jform_first_name" value="" class="form-control" /></span></p>
		<p class="col-xs-12"><span class="pull-left" style="padding-top:7px;"><?php echo JText::_('COM_DDC_LAST_NAME_LABEL').": "; ?></span><span class="col-xs-9 pull-right"><input name="jform[last_name]" id="jform_last_name" value="" class="form-control" /></span></p>
		<p class="col-xs-12"><span class="pull-left" style="padding-top:7px;"><?php echo JText::_('COM_DDC_EMAIL_TO_LABEL').": "; ?></span><span class="col-xs-9 pull-right"><input name="jform[email_to]" id="jform_email_to" value="" class="form-control" /></span></p>
		<p class="col-xs-12"><span class="pull-left" style="padding-top:7px;"><?php echo JText::_('COM_DDC_MOBILE_NUMBER_LABEL').": "; ?></span><span class="col-xs-9 pull-right"><input name="jform[mobile]" id="jform_mobile" value="" class="form-control" /></span></p>
		<p class="col-xs-12"><select class="form-control pull-right col-xs-9" name="jform[payment_method]" id="jform_payment_method">
			<option value="2"><?php echo JText::_('COM_DDC_PAY_BY_CARD'); ?></option>
			<option value="0"><?php echo JText::_('COM_DDC_PAY_BY_CASH'); ?></option>
		</select>
		</p>
		<p style="margin-bottom:5px;" class="col-xs-12"><?php echo JText::_('COM_DDC_SERVICE').": "; ?><span id="serviceName"></span></p>
		<p style="margin-bottom:5px;" class="col-xs-12"><?php echo JText::_('COM_DDC_PRICE').": "; ?><span id="priceName"></span></p>
		<p style="margin-bottom:5px;" class="col-xs-12"><?php echo JText::_('COM_DDC_DATE').": "; ?><span id="dayName"></span> <span id="dateName"></span></p>
		<p style="margin-bottom:5px;" class="col-xs-12"><?php echo JText::_('COM_DDC_TIME').": "; ?><span id="timeName"></span></p>
		<p>
		<input class="form-control" name="jform[vendorid]" id="vendorid" type="hidden" value="<?php echo $products[0]->vendor_id;?>" />
		<input class="form-control" name="jform[ddc_service_id]" id="ddc_service_id" type="hidden" value="" />
		<input class="form-control" name="jform[ddc_day_id]" id="ddc_day_id" type="hidden" value="" />
		<input class="form-control" name="jform[ddc_el_id]" id="ddc_el_id" type="hidden" value="" />
		<input class="form-control" name="jform[ddc_el2_id]" id="ddc_el2_id" type="hidden" value="" /></p>
		<input name="jform[stripeCusToken]" id="jform_stripeCustToken" value="false" type="hidden" />
		<input name="jform[ddc_service_header_id]" value="" type="hidden" />
		<input name="jform[stripeApiToken]" id="jform_stripeApiToken" value="<?php echo $this->model->getpartjsonfield($this->pmethod->payment_params, $api_key); ?>" type="hidden" />
		<input name="jform[stripeToken]" id="jform_stripeToken" value="" type="hidden" />
		<p class="col-xs-12"><input name="mySubmit" id="submitBooking" onclick="bookAndPay()" class="btn btn-success pull-right" value="Book Now" /></p>
	</div>
	<div class="col-xs-6">
		<p>Please fill out your e-mail and mobile number so we can contact you should any changes occur. Your card details are taken but no payment will be taken until the service has completed.</p>
		<p>If you require to change your appointment or cancel it for any reason, it is no problem, please just get in contact with us.</p>
	</div>
</div>
</form>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
var handler = StripeCheckout.configure({
	  key: jQuery('#jform_stripeApiToken').val(),
	  image: 'https://ushbub.co.uk/images/headers/logo_ushbub.png',
	  locale: 'auto',
	  token: function(token) {
			jQuery('#jform_stripeToken').val(token.id);
			submitBooking();	  
	  }
});
</script>