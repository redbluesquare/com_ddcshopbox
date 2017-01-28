<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$this->session = JFactory::getSession();
?>
<tr id="vendorRow<?php echo $this->item->ddc_vendor_id; ?>">
  <td class="col-xs-12">
    <div class="pull-left col-xs-2 img-rounded" style="padding-left:0px;padding-right:0px;height:100px;overflow:hidden;" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
    	<a style="height:inherit;width:inherit;overflow:hidden;" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>">
    		<img src="<?php echo $this->item->images; ?>" style="max-width:100%;min-height:100%;">
    	</a>
    </div>
    <div class="col-xs-10">
    	<div class="col-xs-8">
    		
    		<h4 class="header"><a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>"><?php echo $this->item->title; ?></a></h4>
    		<p><?php echo substr($this->item->description,0,160);if(strlen($this->item->description)>160){echo "...";} ?></p>
    	</div>
    	<div class="col-xs-4" style="text-align:right;">
    		<ul style="text-decoration:none; list-style:none;padding:0;">
    		<li><?php echo $this->item->city; ?></li>
    		<li><?php echo $this->item->post_code; ?></li>
    		<?php
    		$val = 0;
    		if($this->session->get('ddclocation',null)==null): 
    			$val = 1;
			elseif($this->item->distance/1000 < 5):
				$val = 1;
			endif;
			if($val == 1):
			?>
    			
    		<?php else: ?>
    			<p><?php echo JText::_('COM_DDC_SHOP_OUT_OF_DELIVERY_RANGE'); ?></p>
    		<?php endif; ?>
    	</div>
    	
    </div>
    
  </td>
</tr>
