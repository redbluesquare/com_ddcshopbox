<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
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
<table class="table">
	<thead>
		<tr>
			<th><?php echo JText::_('COM_DDC_ID'); ?></th>
			<th><?php echo JText::_('COM_DDC_FULL_NAME'); ?></th>
			<th><?php echo JText::_('COM_DDC_DELIVERY_DATE'); ?></th>
			<th><?php echo JText::_('COM_DDC_TOTAL_SHOPS'); ?></th>
			<th><?php echo JText::_('COM_DDC_POSTCODE'); ?></th>
			<th><?php echo JText::_('COM_DDC_TOTAL_COST'); ?></th>
			<th><?php echo JText::_('COM_DDC_STATUS'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td>
        					<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=shopcartheaders&layout=shopcart&shoppingcart_header_id='.$item->ddc_shoppingcart_header_id); ?>"><?php echo $item->ddc_shoppingcart_header_id; ?></a>
        				</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=shopcartheaders&layout=payment&shopcart_id='.$item->ddc_shoppingcart_header_id);?>"><?php echo $item->first_name." ".$item->last_name; ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo JHtml::date($item->delivery_date,'d M Y'); ?>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->total_vendors; ?>
                		</td>
                		<td>
                	        <?php echo $item->post_code; ?>
                		</td>
        				<td style="text-align: center;">
        					<?php echo number_format($item->total_cost,2); ?>
        				</td>
        				<td style="text-align: center;">
        					<?php echo $item->state; ?>
        				</td>
        			</tr>
				<?php endforeach; ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<div>
	<input type="hidden" name="table" value="shoppingcartheaders" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>