<?php
/**
 * @version     1.0.0
 * @package     com_blueb
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Darryl Usher <info@redbluesquare.co.uk> - http://www.redbluesquare.co.uk
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Ddctap helper.
 */
class DdcshopboxHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_DDC_PRODUCTS_TITLE'),
			'index.php?option=com_ddcshopbox&view=products',
			$vName == 'products'
		);

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_ddcshopbox';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}