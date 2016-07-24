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
			<th><?php echo JText::_('COM_DDC_TITLE'); ?></th>
			<th><?php echo JText::_('COM_DDC_OWNER'); ?></th>
			<th><?php echo JText::_('COM_DDC_POSTCODE'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($this->items as $i => $item): ?>
        			<tr class="row<?php echo $i % 2; ?>">
                		<td style="text-align: center;">
        					<?php echo JHtml::_('jgrid.published', $item->state, 'state'); ?>
        				</td>
        				<td>
        					<?php echo $item->ddc_vendor_id; ?>
        				</td>
                		<td>
                	        <a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors&layout=edit&vendor_id='.$item->ddc_vendor_id); ?>"><?php echo $item->title; ?></a>
                		</td>
                		<td style="text-align: center;">
                	        <?php echo $item->owner_name; ?>
                		</td>
                		<td>
                	        <?php echo $item->post_code; ?>
                		</td>
        			</tr>
				<?php endforeach; ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<div>
	<input type="hidden" name="jform[table]" value="vendors" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>