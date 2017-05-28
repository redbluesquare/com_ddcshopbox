<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
use Stripe\Charge;
use Stripe\Order;
use Stripe\Stripe;
use Stripe\Customer;


class DdcshopboxModelsDdcstripe extends DdcshopboxModelsDefault
{

	/**
	* Protected fields
	**/
	var $_query			= null;
	var $_cat_id		= null;
	var $_pagination  	= null;
	var $_published   	= 1;
	var $_session		= null;
	var $_params		= null;
	var $_app			= null;
	var $_data			= null;
	var $_user_id		= null;
  
	protected $messages;	
  
  
	function __construct()
	{
		$this->_app = JFactory::getApplication();
		$this->_session = JFactory::getSession();
		$this->_params = JComponentHelper::getParams('com_ddcshopbox');
		$this->_query = $this->_app->input->get('query', null);
		$jinput = JFactory::getApplication()->input;
		$this->_data = $jinput->get('jform', array(),'array');
		if(isset($this->_data['payment_method']))
		{
			$this->_payment_method_id = $this->_data['payment_method'];
		}else{
			$this->_payment_method_id = null;
		}
		//If no User ID is set to current logged in user
		$this->_user_id = JFactory::getUser()->id;
		parent::__construct();       
	}
	
	protected function _buildQuery()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(TRUE);
	
		$query->select('pm.*');
		$query->from('#__ddc_paymentmethods as pm');
		return $query;
	}
    
	protected function _buildWhere(&$query, $id = null)
	{
		if($this->_payment_method_id!=null)
		{
			$query->where('pm.ddc_paymentmethod_id = "'. (int)$this->_payment_method_id .'"');
		}
		if($id!=null)
		{
			$query->where('pm.ddc_paymentmethod_id = "'. (int)$id .'"');
		}
		if($this->_published!=null)
		{
			//$query->where('pm.published < "'.(int)$this->_published.'"');
		}
		 
		return $query;
	}
  
  public function isStripeCustomer()
  {
  	 
  	//check if customer exists
  	$db = JFactory::getDBO();
  	$query = $db->getQuery(TRUE);
  	$query->select('up.profile_value')
  		->from('#__user_profiles as up')
  		->where('(up.profile_key = "stripe.customer") AND (up.user_id = "'.(int)$this->_user_id.'")');
  	$db->setQuery($query);
  	$result = $db->loadObject();
  	if($result==null)
  	{
  		return false;
  	}
  	else
  	{
  		return true;
  	} 
  }
  
  public function getStripeCustomer()
  {
  	//get customer stripe account number
  	$db = JFactory::getDBO();
  	$query = $db->getQuery(TRUE);
  	$query->select('up.profile_value')
  		->from('#__user_profiles as up')
  		->where('(up.profile_key = "stripe.customer") AND (up.user_id = "'.(int)$this->_user_id.'")');
  	$db->setQuery($query);
  	$dbCustomer = $db->loadObject();
  	return $dbCustomer;

  }
  
  public function createStripeCustomer($stripeCustomerToken = null)
  {
  	//check if customer exists
  	if(!$this->isStripeCustomer())
  	{
  		$stripe = new Stripe();
  		$ddcstripe = new DdcshopboxModelsDdcstripe();
  		//get secret #shh don't tell
  		$pm = $ddcstripe->getItem();
  		if($this->getpartjsonfield($pm->payment_params,'paymentmethod_mode')=='live')
  		{
  			$api_secret = 'api_secret';
  		}
  		else 
  		{
  			$api_secret = 'test_api_secret';
  		}
  		$apiKey = $this->getpartjsonfield($pm->payment_params, $api_secret);
  		$stripe->setApiKey($apiKey);
  		$sCustomer = new Customer();
  		try
  		{
  			$response = $sCustomer->create(array(
  					"description" => "Customer for ".$this->_data['email_to'],
  					"email" => $this->_data['email_to'],
  					"source" => $this->_data['stripeToken'] // obtained with Stripe.js
  			));
  		}
  		catch(Exception $e)
  		{
  			$return['msg'] = $e->getMessage();
  		}
  		if(isset($response->id))
  		{
  			//get customer variable back and save to db
  			$data = array('stripeCustomerToken' => $response->id,
  				'stripeCustomerBrand' => $response->sources->data[0]->brand,
  				'stripeCustomerExp_month' => $response->sources->data[0]->exp_month,
  				'stripeCustomerExp_year' => $response->sources->data[0]->exp_year,
  				'stripeCustomerlast4' => $response->sources->data[0]->last4
  			);
  			//add customer value to #__user_profiles table
  			// Get a db connection.
  			$db = JFactory::getDbo();
  			// Create a new query object.
  			$query = $db->getQuery(true);
  			// Insert columns.
  			$columns = array('user_id', 'profile_key', 'profile_value', 'ordering');
  			// Insert values.
  			$values = array($this->_user_id, $db->quote('stripe.customer'), $db->quote(json_encode($data)), 1);
  			// Prepare the insert query.
  			$query
  				->insert($db->quoteName('#__user_profiles'))
  				->columns($db->quoteName($columns))
  				->values(implode(',', $values));
  			// Set the query using our newly populated query object and execute it.
  			$db->setQuery($query);
  			$return['result'] = $db->execute();
  		}
  		else
  		{
  			$return['result'] = false;
  		}
  		return $return;
   	}
  	else 
  	{
  		return false;
  	}
  }
  
  public function updateStripeCustomer()
  {
  	$dbCustomer = $this->getStripeCustomer();
  	$stripeCustomerToken = json_decode($dbCustomer->profile_value);
  	$stripeCustomerToken = $stripeCustomerToken->stripeCustomerToken;
  	//load Stripe model
  	$stripe = new Stripe();
  	$ddcstripe = new DdcshopboxModelsDdcstripe();
  	//get secret #shh don't tell
  	$pm = $ddcstripe->getItem(2);
  	if($this->getpartjsonfield($pm->payment_params,'paymentmethod_mode')=='live')
  		{
  			$api_secret = 'api_secret';
  		}
  		else 
  		{
  			$api_secret = 'test_api_secret';
  		}
  		$pm = $ddcstripe->getItem();
  		$apiKey = $this->getpartjsonfield($pm->payment_params, $api_secret);
  	$stripe->setApiKey($apiKey);
  	//Initialise the Stripe customer class
  	$customer = new Customer();
	$response = $customer->retrieve($stripeCustomerToken);
  	$response->delete();
  	// Get a db connection.
  	$db = JFactory::getDbo();
	// Create a new query object.
	$query = $db->getQuery(true);
	// delete all custom keys for the user.
	$conditions = array(
	    $db->quoteName('user_id') . ' = '.(int)$this->_user_id, 
	    $db->quoteName('profile_key') . ' = ' . $db->quote('stripe.customer')
	);
	$query->delete($db->quoteName('#__user_profiles'));
	$query->where($conditions);
	// Set the query using our newly populated query object and execute it.
	$db->setQuery($query);
	$result = $db->execute();

  	$result = $this->createStripeCustomer();
  	return $result;
  }
  	
  public function chargeStripeCustomer()
  {
  	//Get the shopping cart details
  	$shopcart = new DdcshopboxModelsShopcart();
  	$paymentDetails = $shopcart->listItems();
  	$id = strtoupper('ddcshopbox').$paymentDetails[0]->ddc_shoppingcart_header_id;
  	//$descriptions = array();
  	$quantities = array();
  	$costs = array();
  	$shipping = $paymentDetails[0]->shipping_cost;
  	$shipping_discount = $paymentDetails[0]->coupon_value;
  	for($i=0;$i<count($paymentDetails);$i++)
  	{
  		//array_push($descriptions, $paymentDetails[$i]->vendor_product_name);
  		array_push($quantities, $paymentDetails[$i]->product_quantity);
  		array_push($costs,$paymentDetails[$i]->product_price);
  	}
  	$subtotal = 0;
  	$currency = $this->_params->get('ddc_currency');
  	$url = JRoute::_('index.php?option=com_ddcshopbox$view=shopcart');
	for($i=0;$i<count($paymentDetails);$i++)
    {
    	$subtotal = $subtotal+(($costs[$i]*$quantities[$i]));
    }
    	 
    	$response = null;
    	//load Stripe model
    	$stripe = new Stripe();
    	$ddcstripe = new DdcshopboxModelsDdcstripe();
    	//get secret #shh don't tell
    	$pm = $ddcstripe->getItem();
    	if($this->getpartjsonfield($pm->payment_params,'paymentmethod_mode')=='live')
  		{
  			$api_secret = 'api_secret';
  		}
  		else 
  		{
  			$api_secret = 'test_api_secret';
  		}
  		$apiKey = $this->getpartjsonfield($pm->payment_params, $api_secret);;
  		$stripe->setApiKey($apiKey);
    	//get the customer
    	$dbCustomer = $this->getStripeCustomer();
  		$stripeCustomerToken = json_decode($dbCustomer->profile_value);
  		$stripeCustomerToken = $stripeCustomerToken->stripeCustomerToken;
    	//create the payment charge
    	$sCharge = new Charge();
    	$response = $sCharge->create(array(
    			"amount" => ($subtotal+$shipping-$shipping_discount)*100,
    			"currency" => 'gbp',
    			"description" => "Ushbub Shopping cart #".$paymentDetails[0]->ddc_shoppingcart_header_id,
    			"customer" => $stripeCustomerToken
    	));
  
    	if(isset($response->id))
    	{
    		//get customer variable back and save to db
    		$stripeChargeToken = $response->id;
    		$date = date("Y-m-d H:i:s");
  			//add customer value to #__user_profiles table
    		// Get a db connection.
    		$db = JFactory::getDbo();
    		// Create a new query object.
    		$query = $db->getQuery(true);
    		// Insert columns.
    		$columns = array('ref','ref_id', 'token', 'state', 'created', 'modified', 'created_by', 'modified_by');
  			// Insert values.
    		$values = array($db->quote('ddcshopbox'),$paymentDetails[0]->ddc_shoppingcart_header_id,$db->quote($stripeChargeToken),2,$db->quote($date),$db->quote($date),0,0);
    		// Prepare the insert query.
    		$query
    			->insert($db->quoteName('#__ddc_payments'))
  				->columns($db->quoteName($columns))
    			->values(implode(',', $values));
    		// Set the query using our newly populated query object and execute it.
    		$db->setQuery($query);
    		$result = $db->execute();
  
    		return true;
    	}
    }
  
	public function chargeStripePayment()
	{
		//Get the shopping cart details
  		$shopcart = new DdcshopboxModelsShopcart();
  		$paymentDetails = $shopcart->listItems();
  		$id = strtoupper('ddcshopbox').$paymentDetails[0]->ddc_shoppingcart_header_id;
  		//$descriptions = array();
  		$quantities = array();
  		$costs = array();
  		$shipping = $paymentDetails[0]->shipping_cost;
  		$shipping_discount = $paymentDetails[0]->coupon_value;
  		for($i=0;$i<count($paymentDetails);$i++)
  		{
  			//array_push($descriptions, $paymentDetails[$i]->vendor_product_name);
  			array_push($quantities, $paymentDetails[$i]->product_quantity);
  			array_push($costs,$paymentDetails[$i]->product_price);
  		}
  		$subtotal = 0;
  		$currency = $this->_params->get('ddc_currency');
  		$url = JRoute::_('index.php?option=com_ddcshopbox$view=shopcart');
		for($i=0;$i<count($paymentDetails);$i++)
    	{
    		$subtotal = $subtotal+(($costs[$i]*$quantities[$i]));
    	}
    	if($shipping_discount >($subtotal+$shipping))
    	{
    		$shipping_discount = ($subtotal+$shipping);
    	} 
    	$response = null;
    	//load Stripe model
    	$stripe = new Stripe();
    	$ddcstripe = new DdcshopboxModelsDdcstripe();
    	//get secret #shh don't tell
    	$pm = $ddcstripe->getItem();
    	if($this->getpartjsonfield($pm->payment_params,'paymentmethod_mode')=='live')
  		{
  			$api_secret = 'api_secret';
  		}
  		else 
  		{
  			$api_secret = 'test_api_secret';
  		}
  		$apiKey = $this->getpartjsonfield($pm->payment_params, $api_secret);
  		$stripe->setApiKey($apiKey);

    	//create the payment charge
    	$sCharge = new Charge();
    	$response = $sCharge->create(array(
    			"amount" => ($subtotal+$shipping-$shipping_discount)*100,
    			"currency" => 'gbp',
    			"description" => "Ushbub Shopping cart #".$paymentDetails[0]->ddc_shoppingcart_header_id,
    			"source" => $this->_data['stripeToken'] // obtained with Stripe.js
    	));
  
    	if(isset($response->id))
    	{
    		//get customer variable back and save to db
    		$stripeChargeToken = $response->id;
    		$date = date("Y-m-d H:i:s");
  			//add customer value to #__user_profiles table
    		// Get a db connection.
    		$db = JFactory::getDbo();
    		// Create a new query object.
    		$query = $db->getQuery(true);
    		// Insert columns.
    		$columns = array('ref','ref_id', 'token', 'state', 'created', 'modified', 'created_by', 'modified_by');
  			// Insert values.
    		$values = array($db->quote('ddcshopbox'),$paymentDetails[0]->ddc_shoppingcart_header_id,$db->quote($stripeChargeToken),2,$db->quote($date),$db->quote($date),0,0);
    		// Prepare the insert query.
    		$query
    			->insert($db->quoteName('#__ddc_payments'))
  				->columns($db->quoteName($columns))
    			->values(implode(',', $values));
    		// Set the query using our newly populated query object and execute it.
    		$db->setQuery($query);
    		$result = $db->execute();
  
    		return $result;
    	}
    }
}