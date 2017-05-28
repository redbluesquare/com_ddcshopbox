<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 


class DdcshopboxControllersDefault extends JControllerBase
{
  protected $ddclocation;

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
  	$user = JFactory::getUser();
  	$model = new DdcshopboxModelsDefault();
  	$return = array();
  	$return['success'] = false;
  	if($user->id!=0)
  	{
  		$profile = new DdcshopboxModelsProfiles();
  		if(($session->get("ddclocation", null) == null) or ($app->input->get('ddccheck',null)!=1))
  		{
  			$myProfile = $profile->getItem();
  			$model->setLocation($myProfile->zip);
  		}
  	}
  	if($app->input->get('ddccheck',null)==1)
  	{
  		$model->setLocation($app->input->get('ddccity',null, 'string'));
  		//$model->setLocation($app->input->get('ddclocation',null, 'safehtml'));
  	}
  	if($app->input->get('ddccheck',null)==2)
  	{
  		if($model->isValidPostCodeFormat($app->input->get('ddclocation',null,'string')))
  		{
  			$model->setLocation($app->input->get('ddclocation',null,'string'));
  			$return['success'] = true;
  			$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
  			echo json_encode($return);
  			return true;
  		}
  		else 
  		{
  			$return['msg'] = JText::_('COM_DDC_PLEASE_ENTER_VALID_POSTCODE');
  			echo json_encode($return);
  			return true;
  		}
  		
  	}
  	if($session->get('ddclocation',null)!=null)
  	{
  		if($app->input->getWord('view', 'profiles')=='home'):
  			$app->input->set('view', 'profiles');
  		endif;
  		$viewName = $app->input->getWord('view', 'profiles');
  		$viewFormat = $document->getType();
  		$layoutName = $app->input->getWord('layout', 'default');
  	}
  	if($app->input->get('ddccity',null)!=null)
  	{
  		if($app->input->getWord('view', 'towns')=='home'):
  		$app->input->set('view', 'towns');
  		endif;
  	} 	
	$viewName = $app->input->getWord('view', 'towns');
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