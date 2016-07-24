<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

//sessions
jimport( 'joomla.session.session' );

//load tables
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');

//load classes
JLoader::registerPrefix('Ddcshopbox', JPATH_COMPONENT_ADMINISTRATOR);

//Load plugins
//JPluginHelper::importPlugin('ddcshopbox');
 
//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controller = $app->input->get('controller','default');

// Create the controller
$classname  = 'DdcshopboxControllers'.ucwords($controller);
$controller = new $classname();

JHtml::_('bootstrap.framework');
//Load styles and javascripts
//DdcshopboxHelpersStyle::load();

// Perform the Request task
$controller->execute();