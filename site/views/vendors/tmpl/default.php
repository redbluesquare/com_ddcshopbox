<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = JFactory::getUser()->id;
$app = JFactory::$application;
$session = $app->getSession();
$ddccity = $session->get('ddccity',null);
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
		<?php if(($ddccity!=null) Or ($ddccity!="")): ?>
		<div>
			<i class="glyphicon glyphicon-map-marker"></i> <?php echo $ddccity->town ?> 
			<a onclick="changeTown()" style="color: #aaa;font-size:0.7em;cursor:pointer"><?php echo JText::_('COM_DDC_CHANGE'); ?></a>
		</div>
		<?php endif; ?>
		<form id="changeTown" class="<?php echo $class; ?>">
		<input id="ddclocation" style="height:30px;min-width:500px;padding:3px;margin:2px 4px;" name="ddccity" placeholder="<?php echo JText::_('COM_DDC_ENTER_POSTCODE'); ?>" value="<?php echo $app->input->get('ddccity',null,'safehtml');?>" />
		<input type="hidden" name="controller" value="default" />
		<input type="hidden" name="option" value="com_ddcshopbox" />
		<input type="hidden" name="view" value="towns" />
		<button onclick="searchTown()" class="btn btn-primary"><?php echo JText::_('COM_DDC_SEARCH'); ?></button>
		</form>
	</div>
	<div class="clearfix"></div>
</div>
<?php
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
<?php 
else:
?>

<div class="col-xs-12">
	<p><?php echo JText::_('COM_DDC_NO_STORES_IN_AREA'); ?></p>
	
</div>
<?php
endif;
?>
<div id="getInterest" class="row" style="display:none;">
	<h3><?php echo JText::_('COM_DDC_TELL_US_YOUR_FAVORITE_SHOPS');?></h3>
	<p><?php echo JText::_('COM_DDC_TELL_US_YOUR_FAVORITE_SHOPS_DESC')?></p>
	<form id="getInterestForm" class="form-horizontal">
		<?php foreach($this->form->getFieldset('get_interest') as $field): ?>
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
	</form>
	<button class="btn btn-primary pull-right" id="submitIntBtn"><?php echo JText::_('COM_DDC_CTA_BTN2'); ?></button>
</div>
<button class="btn btn-primary" id="GetIntBtn"><?php echo JText::_('COM_DDC_CANT_FIND_YOUR_FAVOURITE_SHOP'); ?></button>