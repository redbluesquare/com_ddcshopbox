<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class DdcshopboxHelpersStyle
{
	public static function load()
	{
		$document = JFactory::getDocument();

		//stylesheets
		//$document->addStylesheet(JURI::base().'components/com_ddcshopbox/assets/css/template.css');
		//$document->addStylesheet(JURI::base().'components/com_ddcshopbox/assets/css/bootstrap.min.css');
		//$document->addStyleSheet('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');

		//javascripts
		$document->addScript(JURI::base().'components/com_ddcshopbox/assets/js/script.js');
		$document->addScript(JURI::base().'components/com_ddcshopbox/assets/js/ddcshopbox.js');

	}
}