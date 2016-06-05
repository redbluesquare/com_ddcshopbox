<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<form action="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=vendors'); ?>" method="post" name="adminForm" id="adminForm">
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
			<th><?php echo JText::_('COM_DDC_TITLE'); ?></th>
			<th><?php echo JText::_('COM_DDC_OWNER'); ?></th>
			<th><?php echo JText::_('COM_DDC_POSTCODE'); ?></th>
		</tr>
	</thead>
	<tbody>	
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
</form>