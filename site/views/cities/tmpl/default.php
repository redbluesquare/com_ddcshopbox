<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
$app = JFactory::$application;
?>
<div class="row">
	<div class="col-md-12">
		<form get="<?php echo JRoute::_('index.php'); ?>">
		<input style="height:30px;min-width:500px;padding:3px;margin:2px 4px;" name="ddccity" placeholder="<?php echo JText::_('COM_DDC_ENTER_TOWN_CITY'); ?>" value="<?php echo $app->input->get('ddccity',null);?>" /><button class="btn btn-primary"><?php echo JText::_('COM_DDC_SEARCH'); ?></button>
		<input type="hidden" name="controller" value="default" />
		<input type="hidden" name="option" value="com_ddcshopbox" />
		</form>
	</div>
	<div class="col-md-12">
	<p>Show City</p>
	<p>Show Shops</p>
	<p>Show Activities</p>
	<p>Show Events</p>
	<p>Show Services</p>
	</div>
</div>