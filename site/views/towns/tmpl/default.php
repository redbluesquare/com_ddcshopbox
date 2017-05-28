<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
$app = JFactory::$application;
$session = $app->getSession();
?>
<div class="row" style="padding-bottom:10px;">
	<div class="col-md-12">
		<?php 
		$ddccity = $session->get('ddccity',null);
		if($ddccity == null)
		{
			$class = '';
			$townClass = 'myTownInit';
		}
		else 
		{
			$class = 'hide';
			$townClass = '';
		}
			
		?>
		<?php if(($ddccity!=null) Or ($ddccity!="")): ?>
		<div>
			<i class="glyphicon glyphicon-map-marker"></i> <?php echo $ddccity->town ?> 
			<a onclick="changeTown()" style="color: #aaa;font-size:0.7em;cursor:pointer"><?php echo JText::_('COM_DDC_CHANGE'); ?></a>
		</div>
		<?php endif; ?>
		<form id="changeTown" class="<?php echo $class.' '.$townClass; ?>">
		<input id="ddclocation" name="ddccity" placeholder="<?php echo JText::_('COM_DDC_ENTER_POSTCODE'); ?>" value="<?php echo $app->input->get('ddccity',null,'safehtml');?>" />
		<input type="hidden" name="controller" value="default" />
		<input type="hidden" name="option" value="com_ddcshopbox" />
		<input type="hidden" name="ddccheck" value="1" />
		<input type="hidden" name="view" value="towns" />
		<button class="btn btn-primary"><?php echo JText::_('COM_DDC_DISCOVER_NOW'); ?></button>
		</form>
	</div>
	<div class="clearfix"></div>
</div>
<?php 
if(($ddccity != null) Or ($ddccity!=null)):
?>
<div class="row">
	<div class="col-xs-3">
		<a href="<?php echo JRoute::_('shops.html?localonly=true'); ?>">
		<div class="divBox" style="overflow:hidden;background:url('http://chalfontstpeter.com/photos/old/market-place-1-l.jpg');background-position:60% 50%;background-size:200%;">
			<p style="text-align:center;background:rgba(0,0,0,0.8);padding:10px;position:relative;width:120%;display:block;left:-5px;top:-5px;color:#efefef;"><?php echo JText::_('COM_DDC_VISIT_SHOPS'); ?></p>
		</div>
		</a>
	</div>
	<div class="col-xs-3">
		<a href="<?php echo JRoute::_('events.html?localonly=true'); ?>">
		<div class="divBox" style="overflow:hidden;background:url('images/calendar2.png');background-position:60% 50%;background-size:120%;">
			<p style="text-align:center;background:rgba(0,0,0,0.8);padding:10px;position:relative;width:120%;display:block;left:-5px;top:-5px;color:#efefef;"><?php echo JText::_('COM_DDC_LOCAL_EVENTS'); ?></p>
		</div>
		</a>
	</div>
	<div class="col-xs-3">
		<a href="<?php echo JRoute::_('what-to-do.html?localonly=true'); ?>">
		<div class="divBox" style="overflow:hidden;background:url('images/ushbub_wgo.jpeg');background-position:60% 50%;background-size:120%;">
			<p style="text-align:center;background:rgba(0,0,0,0.8);padding:10px;position:relative;width:120%;display:block;left:-5px;top:-5px;color:#efefef;"><?php echo JText::_('COM_DDC_WHATS_GOING_ON'); ?></p>
		</div>
		</a>
	</div>
	<div class="col-xs-3">
	
	</div>
	<div class="clearfix"></div>
</div>
<?php endif;?>
