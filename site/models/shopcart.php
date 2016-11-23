<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

class DdcshopboxModelsShopcart extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     				= null;
  	var $_product_id  				= null;
  	var $_vendor_id  				= null;
  	var $_cat_id	  				= null;
  	var $_published   				= 4;
  	var $_session					= null;
  	var $_shoppingcart_header_id 	= null;
  	var $_params					= null;
  	var $_app						= null;

  function __construct()
  {


    
    $this->_app = JFactory::getApplication();
    
    //If no User ID is set to current logged in user
    $this->_user_id = $this->_app->input->get('profile_id', JFactory::getUser()->id);
    $this->_product_id = $this->_app->input->get('product_id', null);
    $this->_vendor_id = $this->_app->input->get('vendor_id', null);
    $this->_shoppingcart_header_id = $this->_app->input->get('shoppingcart_header_id',null);
    $this->_session = JFactory::getSession();
    $this->_params = JComponentHelper::getParams('com_ddcshopbox');
    if($this->_app->input->get('shopcart_state', null)!= null)
    {
    	$this->_published = $this->_app->input->get('shopcart_state', null);
    }

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('sch.*');
    $query->select('sch.state as header_state');
    $query->select('scd.*');
    $query->select('p.*');
    $query->select('pp.*');
    $query->select('vc.*');
    //$query->select('i.*');
    //$query->select('v.*');
    $query->from('#__ddc_shoppingcart_headers as sch');
    $query->leftJoin('#__ddc_shoppingcart_details as scd on (scd.shoppingcart_header_id = sch.ddc_shoppingcart_header_id)');
   	$query->leftJoin('#__ddc_products as p on (p.ddc_product_id = scd.product_id)');
    //$query->rightJoin('#__ddc_images as i on (p.ddc_product_id = i.link_id) AND (i.linked_table = "ddc_products")');
    //$query->rightJoin('#__ddc_vendors as v on p.vendor_id = v.ddc_vendor_id');
    $query->leftJoin('#__ddc_product_prices as pp on p.ddc_product_id = pp.product_id');
    $query->rightJoin('#__ddc_currencies as vc on vc.ddc_currency_id = pp.product_currency');
    $query->group("scd.product_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
  	if($this->_shoppingcart_header_id!=null)
  	{
  		$query->where('sch.ddc_shoppingcart_header_id = "'. (int)$this->_shoppingcart_header_id .'"');
  	}
  	if($this->_user_id != 0)
  	{
  		$query->where('((sch.user_id = "'. (int)$this->_user_id .'") Or (sch.ddc_shoppingcart_header_id = "'.(int)$this->_session->get('shoppingcart_header_id',null).'"))');
  	}
  	
  	if($this->_product_id!=null)
  	{
  		$query->where('scd.product_id = "'. (int)$this->_product_id .'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('sch.state < "'.(int)$this->_published.'"');
  	}

  	if($this->_user_id == 0)
  	{
  		$query->where('sch.ddc_shoppingcart_header_id = "'.(int)$this->_session->get('shoppingcart_header_id',null).'"');
  	}
  	
    return $query;
  }

  
  public function storeCartData($formdata = null)
  {
  	// TODO shopping cart

  	//Get form data
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	//Is there a shopping cart setup?
  	$sc = $this->listItems();
  	if(count($sc) == 0)
  	{
  		//Setup cart if does not exist
  		$data = array(
  					'user_id' => $this->_user_id,
  					'state' => 1,
  					'catid' => null,
  					'table' => 'shoppingcartheaders');
  		$row = $this->store($data);
  	}
  	elseif(count($sc) > 0)
  	{
  		//Setup cart if does not exist
  		if($formdata['table']=='ddcCheckout')
  		{
  			if($formdata['state'] == 2)
  			{
  				$data = array(
  						'ddc_shoppingcart_header_id' => $formdata['ddc_shoppingcart_header_id'],
  						'user_id' => $this->_user_id,
  						'state' => $formdata['state'],
  						'catid' => null,
  						'delivery_type' => $formdata['shipping_method'],
  						'shipping_cost' => $formdata['delivery_price'],
  						'table' => 'shoppingcartheaders');
  			}
  			if($formdata['state'] == 3)
  			{
  				$data = array(
  						'ddc_shoppingcart_header_id' => $formdata['ddc_shoppingcart_header_id'],
  						'user_id' => $this->_user_id,
  						'state' => $formdata['state'],
  						'catid' => null,
  						'payment_method'=> $formdata['payment_method'],
  						'table' => 'shoppingcartheaders');
  			}			
  		}
  		else 
  		{
  			$data = array(
  					'ddc_shoppingcart_header_id' => $formdata['ddc_shoppingcart_header_id'],
  					'user_id' => $this->_user_id,
  					'state' => 1,
  					'catid' => null,
  					'table' => 'shoppingcartheaders');
  		}
  		$row = $this->store($data);
  		
  		$paypal = new DdcshopboxModelsDdcpaypal();
  		$paypallogo = $this->_params->get('payment_logo');
  		$sc = $this->listItems();
  		if($sc[0]->header_state==3)
  		{
  			if($this->_app->input->get('paypalsuccess',null)==="false")
  			{
  				echo JText::_('COM_DDC_PAYMENT_CANCELLED')."<br>";
  				echo '<a href="'.JUri::root().'index.php?option=com_ddcshopcart&view=shopcart">
					<img src="'.$paypallogo.'" style="height:80px;" /></a>';
  			}
  			elseif($this->_app->input->get('paypalsuccess',null)==="true")
  			{
  				if($sc[0]->header_state==3)
  				{
  					$paypal->makePaypalPayment();
  				}
  			}
  			elseif($this->_app->input->get('paypalsuccess',null)===null)
  			{
  				if($sc[0]->header_state==3){
  					$paypal->createPaypalPayment();
  				}
  			}
  		}

  	}
  	$productFound = 0;
  	if($formdata['table']!='ddcCheckout')
  	{
  		foreach($sc as $row)
  		{
  			if($row->product_id == $formdata['ddc_product_id'])
  			{
  				//product is in cart update row
  				$data = array(
  						'shoppingcart_header_id' => $row->ddc_shoppingcart_header_id,
  						'ddc_shoppingcart_detail_id' => $row->ddc_shoppingcart_detail_id,
  						'product_id' => $formdata['ddc_product_id'],
  						'product_quantity' => $row->product_quantity+$formdata['product_quantity'],
  						'table' => 'shoppingcartdetails');
  				$this->_session->set('shoppingcart_header_id',$row->ddc_shoppingcart_header_id);
  				$row = $this->store($data);
  				$productFound = 1;
  			}
  		}
  		if($productFound == 0)
  		{
  			//product not in cart insert row
  			$data = array(
  					'shoppingcart_header_id' => $row->ddc_shoppingcart_header_id,
  					'product_id' => $formdata['ddc_product_id'],
  					'product_quantity' => $formdata['product_quantity'],
  					'catid' => null,
  					'table' => 'shoppingcartdetails');
  			$this->_session->set('shoppingcart_header_id',$row->ddc_shoppingcart_header_id);
  			$row = $this->store($data);
  		}
  	}
	
	return array(true,$sc[0]->header_state);

  	
  }

}