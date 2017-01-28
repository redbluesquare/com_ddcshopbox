<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
?>
<input type="button" value="print" onclick="window.print()">
<?php foreach ($this->schItems as $i => $schitem): ?>
<div id="printable">
<table class="table">
<tbody>
<tr>
<td width="20%">
	<?php echo JText::_('COM_DDC_SHOPPING_CART_NO'); ?><br>
	<b><?php if($schitem->delivery_type==1): echo JText::_('COM_DDC_DELIVERY_SERVICE').'<br>'; endif; ?></b>
	<?php echo JText::_('COM_DDC_DELIVERY').'<br>'; ?>
	<?php echo 'Delivery Time'; ?>
<td width="15%" style="text-align: center;">
	<?php echo $schitem->ddc_shoppingcart_header_id; ?><br><br>
	<?php echo JHtml::date($schitem->delivery_date,'D. d M.'); ?><br>
	<?php echo 'Between 09:00 and 12:00'?>
</td>
<td>
</td>
<td width="25%">
	<?php if($schitem->title!=null): echo '<b>'.$schitem->title.'</b><br>'; endif; ?>
	<?php if($schitem->address1!=null): echo $schitem->address1.'<br>'; endif; ?>
	<?php if($schitem->address2!=null): echo $schitem->address2.'<br>'; endif; ?>
	<?php if($schitem->city!=null): echo $schitem->city.'<br>'; endif; ?>
	<?php if($schitem->county!=null): echo $schitem->county.'<br>'; endif; ?>
	<?php if($schitem->post_code!=null): echo $schitem->post_code; endif; ?>
</td>
</tr>
<td width="20%">
	<h3><?php echo JText::_('COM_DDC_CUSTOMER_DETAILS'); ?></h3>
	<?php if($schitem->last_name!=null): echo '<b>'.$schitem->first_name." ".$schitem->last_name.'</b><br>'; endif; ?>
	<?php if($schitem->del_address1!=null): echo $schitem->del_address1.'<br>'; endif; ?>
	<?php if($schitem->del_address2!=null): echo $schitem->del_address2.'<br>'; endif; ?>
	<?php if($schitem->del_town!=null): echo $schitem->del_town.'<br>'; endif; ?>
	<?php if($schitem->del_county!=null): echo $schitem->del_county.'<br>'; endif; ?>
	<?php if($schitem->del_post_code!=null): echo $schitem->del_post_code; endif; ?>
<td width="5%" style="text-align: center;">

</td>
<td>
</td>
<td width="25%">

</td>
</tr>
</tr>
<td width="20%">
	
	
<td width="5%" style="text-align: center;">

</td>
<td>
</td>
<td width="25%">

</td>
</tr>
</tbody>
</table>
<table class="table">
	<thead>
		<tr>
			<th><?php echo JText::_('COM_DDC_PRODUCT'); ?></th>
			<th></th>
			<th></th>
			<th><?php echo JText::_('COM_DDC_QUANTITY'); ?></th>
		</tr>
	</thead>
	<?php 
	$scdItems = new DdcshopboxModelsShopcartdetails();
	$this->items = $scdItems->listItems($schitem->vendor_id);
	?>
	<tbody>
		<?php foreach($this->items as $i => $item): ?>
        	<tr class="row<?php echo $i % 2; ?>">
               <td width="20%">
        			<?php echo $item->vendor_product_name; ?>
        		</td>
                <td>
                	<?php $i = null;?>
					<i style="margin-top:3px;font-size:0.9em;"><?php if($this->model->getpartjsonfield($item->product_params,'product_box')){$i=true;echo '- '.JText::_('COM_DDC_PRODUCT_BOX').": ".trim($this->model->getpartjsonfield($item->product_params,'product_box'));}?>
    				<?php if($item->product_weight>0){if($i==null){echo '- ';}else{echo ', ';}echo JText::_('COM_DDC_WEIGHT').": ".number_format($item->product_weight,2)." ".$item->product_weight_uom;}?></i>
    		
                </td>
                <td style="text-align: center;">
                	
                </td>
                <td>
                	<?php echo $item->product_quantity; ?>
                </td>
        	</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:center;color:#fff;">
				<?php //echo JText::_('COM_DDC_TOTAL_VENDORS'); ?><br>
				<?php //echo count($this->schItems); ?>
			</td>
			<td></td>
			<td></td>
            <td></td>
		</tr>
	</tfoot>
</table>
</div>
<?php endforeach; ?>

