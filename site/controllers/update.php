<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

class DdcshopboxControllersUpdate extends DdcshopboxControllersDefault {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		$this->session = JFactory::getSession();
		$user_id = JFactory::getUser()->id;
		$this->data = $jinput->get('jform', array(),'array');
		
		$model = new DdcshopboxModelsShopcart();
		
		if($this->data['table']=='ddcshoppingcart')
		{
			if($this->data['task']=="shoppingcart.update")
			{
				if($model->storeCartData($this->data))
				{
					$result = $model->getShopCart_contents();
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					$return['result'] = $result;
				}
				else
				{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			
			echo json_encode($return);
			
		}
		elseif($this->data['table']=='ddcCheckout')
		{
			if($user_id == 0){
				//store paymentmethod and postage

				//redirect user to login
				$return['success'] = true;
				$return['login'] = 0;
				$return['url'] = JRoute::_('index.php?option=com_users&view=login&return='.base64_encode('index.php?option=com_ddcshopbox&view=shopcart'));
				$return['msg'] = JText::_('COM_DDC_PLEASE_LOGIN');
			}
			else{
				if($jinput->get('paypalsuccess',null)=='false')
				{
					$jinput->set('paypalsuccess',null);
				}
				$model = new DdcshopboxModelsShopcart();
				$row =$model->storeCartData($this->data);
				$return['success'] = true;
				$return['login'] = 1;
				$return['result'] = $row;

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
