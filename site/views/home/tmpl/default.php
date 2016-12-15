<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');

?>
<div class="hero">
<div class="row">
<div class="col-xs-3 img-circle" style="margin-top:90px;background:#efefef;height:98px;">
<img alt="" src="images\shop-icon.png" class="col-xs-12" style="position:relative;bottom:80px;">
</div>
<div class="col-xs-9" style="text-align: center;">
	<span id="IntroText1"><?php echo JText::_('Imagine...');?></span><br>
	<span id="IntroText2"><?php echo JText::_('a marketplace');?></span><br>
	<span id="IntroText3"><?php echo JText::_('selling quality foods and goods');?></span><br>
	<span id="IntroText4"><?php echo JText::_('and heliping the local community grow.');?></span><br>
	<span id="IntroText5"><?php echo JText::_('A marketplace that is open to all...');?></span><br>
	<span id="IntroText6"><?php echo JText::_('Kaizer Mart');?></span>
</div>
<div class="clearfix"></div>
</div>
<form id="postcodeForm" method="post" class="col-xs-12">
<input type="text"  name="ddclocation" id="mypostcode" placeholder="<?php echo JText::_('COM_DDC_ENTER_POSTCODE'); ?>"/>
<input type="submit" id="mypostcodebtn" name="submit" value="<?php echo JText::_('COM_DDC_LETS_GO'); ?>" class="btn btn-success"/>
<input name="option" type="hidden" value="com_ddcshopbox">
<input name="checkpostcode" type="hidden" value="true" />
<?php echo JHtml::_('form.token'); ?>
</form>
</div>
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


