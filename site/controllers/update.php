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
		// Get the document object.
		$document = JFactory::getDocument();
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
			if($jinput->get('paypalsuccess',null)=='false')
			{
				$jinput->set('paypalsuccess',null);
			}
			$model = new DdcshopboxModelsShopcart();
			if($row = $model->storeCartData($this->data))
			{
				$return['success'] = true;
				$return['login'] = 1;
				$return['result'] = $row;
				echo json_encode($return);
			}
			else
			{
				$viewName = $app->input->getWord('view', 'shopcart');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
				//display view
				return parent::execute();
			}
			
		}
		elseif($app->input->getMethod()=='DELETE')
		{
			if($this->data['table']=='shopcartdetails')
			{
				$model = new DdcshopboxModelsShopcart();
				if($model->removeCartItem($this->data['ddc_shoppingcart_detail_id']))
				{
					$return['success'] = true;
				}
				else 
				{
					$return['success'] = false;
				}
				echo json_encode($return);
			}
		}
		elseif($app->input->getMethod()=='UPDATE')
		{
			if($this->data['table']=='shopcartdetails')
			{
				$model = new DdcshopboxModelsShopcart();
				if($row = $model->updateCartItem($this->data['ddc_shoppingcart_detail_id'], $this->data['product_quantity']))
				{
					$return['success'] = true;
					$return['product_quantity'] = $row;
				}
				else
				{
					$return['success'] = false;
				}
				echo json_encode($return);
			}
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
