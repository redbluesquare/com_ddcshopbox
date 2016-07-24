<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
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
			if($task=="contactAddress.edit")
			{
				$modelName  = $app->input->get('models', 'profiles');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if($model->saveAddress())
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}
			}
			
		}
		if($this->data['table']=='uservendors')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='uservendor.add')
			{
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
				 
			}
			if($task=='uservendors.edit')
			{
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
					
			}
			if($task=="uservendor.save")
			{
				$modelName  = $app->input->get('models', 'uservendors');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
		
				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDC_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			if($task=="uservendors.cancel")
			{
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			//display view
			return parent::execute();
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
