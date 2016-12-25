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
    $this->_session = JFactory::getSession();
    $this->_shoppingcart_header_id = $this->_app->input->get('shoppingcart_header_id',$this->_session->get('shoppingcart_header_id',null));
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

    $query->select('scd.*');
    $query->select('vp.*');
    $query->select('pp.*');
    $query->select('vc.*');
    $query->select('i.*');
    $query->select('sch.*');
    $query->select('sch.state as header_state');
    $query->select('v.title,v.images,v.address1,v.address2,v.city as v_city,v.county as v_county,v.post_code as v_post_code');
    $query->from('#__ddc_shoppingcart_headers as sch');
    $query->leftJoin('#__ddc_shoppingcart_details as scd on (scd.shoppingcart_header_id = sch.ddc_shoppingcart_header_id)');
   	$query->leftJoin('#__ddc_vendor_products as vp on (vp.ddc_vendor_product_id = scd.product_id)');
    $query->leftJoin('#__ddc_images as i on (vp.ddc_vendor_product_id = i.link_id) AND (i.linked_table = "ddc_products")');
    $query->leftJoin('#__ddc_vendors as v on vp.vendor_id = v.ddc_vendor_id');
    $query->leftJoin('#__ddc_product_prices as pp on vp.ddc_vendor_product_id = pp.product_id');
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
  	else
  	{
  		$query->where('sch.session_id = "'.$this->_session->getId().'"');
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
  					'session_id' => $this->_session->getId(),
  					'table' => 'shoppingcartheaders');
  		$row = $this->store($data);
  	}
  	elseif(count($sc) > 0)
  	{
  		//Cart if does exist
  		//User clicks Continue
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
  						'session_id' => $this->_session->getId(),
  						'table' => 'shoppingcartheaders');
  			}
  			if($formdata['state'] == 3)
  			{
  				if(($formdata['address_line_1']==null) || ($formdata['town']==null) || ($formdata['post_code']==null) || ($formdata['email_to']==null) || ($formdata['first_name']==null) || ($formdata['last_name']==null))
  				{
  					$formdata['state'] = 2;
  				}
  				$data = array(
  						'ddc_shoppingcart_header_id' => $formdata['ddc_shoppingcart_header_id'],
  						'user_id' => $this->_user_id,
  						'state' => $formdata['state'],
  						'catid' => null,
  						'address_line_1' => $formdata['address_line_1'],
  						'address_line_2' => $formdata['address_line_2'],
  						'town' => $formdata['town'],
  						'county' => $formdata['county'],
  						'post_code' => $formdata['post_code'],
  						'mobile_no' => $formdata['mobile_no'],
  						'telephone_no' => $formdata['telephone_no'],
  						'email_to' => $formdata['email_to'],
  						'payment_method'=> $formdata['payment_method'],
  						'session_id' => $this->_session->getId(),
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
  					'session_id' => $this->_session->getId(),
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
  	
  	if($formdata['table']!='ddcCheckout')
  	{
  		$productFound = 0;
  		foreach($sc as $row)
  		{
  			if($row->product_id == $formdata['ddc_vendor_product_id'])
  			{
  				//product is in cart update row
  				$data = array(
  						'shoppingcart_header_id' => $row->ddc_shoppingcart_header_id,
  						'ddc_shoppingcart_detail_id' => $row->ddc_shoppingcart_detail_id,
  						'product_id' => $formdata['ddc_vendor_product_id'],
  						'product_quantity' => $row->product_quantity+$formdata['product_quantity'],
  						'session_id' => $this->_session->getId(),
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
  					'product_id' => $formdata['ddc_vendor_product_id'],
  					'product_quantity' => $formdata['product_quantity'],
  					'catid' => null,
  					'session_id' => $this->_session->getId(),
  					'table' => 'shoppingcartdetails');
  			$this->_session->set('shoppingcart_header_id',$row->ddc_shoppingcart_header_id);
  			$row = $this->store($data);
  		}
  	}
	
	return array(true,$sc[0]->header_state);
  }
  public function removeCartItem($id)
  {
  	// Get a db connection.
	$db = JFactory::getDbo();
 
	// Create a new query object.
	$query = $db->getQuery(true);
	
	// delete all custom keys for user 1001.
	$conditions = array(
			$db->quoteName('ddc_shoppingcart_detail_id') . ' = '.$id			
	);
	
	$query->delete($db->quoteName('#__ddc_shoppingcart_details'));
	$query->where($conditions);
	
	$db->setQuery($query);
	
	$result = $db->execute();
	
	return $result;
  }
  public function updateCartItem($id, $val)
  {
  	// Get a db connection.
  	$db = JFactory::getDbo();
  
  	// Create a new query object.
  	$query = $db->getQuery(true);
  	
  	// Fields to update.
  	$fields = array(
  			$db->quoteName('product_quantity') . ' = '.$val
  	);
  	
  	// delete all custom keys for user 1001.
  	$conditions = array(
  			$db->quoteName('ddc_shoppingcart_detail_id') . ' = '.$id
  	);
  
  	$query->update($db->quoteName('#__ddc_shoppingcart_details'))->set($fields)->where($conditions);
  
  	$db->setQuery($query);
  
  	$result = $db->execute();
  
  	return $result;
  }
}