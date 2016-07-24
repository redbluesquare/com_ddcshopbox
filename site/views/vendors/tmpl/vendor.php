<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<div class="row-fluid">
	<div class="span8">
		<div class="row-fluid">
			<div class="pull-left span3" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
			    <img class="span12" src="<?php echo $this->item->images; ?>">
			</div>
			<div class="span6">
				<h4 class=""><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
				<p><?php echo $this->item->description; ?></p>
				<p><small><?php echo $this->item->address1." ".$this->item->address2.$this->item->city." "." ".$this->item->post_code; ?></small></p>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="row-fluid">
			<div class="span12">
			<?php foreach ($this->products as $product):?>
				<p><img class="pull-left span2" src="<?php echo JRoute::_($product->image_link); ?>" hspace="7" /><?php echo $product->product_name; ?></p>
			<?php endforeach; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php ?>
		<a href="#" class="pull-right"><?php echo JText::_('COM_DDC_MANAGE STORE'); ?></a>
		<div class="clearfix"></div>
		<div id="map-canvas" style="height:250px;"></div>
	</div>
</div>
