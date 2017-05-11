<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php 
//load Stripe model
$ddcstripe = new DdcshopboxModelsDdcstripe();
$customer = $ddcstripe->getStripeCustomer(2);
$cards = 0;
if(count($customer)>0)
{
	$cards = 1;
}
?>
<div class="row-fluid">
	<div class="col-xs-8">
		<h3><?php echo $this->profile->first_name." ".$this->profile->last_name; ?></h3>
		<p></p>
		<h2>Purchase history</h2>
		<p>We will be adding all your purchase history here soon :-) </p>
		<p>. </p>
		<p>. </p>
		<p>. </p>
		<p>. </p>
		<p>. </p>
	</div>
	<div class="col-xs-4">
		<div class="col-xs-12" style="margin-bottom:5px;">
			<button type="button" role="button" data-toggle="modal" class="btn pull-right" data-target="#profileaddressModal"><i class="icon icon-user"></i> <?php echo JText::_('COM_DDC_UPDATE_ADDRESS'); ?></button>
		</div>
		<?php if(count($customer)!=0): ?>
		<div class="col-xs-12">
			<button class="btn pull-right" onclick="showCardDetails"><?php echo JText::_('COM_DDC_CARD_DETAILS')?></button>
		</div>
		<div class="cardDetails hide" style="padding:10px;font-size:0.8em;border: 1px solid #eee;border-radius:20px;" class="col-xs-12 <?php if(count($customer)==0):?>hide<?php endif; ?>">
		<table>
			<tbody>
				<tr>
					<td style="padding-right:10px;color:#aaa;text-align:right;">Card Type</td>
					<td><?php echo $customer->sources->data[0]->brand.' '.$customer->sources->data[0]->funding.' '.$customer->sources->data[0]->object; ?></td>
				</tr>
				<tr>
					<td style="padding-right:10px;color:#aaa;text-align:right;">Expiry</td>
					<td><?php echo $customer->sources->data[0]->exp_month.' / '.$customer->sources->data[0]->exp_year;?></td>
				</tr>
				<tr>
					<td style="padding-right:10px;color:#aaa;text-align:right;">Card Ending</td>
					<td><?php echo "... ".$customer->sources->data[0]->last4; ?></td>
				</tr>
			</tbody>
		</table>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php $this->_profileAddressView->form = $this->form; ?>
<?php echo $this->_profileAddressView->render(); ?>