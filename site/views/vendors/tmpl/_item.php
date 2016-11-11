<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<tr id="vendorRow<?php echo $this->item->ddc_vendor_id; ?>">
  <td class="col-xs-12">
    <div class="pull-left col-xs-2" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
    	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>">
    		<img class="col-xs-12 img-rounded" src="<?php echo $this->item->images; ?>">
    	</a>
    </div>
    <div class="col-xs-10">
    	<h4 class=""><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
    	<p><?php echo $this->item->description; ?></p>
    </div>
    
  </td>
</tr>
