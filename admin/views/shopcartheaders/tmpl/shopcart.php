<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcshopbox&controller=edit'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
<input type="button" value="print" onclick="trigPrint()">
<style>
.table{width:100%;}
.table tr td{text-align:top;padding:5px;}
.table tbody tr td{border-top:1px solid #ccc;}
.table tfoot{border-top:2px solid #5c5c5c;}
@media print{
	body *{visibility:hidden;}
	#printable *{visibility:visible;}
	#printable{width:90%;page-break-inside:avoid;}
	div {float: none !important;}
	.table th, .table td{border-top: 1px solid #fff;}
}
</style>
<div id="printBox">
<?php foreach ($this->schItems as $i => $schitem): ?>
<div id="printable">
<h1><?php if($schitem->title!=null): echo '<b>'.$schitem->title.'</b><br>'; endif; ?></h1>
<table class="table">
	<tbody>
		<tr>
			<td width="25%">
				<?php echo JText::_('COM_DDC_SHOPPING_CART_NO'); ?><br>
				<b><?php if($schitem->delivery_type==1): echo JText::_('COM_DDC_DELIVERY_SERVICE').'<br>'; endif; ?></b>
				<?php echo JText::_('COM_DDC_DELIVERY').'<br>'; ?>
				<?php echo 'Delivery Time'; ?><br>
			<td colspan="2" width="35%">
				<?php echo $schitem->ddc_shoppingcart_header_id; ?><br>
				<?php echo JHtml::date($schitem->delivery_date,'D. d M.'); ?><br>
				<?php echo 'Between 09:00 and 16:00'?>
			</td>
			<td></td>
			<td width="25%">
				<h3><?php echo JText::_('COM_DDC_CUSTOMER_DETAILS'); ?></h3>
				<?php if($schitem->last_name!=null): echo '<b>'.$schitem->first_name." ".$schitem->last_name.'</b><br>'; endif; ?>
				<?php if($schitem->del_address1!=null): echo $schitem->del_address1.'<br>'; endif; ?>
				<?php if($schitem->del_address2!=null): echo $schitem->del_address2.'<br>'; endif; ?>
				<?php if($schitem->del_town!=null): echo $schitem->del_town.'<br>'; endif; ?>
				<?php if($schitem->del_county!=null): echo $schitem->del_county.'<br>'; endif; ?>
				<?php if($schitem->del_post_code!=null): echo $schitem->del_post_code; endif; ?>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="padding:10px;"> </td>
		</tr>
		</tr>
			<td width="25%">
				<?php if($schitem->address1!=null): echo $schitem->address1.'<br>'; endif; ?>
				<?php if($schitem->address2!=null): echo $schitem->address2.'<br>'; endif; ?>
				<?php if($schitem->city!=null): echo $schitem->city.'<br>'; endif; ?>
				<?php if($schitem->county!=null): echo $schitem->county.'<br>'; endif; ?>
				<?php if($schitem->post_code!=null): echo $schitem->post_code; endif; ?>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
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
			<th><?php echo JText::_('COM_DDC_TOTAL'); ?></th>
		</tr>
	</thead>
	<?php 
		$scdItems = new DdcshopboxModelsShopcartdetails();
		$this->items = $scdItems->listItems($schitem->ddc_vendor_id);
	?>
	<tbody>
		<?php $totalprice = 0;?>
		<?php foreach($this->items as $i => $item): ?>
        	<tr class="row<?php echo $i % 2; ?>">
            	<td><?php echo $item->vendor_product_name; ?></td>
                <td>
                	<?php $i = null;?>
					<i style="margin-top:3px;font-size:0.9em;"><?php if($this->model->getpartjsonfield($item->product_params,'product_box')){$i=true;echo '- '.JText::_('COM_DDC_PRODUCT_BOX').": ".trim($this->model->getpartjsonfield($item->product_params,'product_box'));}?>
    				<?php if($item->product_weight>0){if($i==null){echo '- ';}else{echo ', ';}echo JText::_('COM_DDC_WEIGHT').": ".number_format($item->product_weight,2)." ".$item->product_weight_uom;}?></i>
    			</td>
                <td></td>
                <td><?php echo $item->product_quantity; ?></td>
                <td><?php echo "&pound;" . number_format($item->product_quantity*$item->price,2); ?></td>
        	</tr>
        	<?php $totalprice = $totalprice+($item->product_quantity*$item->price); ?>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td></td>
			<td></td>
            <td><b><?php echo JText::_('COM_DDC_SUB_TOTAL'); ?></b></td>
            <td><b><?php echo "&pound;" . number_format($totalprice,2); ?></b></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
            <td></td>
            <td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
            <td><b><?php echo JText::_('COM_DDC_TOTAL'); ?></b></td>
            <td><b><?php echo "&pound;" . number_format($totalprice-($totalprice*3.4/100),2); ?></b></td>
		</tr>
	</tfoot>
</table>
</div>
<?php 
$page++;
endforeach; 
?>
</div>
<script>
function trigPrint()
{
	w=window.open(document.URL+'&format=phtml', '_blank', 'location=yes,height=800,width=940,scrollbars=yes,status=yes');
	w.print(document.URL+'&format=phtml');
}
</script>
</div>
<div>
	<input type="hidden" name="jform[table]" value="shoppingcartheaders" />
	<input type="hidden" name="shoppingcart_header_id" value="<?php echo $schitem->ddc_shoppingcart_header_id?>" />
	<input type="hidden" name="task" value="shoppingcartheader.edit" />
	<input type="hidden" name="boxchecked" value="1" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>

