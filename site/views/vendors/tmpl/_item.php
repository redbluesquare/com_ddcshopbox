<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<tr id="vendorRow<?php echo $this->item->ddc_vendor_id; ?>">
  <td class="span12">
    <div class="pull-left span2" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
    	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>">
    		<img class="" src="<?php echo $this->item->images; ?>">
    	</a>
    </div>
    <div class="span10">
    	<h4 class=""><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
    	<p><?php echo $this->item->description; ?></p>
    </div>
    
  </td>
</tr>
