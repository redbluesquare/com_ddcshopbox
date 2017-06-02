<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="row">
	<div class="col-xs-offset-8 col-xs-4">
		<a class="pull-right btn btn-success" href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=recipes&layout=edit&task=recipe.add'); ?>"><i class="glyphicon glyphicon-plus"></i> <?php echo JText::_('COM_DDC_ADD_NEW_RECIPE'); ?></a>
	</div>
</div>
<?php
if(count($this->items)>0):
?>
<div class="row reciperow">
	<?php for($i=0, $n = count($this->items);$i<$n;$i++) { 
	        $this->_recipesListView->item = $this->items[$i];
	        $this->_recipesListView->type = 'item';
	        echo $this->_recipesListView->render();
	} ?>
</div>
<?php 
else:
?>

<div class="col-xs-12">
	<p><?php echo JText::_('COM_DDC_NO_RECIPES'); ?></p>
	
</div>
<?php
endif;
?>