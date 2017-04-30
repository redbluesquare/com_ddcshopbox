<?php
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';


?>
<div id="p3loginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo JText::_('COM_DDC_LOGIN'); ?></h3>
  </div>
  <div class="modal-body">
<form action="<?php echo JRoute::_(htmlspecialchars(JUri::getInstance()->toString()), true, true); ?>" method="post" id="login-form" class="form-inline">

	<div class="userdata">
		<div id="form-login-username" class="control-group row-fluid">
			<div class="controls">
					<span class="col-xs-4"><label for="modlgn-username"><?php echo JText::_('COM_DDC_USERNAME') ?></label></span>
					<span class="col-xs-8"><input id="modlgn-username" type="text" name="username" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('COM_DDC_USERNAME') ?>" /></span>
			</div>
		</div>
		<div class="clearfix"></div>
		<div id="form-login-password" class="control-group row-fluid">
			<div class="controls">
					<span class="col-xs-4"><label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label></span>
					<span class="col-xs-8"><input id="modlgn-passwd" type="password" name="password" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" /></span>
			</div>
		</div>
		<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		<div id="form-login-remember" class="control-group checkbox">
			<label for="modlgn-remember" class="control-label"><?php echo JText::_('COM_DDC_REMEMBER_ME') ?></label> <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
		</div>
		<?php endif; ?>
		<div id="form-login-submit" class="control-group">
			<div class="controls">
				<button type="submit" tabindex="0" name="Submit" class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
			</div>
		</div>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JUri::getInstance()->toString()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>

  </div>
  <div class="modal-footer">
  </div>
</div>
</div>
</div>
