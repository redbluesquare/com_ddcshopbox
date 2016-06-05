<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

class DdcshopboxControllersDefault extends JControllerBase
{
  protected $postcode;
	
  public function execute()
  {
  	// Get the application
  	$app = JFactory::getApplication();
  	$session = JFactory::getSession(); 	
  	$user = JFactory::getUser()->id;
  	
  	if($user!=null)
  	{
  		//set the postcode into the session
  		$model = new DdcshopboxModelsDefault();
  		$this->postcode = $model->setPostcode($user);
  	}
  	if($session->get('postcode')!=null)
  	{
  		//echo $session->get('postcode');
  	}
  	  	
  	// Get the document object.
  	$document = JFactory::getDocument();
  	if($this->postcode==true){$viewName = $app->input->getWord('view', 'products');}
  	else{$viewName = $app->input->getWord('view', 'profiles');}
  	$viewFormat = $document->getType();
  	$layoutName = $app->input->getWord('layout', 'default');
  	
  	$app->input->set('view', $viewName);
  	
  	// Register the layout paths for the view
  	$paths = new SplPriorityQueue;
  	$paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');
  	
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