<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');

?>
<div class="row">
	<div class="col-xs-12" style="margin-bottom: 10px;/*background:url(images/red-christmas-balls.jpg); background-opacity: 0.5;background-size: 100% 150%;background-repeat: no-repeat;*/">
		<h2>Be part of something special this Christmas</h2>
		<p><b>Support</b> your community and receive a <b>quality service</b> that is second to none. You get to shop from all your favourite independent shops in local community and your orders are pack, collected and delivered to you all at once.</p>
		<p>This is a dream I have had for a number of months and with the support of our the local community, this is now becoming reality! Now, <u style="text-decoration:underline">I need your support</u>, if you live in <b>Chalfont St Peter</b>, <b>Chalfont St Giles</b> or <b>Gerrards Cross</b>, please show your support by registering your interest today!</p>
		<h2>How much does it cost?</h2>
		<p>It will cost FREE.99 to register and use. No subscription! No Sign Up fees! Just <b>Free!</b> We will also be giving the first 100 registrants &pound;5.00 off their first order and free delivery on orders over &pound;40.</p>
		<h2>Why?</h2>
		<p>Our community matters and whilst the world as we know it is rapidly changing and the internet is rapidly consuming all aspects of our lives, we still need to keep our sense of a community spirit and community culture. We may be communicating through our phones, tablets or fridge-freezers (yes, they connected to the internet as well), it is the humans at the heart of it all. I see this as my way of helping not only my community but any community stay connected, supporting each other and contributing towards a sustainable future for our children.</p>
	</div>
</div>
<div id="getInterest" class="row" style="display:none;">
	<h3><?php echo JText::_('COM_DDC_WANT_TO_KEEP_UPDATED');?></h3>
	<form class="form-horizontal">
		<?php foreach($this->form->getFieldset('get_interest') as $field): ?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
			<div class="form-group">
				<div class="col-xs-4">
				<?php echo $field->label; ?>
				<?php if (!$field->required && $field->type != 'Spacer') : ?>
					<span><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
				<?php endif; ?>
				</div>
				<div class="col-xs-6">
					<?php echo $field->input;?>
				</div>
			</div>
			<?php endif;?>
		<?php endforeach; ?>
	</form>
	<button class="btn btn-primary pull-right" id="submitIntBtn"><?php echo JText::_('COM_DDC_CTA_BTN2'); ?></button>
</div>
<button class="btn btn-primary" id="GetIntBtn"><?php echo JText::_('COM_DDC_CTA_BTN1'); ?></button>





<hr>
<div class="row">
	<div class="col-xs-12" style="margin-bottom: 10px;">
		<h2 style="text-align: center"><?php echo JText::_('COM_DDC_HOW_IT_WORKS'); ?></h2>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row introWIW">
	<div class="col-xs-4">
		<span style="display:block;margin-left:auto;margin-right:auto;align-items: center;" class="col-xs-12">
			<img alt="" style="display:block;margin-left:10%;margin-right:10%;" src="images\kaizermart_store_laptop.png" class="col-xs-10" />
		</span>
		<p>You order your goods on KaizerMart.co.uk</p>
	</div>
	<div class="col-xs-4">
		<img alt="" src="images\shops_together.png" class="col-xs-12"/>
		<p>Each local shop packs it's part of your order</p>
	</div>
	<div class="col-xs-4">
		<span style="display:block;margin-left:auto;margin-right:auto;align-items: center;" class="col-xs-12">
			<img alt="" style="display:block;margin-left:20%;margin-right:20%;" src="images\deliveryvan-image.png" class="col-xs-7"/>
		</span>
		<p>Your order is collected and delivered to you all at once</p>
	</div>
	<div class="clearfix"></div>
</div>
<hr>


