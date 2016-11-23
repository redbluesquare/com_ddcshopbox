<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo $this->profile->name?></h3>		
	</div>
	<div class="span3">
		<button type="button" role="button" data-toggle="modal" class="btn pull-right" data-target="#profileaddressModal"><i class="icon icon-user"></i> <?php echo JText::_('COM_DDC_UPDATE_PROFILE'); ?></button>
	</div>
</div>
<?php $this->_profileAddressView->form = $this->form; ?>
<?php echo $this->_profileAddressView->render(); ?>