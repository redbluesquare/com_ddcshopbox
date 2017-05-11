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
			<th><?php echo JText::_('COM_DDC_STATUS'); ?></th>
			<th><?php echo JText::_('COM_DDC_ID'); ?></th>
			<th><?php echo JText::_('COM_DDC_PRODUCT_NAME'); ?></th>
			<th><?php echo JText::_('COM_DDC_PARENT_PRODUCT'); ?></th>
			<th><?php echo JText::_('COM_DDC_PRODUCT_ORDERING'); ?></th>
			<th><?php echo JText::_('COM_DDC_CATEGORY'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td style="text-align: center;">
        					<?php echo JHtml::_('jgrid.published', $item->published, 'state'); ?>
        				</td>
        				<td>
        					<?php echo $item->ddc_product_id; ?>
        				</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=products&layout=edit&product_id='.$item->ddc_product_id); ?>"><?php echo $item->product_name; ?></a>
                		</td>
                		<td>
                	        <?php echo $item->parent_product; ?>
                		</td>
                		<td>
                	        <?php echo $item->pordering; ?>
                		</td>
                		<td>
                	        <?php echo $item->category_title; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<div>
	<input type="hidden" name="jform[table]" value="products" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>