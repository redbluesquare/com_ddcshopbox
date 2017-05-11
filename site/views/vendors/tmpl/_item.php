<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$this->session = JFactory::getSession();
$params = JComponentHelper::getParams('com_ddcshopbox');
?>
<tr id="vendorRow<?php echo $this->item->ddc_vendor_id; ?>">
  <td class="col-xs-12">
    <div class="pull-left col-xs-2 img-rounded" style="padding-left:0px;padding-right:0px;height:100px;overflow:hidden;" id="vendor-row-<?php echo $this->item->ddc_vendor_id; ?>">
    	<a style="height:inherit;width:inherit;overflow:hidden;" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=vendor&vendor_id='.$this->item->ddc_vendor_id); ?>">
    		<img src="<?php echo $this->item->images; ?>" style="max-width:100%;min-height:100%;">
    	</a>
    </div>
    <div class="col-xs-10">
    	<div class="col-xs-8" class="vendorInfo">
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
			elseif($this->item->distance/1000 < $params->get('distance_limit')):
				$val = 1;
			endif;
			if($val == 1):
			?>
    			
    		<?php else: ?>
    			<p><?php echo JText::_('COM_DDC_SHOP_OUT_OF_DELIVERY_RANGE'); ?></p>
    		<?php endif; ?>
    		<?php 
    		$uvi = new DdcshopboxModelsUservendorinterests();
    		if($uvi->checkUserVendorInterests($this->item->ddc_vendor_id,JFactory::getUser()->id)==false)
    		{
    			$image = 'images/bg-heart.png';
    		}
    		else{
    			$image = 'images/heart-icon.png';
    		}
    		?>
    		
    		<div class="favShop" <?php if(JFactory::getUser()->id!=0): ?>onclick="addFavshop(<?php echo $this->item->ddc_vendor_id; ?>)"<?php endif; ?>><img id="favShopImg<?php echo $this->item->ddc_vendor_id; ?>" src="<?php echo JRoute::_($image); ?>" class="pull-left" /><span id="favShopCounter<?php echo $this->item->ddc_vendor_id; ?>" class="pull-right"><?php echo count($uvi->listItems($this->item->ddc_vendor_id)); ?></span></div>
    	</div>
    	
    </div>
    
  </td>
</tr>
