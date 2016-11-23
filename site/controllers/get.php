<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

class DdcshopboxControllersGet extends DdcshopboxControllersDefault {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		$this->session = JFactory::getSession();
		$this->data = $jinput->get('jform', array(),'array');
		
		
		
		if($this->data['table']=='ddcshoppingcart')
		{
			
			$model = new DdcshopboxModelsDefault();
			$result = $model->getShopCart_contents();
			//$this->session->clear('shoppingcart_header_id');
			if($result)
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
				$return['result'] = $result;
			}
			else
			{
				$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
			}
			echo json_encode($return);
			
		}
		else
		{
			$viewName = $app->input->getWord('view', 'home');
			$app->input->set('layout','default');
			$app->input->set('view', $viewName);
			//display view
			return parent::execute();
		}
	}
		
}
