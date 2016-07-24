<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

class DdcshopboxControllersDefault extends JControllerBase
{
  protected $postcode;

  function __construct()
  {
  	parent::__construct();
  }
  
  public function execute()
  {
  	// Get the application
  	$app = JFactory::getApplication();
  	// Get the document object.
  	$document = JFactory::getDocument();
  	$session = JFactory::getSession();
  	$user = JFactory::getUser()->id;
  	$model = new DdcshopboxModelsDefault();
  	if($session->get('mypostcode',null)==null):
	  	if($user!=null)
	  	{
	  		//set the postcode into the session
	  		$this->postcode = $model->setPostcode($user);
	  	}
	  	else
	  	{
	  		$postcode = $app->input->get('mypostcode', "", 'string');
	  		if($postcode!=null)
	  		{
	  			$this->postcode = $model->setPostcode("",$postcode);
	  		}
	  	}
	  	
	  	if(($session->get('mypostcode',null)!=null) And ($app->input->get('checkpostcode',null)==true))
	  	{
	  		$app->input->set('view', 'vendors');
	  		$app->input->set('layout', 'default');
	  	}
	endif;
	if($app->input->get('postcodevalue',null,'string')=='clear')
	{
		$session->clear('mypostcode');
		$app->redirect(JRoute::_('index.php?option=com_ddcshopbox'));
	}
  	if($session->get('mypostcode',null)!=null)
  	{
  		if($app->input->getWord('view', 'vendors')=='products'):
  			$app->input->set('view',null);
  		endif;
  		$viewName = $app->input->getWord('view', 'vendors');
  		$viewFormat = $document->getType();
  		$layoutName = $app->input->getWord('layout', 'default');
  	}
	else
	{
		$viewName = $app->input->getWord('view', 'products');
		$viewFormat = $document->getType();
		$layoutName = $app->input->getWord('layout', 'default');
	}
	
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