<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
?>

<form method="post">
<input type="text"  name="mypostcode" id="mypostcode"/>
<input type="submit" name="submit" value="<?php echo JText::_('COM_DDC_LETS_GO'); ?>" class="btn btn-success"/>
<input name="option" type="hidden" value="com_ddcshopbox">
<input name="checkpostcode" type="hidden" value="true" />
<?php echo JHtml::_('form.token'); ?>
</form>