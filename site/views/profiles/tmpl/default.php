<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="row-fluid">
	<div class="col-xs-9">
		<h3><?php echo $this->profile->first_name." ".$this->profile->last_name; ?></h3>
		<p></p>
		<h3><?php echo JText::_('COM_DDC_CARD_DETAILS')?></h3>
		<?php 
		//load Stripe model
		$ddcstripe = new DdcshopboxModelsDdcstripe();
		$customer = $ddcstripe->getStripeCustomer(2);
		?>
		<div style="padding:10px;font-size:0.8em;border: 1px solid #eee;border-radius:20px;" class="col-xs-12 hide">
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
	</div>
	<div class="col-xs-3">
		<button type="button" role="button" data-toggle="modal" class="btn pull-right" data-target="#profileaddressModal"><i class="icon icon-user"></i> <?php echo JText::_('COM_DDC_UPDATE_PROFILE'); ?></button>
	</div>
</div>
<?php $this->_profileAddressView->form = $this->form; ?>
<?php echo $this->_profileAddressView->render(); ?>