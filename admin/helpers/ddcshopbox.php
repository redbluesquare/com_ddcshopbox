<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ddcshopbox
 */

defined('_JEXEC') or die;

/**
 * Ddcshopbox component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ddcshopbox
 * @since       1.6
 */
class DdcshopboxHelpersDdcshopbox
{
	public static $extension = 'com_ddcshopbox';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_ddcshopbox';
		$level = 'component';

		$actions = JAccess::getActions('com_ddcshopbox', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}
		return $result;
	}
	
	public static function addSubmenu($submenu)
	{
		JHtmlSidebar::addEntry(JText::_('COM_DDC_DASHBOARD'),
		'index.php?option=com_ddcshopbox&view=dashboard', $submenu == 'dashboard');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_COUPONS'),
				'index.php?option=com_ddcshopbox&view=coupons', $submenu == 'coupons');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_PAYMENTMETHODS'),
				'index.php?option=com_ddcshopbox&view=paymentmethods', $submenu == 'paymentmethods');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_CATEGORIES'),
				'index.php?option=com_categories&view=categories&extension=com_ddcshopbox', $submenu == 'categories');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_PRODUCTS'),
			'index.php?option=com_ddcshopbox&view=products', $submenu == 'products');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_VENDORS'),
				'index.php?option=com_ddcshopbox&view=vendors', $submenu == 'vendors');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_VENDOR_PRODUCTS'),
				'index.php?option=com_ddcshopbox&view=vendorproducts', $submenu == 'vendorproducts');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_USER_VENDORS'),
				'index.php?option=com_ddcshopbox&view=uservendors', $submenu == 'uservendors');
		JHtmlSidebar::addEntry(JText::_('COM_DDC_SHOPCART_HEADERS'),
				'index.php?option=com_ddcshopbox&view=shopcartheaders', $submenu == 'shopcartheaders');
		// set some global property
		$document = JFactory::getDocument();

		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_DDC_ADMINISTRATION_CATEGORIES'));
		}
	}
}