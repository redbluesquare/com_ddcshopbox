<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo $this->profile->name?></h3>		
	</div>
	<div class="span3">
		<a href="#profileaddressModal" role="button" data-toggle="modal" class="btn pull-right"><i class="icon icon-user"></i> <?php echo JText::_('COM_DDC_UPDATE_PROFILE'); ?></a>
	</div>
</div>
<?php $this->_profileAddressView->form = $this->form; ?>
<?php echo $this->_profileAddressView->render(); ?>