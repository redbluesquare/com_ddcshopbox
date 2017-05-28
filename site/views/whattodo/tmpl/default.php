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
		}
		else 
		{
			$class = 'hide';
		}
			
		?>
		<div>
			<i class="glyphicon glyphicon-map-marker"></i> <?php echo $ddccity->town ?> 
			<a onclick="changeTown()" style="color: #aaa;font-size:0.7em;cursor:pointer"><?php echo JText::_('COM_DDC_CHANGE'); ?></a>
		</div>
		<form id="changeTown" class="<?php echo $class; ?>">
		<input id="ddclocation" style="height:30px;min-width:500px;padding:3px;margin:2px 4px;" name="ddccity" placeholder="<?php echo JText::_('COM_DDC_ENTER_POSTCODE'); ?>" value="<?php echo $app->input->get('ddccity',null,'safehtml');?>" />
		<input type="hidden" name="controller" value="default" />
		<input type="hidden" name="option" value="com_ddcshopbox" />
		<input type="hidden" name="ddccheck" value="1" />
		<input type="hidden" name="view" value="cities" />
		<button class="btn btn-primary"><?php echo JText::_('COM_DDC_DISCOVER_NOW'); ?></button>
		</form>
	</div>
	<div class="clearfix"></div>
</div>
<?php 
if($ddccity != null):
?>
<div class="row">
	<div id="getInterest" class="col-md-12" style="display:none;">
	<h3><?php echo JText::_('COM_DDC_TELL_US_WHATS_GOING_ON');?></h3>
	<p><?php echo JText::_('COM_DDC_TELL_US_WHATS_GOING_ON_DESC')?></p>
	<form id="getInterestForm" class="form-horizontal">
		<?php foreach($this->form->getFieldset('get_wtd') as $field): ?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
			<div class="form-group">
				<div class="col-xs-4">
				<?php echo $field->label; ?>
				<?php if (!$field->required && $field->type != 'Spacer') : ?>
					<span><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
				<?php endif; ?>
				</div>
				<div class="col-xs-6">
					<?php echo $field->input;?>
				</div>
			</div>
			<?php endif;?>
		<?php endforeach; ?>
		<input name="jform[town]" type="hidden" id="jform_" value="<?php echo $ddccity->town; ?>" />
	</form>
	<button class="btn btn-primary pull-right" id="submitIntBtn"><?php echo JText::_('COM_DDC_CTA_BTN4'); ?></button>
</div>
<button class="btn btn-primary" id="GetIntBtn"><?php echo JText::_('COM_DDC_WHAT_IS_GOING_ON'); ?></button>
	<div class="clearfix"></div>
</div>
<?php endif;?>