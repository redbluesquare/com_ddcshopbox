<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');




?>

        <table  class="adminlist table">
			<tbody>
				<tr><td><?php echo JText::_('COM_DDC_ID').": "?></td><td><?php echo $this->payment->ref_id;?></td></tr>
				<tr><td><?php echo JText::_('COM_DDC_PAYMENT_DETAILS').": "?></td><td><?php echo $this->payment->token; ?></td></tr>
			</tbody>
			<input type="hidden" name="jform[table]" value="shopcart" />
			<input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
                
        </table>
