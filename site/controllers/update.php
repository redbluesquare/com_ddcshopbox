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
		$return = array ("success" => false, "msgs" => null	);
		$jinput = JFactory::getApplication()->input;
		$this->session = JFactory::getSession();
		$user_id = JFactory::getUser()->id;
		$this->data = $jinput->get('jform', array(),'array');
		
		$model = new DdcshopboxModelsShopcart();
		
		if($this->data['table']=='ddcshoppingcart')
		{
			if($this->data['task']=="shoppingcart.update")
			{
				if($storecart = $model->storeCartData($this->data))
				{
					$result = $model->getShopCart_contents();
					$return['success'] = $storecart[0];
					$return['locationset'] = $storecart[1];
					$return['msg'] = $storecart[2];
					$return['result'] = $result;
					$return['msgs'] = $storecart[3];
				}
				else
				{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			
			echo json_encode($return);
			
		}
		elseif($this->data['table']=='coupon')
		{
			$couponModel = new DdcshopboxModelsCoupons();
			if($couponresult = $couponModel->updateCoupon($this->data))
			{
				$return['success'] = $couponresult[0];
				$return['couponcode'] = $couponresult[1];
				$return['result'] = $couponresult[2];
				$return['msg'] = $couponresult[3];
			}
			else
			{
				$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
			}	
			echo json_encode($return);
				
		}
		elseif($this->data['table']=='uservendorinterests')
		{
			$uviModel = new DdcshopboxModelsUservendorinterests();
			if(!$uviModel->checkUserVendorInterests($this->data['vendor_id'],JFactory::getUser()->id))
			{
				if($uviresult = $uviModel->store($this->data))
				{
					$return['success'] = true;
					$return['counter'] = count($uviModel->listItems($this->data['vendor_id']));
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
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
					if($jinput->get('paypalsuccess',null)=='true')
					{
						$model = new DdcshopboxModelsDdcpaypal();
						$model->makePaypalPayment();
					}
					else
					{
						$return['success'] = true;
						$return['login'] = 1;
						$return['result'] = $row;
						echo json_encode($return);
					}
				}
				else
				{
					// Add a message to the message queue
					$app->enqueueMessage(JText::_('COM_DDC_ERROR_NOT_ALL_REQUIRED_FIELDS_ENTERED'), 'error');
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
				if($row = $model->updateCartItem($this->data['ddc_shoppingcart_detail_id'], array($this->data['product_quantity'],$this->data['product_price'])))
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
