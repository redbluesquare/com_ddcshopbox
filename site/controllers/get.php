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
		
		if($this->data['table']=='ddcshipping')
		{
				
			$model = new DdcshopboxModelsDefault();
			$from_pc = $model->isValidPostCodeFormat($this->data['from_postcode']);
			$to_pc = $model->isValidPostCodeFormat($this->data['to_postcode']);
			
			$return['success'] = true;
			$return['from_pc'] = $from_pc;
			$return['to_pc'] = $to_pc;
			
			echo json_encode($return);
		}
		
		elseif($this->data['table']=='ddcshoppingcart')
		{
			
			$model = new DdcshopboxModelsDefault();
			$result = $model->getShopCart_contents();
			if(count($result)>0)
			{
				//$this->session->clear('shoppingcart_header_id');
			}
			if($result)
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
				$return['result'] = $result;
			}
			else
			{
				$this->session->clear('shoppingcart_header_id');
				$return['msg'] = JText::_('COM_DDC_CART_EMPTY');
			}
			echo json_encode($return);	
		}
		elseif($this->data['table']=='ddcstripecustomer')
		{
			//load Stripe model
			$ddcstripe = new DdcshopboxModelsDdcstripe();
			$model = new DdcshopboxModelsDdcstripe();
			$customer = $ddcstripe->getStripeCustomer(2);
			if(count($customer)==1)
			{
				$return['cardInfo'] = json_decode($customer->profile_value);
				$return['success'] = true;
			}
			else 
			{
				$return['success'] = false;
			}
			
			echo json_encode($return);
		}
		elseif($this->data['table']=='vendorproducts')
		{
			$task = $jinput->get('task',null,'string');
			$model = new DdcshopboxModelsVendorproducts();
			if($task=='get.price')
			{
				$result = $model->getProductPrice($this->data['vendorproduct_id']);
				if($result)
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					$return['price'] = $result;
				}
				else
				{
					$return['msg'] = JText::_('COM_DDC_CART_EMPTY');
				}
			}
			echo json_encode($return);
		}
		elseif($this->data['table']=='vendors')
		{
			$task = $jinput->get('task',null,'string');
			$model = new DdcshopboxModelsVendors();
			if($task=='get.times')
			{
				$result = $model->checkTimes($this->data['vendor_id'],date('Y-m-d',strtotime($this->data['ddc_day_id'])),$this->data['ddc_service_id']);
				if($result)
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					$return['result'] = $result;
				}
				else
				{
					$return['msg'] = JText::_('COM_DDC_CART_EMPTY');
				}
			}
			echo json_encode($return);
		}
		else
		{

			//display view
			return parent::execute();
		}
	}
		
}
