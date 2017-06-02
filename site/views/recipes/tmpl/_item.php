<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$this->session = JFactory::getSession();
$params = JComponentHelper::getParams('com_ddcshopbox');
?>
<div class="col-xs-6">
	<div class="recipesummary">
		<a href="<?php echo JRoute::_('index.php?option=com_ddcshopbox&view=recipes&layout=recipe&recipeid='.$this->item->ddc_recipe_header_id); ?>">
		<div  style="background: url(<?php echo $this->item->image_link; ?>);background-position: 50% 50%;">
			<h2><?php echo $this->item->title;?></h2>
		</div>
		</a>
	</div>
</div>