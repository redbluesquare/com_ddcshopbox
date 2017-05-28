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
		
		if($this->data['table']=='shopcartdetails')
		{
				
			$model = new DdcshopboxModelsShopcartdetails();
			$row = $model->getItem();
			
			$return['success'] = true;
			$return['row'] = $row;
			
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
		else
		{

			//display view
			return parent::execute();
		}
	}
		
}
