<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 


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
	  	$viewName = $app->input->getWord('view', 'home');
	  	$viewFormat = $document->getType();
	  	$layoutName = $app->input->getWord('layout', 'default');
	  	
	endif;
	if($app->input->get('postcodevalue',null,'string')=='clear')
	{
		$session->clear('mypostcode');
		$app->redirect(JRoute::_('index.php?option=com_ddcshopbox'));
	}
  	if($session->get('mypostcode',null)!=null)
  	{
		$viewName = $app->input->getWord('view', 'vendors');
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