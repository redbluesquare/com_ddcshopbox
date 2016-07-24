<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

class DdcshopboxControllersEdit extends DdcshopboxControllersDefault {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		$this->data = $jinput->get('jform', array(),'array');
		
		
		if($this->data['table']=='vendors')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='vendor.add')
			{
				$viewName = $app->input->getWord('view', 'vendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
    			
			}
			if($task=='vendor.edit')
			{
				$viewName = $app->input->getWord('view', 'vendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
				 
			}
			if($task=="vendor.save")
			{
				$modelName  = $app->input->get('models', 'vendors');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDC_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
     			$viewName = $app->input->getWord('view', 'vendors');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			if($task=="vendor.cancel")
			{
     			$viewName = $app->input->getWord('view', 'vendors');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			//display view
			return parent::execute();
		}
		if($this->data['table']=='contactaddress')
		{
			if($this->data['task']=="edit")
			{
				$modelName  = $app->input->get('models', 'profiles');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if($row = $model->saveAddress())
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
				}
				else
				{
					//$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			$return['data'] = $row;
			echo json_encode($return);
			
		}
		else
		{
			$viewName = $app->input->getWord('view', 'dashboard');
			$app->input->set('layout','default');
			$app->input->set('view', $viewName);
			//display view
			return parent::execute();
		}
	}
		
}
