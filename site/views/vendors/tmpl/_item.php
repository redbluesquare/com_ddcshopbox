<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<tr id="vendorRow<?php echo $this->item->ddc_vendor_id; ?>">
  <td class="col-xs-12">
    <div class="pull-left col-md-2" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
    	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>">
    		<img class="img-rounded" src="<?php echo $this->item->images; ?>" style="max-height:100px;margin:0 auto;text-align:center;">
    	</a>
    </div>
    <div class="col-md-10">
    	<div class="col-md-9">
    		
    		<h4 class="header"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
    		<p><?php echo substr($this->item->description,0,160);if(strlen($this->item->description)>160){echo "...";} ?></p>
    	</div>
    	<div class="col-md-3" style="text-align:right;">
    		<ul style="text-decoration:none; list-style:none;padding:0;">
    		<li><?php echo $this->item->town; ?></li>
    		<li><?php echo $this->item->post_code; ?></li>
    	</div>
    	
    </div>
    
  </td>
</tr>
