<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//load composer classes
require JPATH_LIBRARIES.'/vendor/autoload.php';

//sessions
jimport( 'joomla.session.session' );

//load tables
JTable::addIncludePath(JPATH_COMPONENT.'/tables');

//load classes
JLoader::registerPrefix('Ddcshopbox', JPATH_COMPONENT);

//Load plugins
//JPluginHelper::importPlugin('Ddcshopbox');

//Load styles and javascripts
//DdcshopboxHelpersStyle::load();

//application
$app = JFactory::getApplication();

// Require specific controller if requested
$controller = $app->input->get('controller','default');

// Create the controller
$classname  = 'DdcshopboxControllers'.ucwords($controller);
$controller = new $classname();

// Perform the Request task
$controller->execute();