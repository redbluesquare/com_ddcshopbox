<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

if(count($this->items)>0):
?>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped">
	<tbody id="vendor-list">
		<?php for($i=0, $n = count($this->items);$i<$n;$i++) { 
		        $this->_vendorsListView->item = $this->items[$i];
		        $this->_vendorsListView->type = 'item';
		        echo $this->_vendorsListView->render();
		} ?>
	</tbody>
</table>
<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&postcodevalue=clear'); ?>">clear</a>
<?php 
else:
?>

<div class="span12">
	<p><?php echo JText::_('COM_DDC_NO_STORES_IN_AREA'); ?></p>
	<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&postcodevalue=clear'); ?>">clear</a>
</div>

<?php
endif;
?>