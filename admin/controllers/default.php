<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

class DdcshopboxControllersDefault extends JControllerBase
{
  public function execute()
  {
  	// Get the application
  	$app = JFactory::getApplication();
  	
  	// Get the document object.
  	$document     = JFactory::getDocument();
  	
  	$viewName     = $app->input->getWord('view', 'vendors');
  	$viewFormat   = $document->getType();
  	$layoutName   = $app->input->getWord('layout', 'default');
  	
  	$app->input->set('view', $viewName);
  	
  	// Register the layout paths for the view
  	$paths = new SplPriorityQueue;
  	$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/views/' . $viewName . '/tmpl', 'normal');
  	
  	$viewClass  = 'DdcshopboxViews' . ucfirst($viewName) . ucfirst($viewFormat);
  	$modelClass = 'DdcshopboxModels' . ucfirst($viewName);
  	
  	if (false === class_exists($modelClass))
  	{
  		$modelClass = 'DdcshopboxModelsDefault';
  	}
  	
  	$view = new $viewClass(new $modelClass, $paths);
  	
  	$view->setLayout($layoutName);
  	
  	// Render our view.
  	echo $view->render();
  	
  	return true;
  }

}