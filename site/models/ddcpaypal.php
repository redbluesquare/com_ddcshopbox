<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
use PayPal\Rest\ApiContext;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Item;
use PayPal\Api\ShippingCost;
use PayPal\Api\ItemList;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;


class DdcshopboxModelsDdcpaypal extends DdcshopboxModelsDefault
{

  /**
  * Protected fields
  **/
  var $_query			= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 0;
  var $_session			= null;
  var $_params			= null;
  var $_app				= null;
  
  protected $messages;	
  
  
  function __construct()
  {
  	$this->_app = JFactory::getApplication();
  	$this->_session = JFactory::getSession();
  	$this->_params = JComponentHelper::getParams('com_ddcshopbox');
	$this->_query = $this->_app->input->get('query', null);
	$this->_cat_id = $this->_app->input->get('id', null);
	
	
  	  	
    parent::__construct();       
  }
    
  
  /**
   * Paypal function to make payments
   * 
   * 
   */
  public function createPaypalPayment($paymentDetails = array())
  {
  	$date = date("Y-m-d H:i:s");
  if($this->_params->get('payment_mode')=="live")
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('payment_clientid'),
  					$this->_params->get('payment_client_secret')
  			)
  		);
  	}
  	else
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('payment_clientid_sandbox'),
  					$this->_params->get('payment_client_secret_sandbox')
  			)
  		);
  	}
  	$api->setConfig([
  			'mode' => $this->_params->get('payment_mode'),
  			'log.FileName' => JPATH_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'PayPal.log',
  			'http.ConnectionTimeOut' => 100,
  			'log.LogEnabled' => false,
  			'log.LogLevel' => 'FINE',
  			'validation.level' => 'log'
  			]);
  	
  	$payer = new Payer();
  	$payer->setPaymentMethod($this->_params->get('paymentmethod_name'));
  	
  	$payment = new Payment();
  	$redirecturls = new RedirectUrls();
  	
  	$shopcart = new DdcshopboxModelsShopcart();
  	$paymentDetails = $shopcart->listItems();
  	$id = strtoupper('ddcshopbox').$paymentDetails[0]->ddc_shoppingcart_header_id;
  	$descriptions = array();
  	$quantities = array();
  	$costs = array();
  	$shipping = $paymentDetails[0]->shipping_cost;
  	for($i=0;$i<count($paymentDetails);$i++)
  	{
  	array_push($descriptions, $paymentDetails[$i]->product_name);
  			array_push($quantities, $paymentDetails[$i]->product_quantity);
	  		array_push($costs,$paymentDetails[$i]->product_price);
  	}
  	$subtotal = 0.00;
  	
  	$currency = $this->_params->get('ddc_currency');
  	
  	$url = JRoute::_('index.php?option=com_ddcshopbox$view=shopcart');
  	
	  	for($i=0;$i<count($paymentDetails);$i++)
  		  	{
  		  	$items[$i] = new Item();
  		  	$items[$i]->setPrice(number_format(($costs[$i]),2));
  		  	$subtotal = $subtotal+(($costs[$i]*$quantities[$i]));
  		  	$items[$i]->setName(substr($descriptions[$i],0,60));
  		  	$items[$i]->setQuantity((int)$quantities[$i]);
  		  	$items[$i]->setCurrency($currency);
  	}
  	
  	$itemList = new ItemList();
  	$itemList->setItems($items);
  	$itemList->setShippingMethod('Standard');
  	
  	$details = new Details();
  	$details->setSubtotal(number_format($subtotal,2));
  	$details->setShipping(number_format($shipping,2));
  	
  	
  	$amount = new Amount();
  	$amount->setTotal($subtotal+$shipping)
  	->setCurrency($currency)
  	->setDetails($details);
  	
  	$transaction = new Transaction();
  	$transaction->setAmount($amount)
  	->setItemList($itemList)
  	->setInvoiceNumber($id);
  	
  	if($this->_params->get('payment_mode')=="live")
  	{
  		$redirecturls->setReturnUrl($this->_params->get('payment_success_url'))
  			->setCancelUrl($this->_params->get('payment_cancel_url'));
  	}
  	else 
  	{
  		$redirecturls->setReturnUrl($this->_params->get('payment_success_url_sandbox'))
  		->setCancelUrl($this->_params->get('payment_cancel_url_sandbox'));
  	}
  	
  	
  	$payment->setIntent('sale')
  	->setPayer($payer)
	  		->setTransactions([$transaction])
  			  	->setRedirectUrls($redirecturls);
  	
  	try {
	  	$payment->create($api);
  	
  		//store transaction details
  		$paymentId = $payment->getId();
  		$this->_session->set('paymentId',$paymentId);
  		$tokendata = json_encode(array('paypal_hash' => md5($payment->getId())));
  		
  		//Store paypal payment information into #__ddc_payments table
  		$db = JFactory::getDBO();
  		$query = $db->getQuery(TRUE);
  		$query->select('p.*')
  		->from('#__ddc_payments as p')
  		->where('(p.ref = "ddcshopbox") And (p.ref_id = '.$paymentDetails[0]->ddc_shoppingcart_header_id.')');
  		$db->setQuery($query);
  		$payitem = $db->loadObject();
  		
  		if(($payitem->ref=='ddcshopbox') || ($payitem->ref_id!=$paymentDetails[0]->ddc_shoppingcart_header_id))
  		{
	  		$db = JFactory::getDBO();
	  		$query = $db->getQuery(TRUE);
	  		$columns = array('ref','ref_id', 'token', 'state', 'created', 'modified', 'created_by', 'modified_by');
	  		$values = array($db->quote('ddcshopbox'),$paymentDetails[0]->ddc_shoppingcart_header_id,$db->quote($tokendata),0,$db->quote($date),$db->quote($date),0,0);
	  		$query
	  		->insert($db->quoteName('#__ddc_payments'))
	  		->columns($db->quoteName($columns))
	  		->values(implode(',', $values));
	  		$db->setQuery($query);
	  		$db->execute();
  		}
  	
  	}
  	catch(PayPalConnectionException $e)
  	{
  		if (count($e))
  		{
  			JError::raiseError(500, implode('<br />', 'Error2 '.$e->getMessage()));
  			return false;
  		}
  	
  	}
  	
  	$approvalUrl = $payment->getApprovalLink();
  	$this->_app->redirect($approvalUrl);
  }
  	
  
  
  public function makePaypalPayment()
  {
  	$date = date("Y-m-d H:i:s");
  	if($this->_params->get('payment_mode')=="live")
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('payment_clientid'),
  					$this->_params->get('payment_client_secret')
  			)
  		);
  	}
  	else
  	{
  		$api = new ApiContext(
  			new OAuthTokenCredential(
  					$this->_params->get('payment_clientid_sandbox'),
  					$this->_params->get('payment_client_secret_sandbox')
  			)
  		);
  	}
  	
  	$api->setConfig([
  			'mode' => $this->_params->get('payment_mode'),
  			'log.FileName' => JPATH_ROOT.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'PayPal.log',
  			'http.ConnectionTimeOut' => 100,
  			'log.LogEnabled' => false,
  			'log.LogLevel' => 'FINE',
  			'validation.level' => 'log'
  			]);
  	$paymentId = $this->_app->input->get('paymentId',null);
  	$PayerID = $this->_app->input->get('PayerID',null);
  	$token = $this->_app->input->get('token',null);
  	
  	if($token!=null)
  	{
  		$tokendata = json_encode(array('paypal_hash' => md5($paymentId)));

  		//Get paypal payment information from #__ddc_payments table
  		$db = JFactory::getDBO();
  		$query = $db->getQuery(TRUE);
  		$query->select('p.*')
  			->from('#__ddc_payments as p')
  			->where("(p.ref = 'ddcshopbox') And (p.token = '".$tokendata."')");
  		$db->setQuery($query);
  		$payitem = $db->loadObject();
  		$this->_session->set('shoppingcart_header_id',$payitem->ref_id);
  		
  		//Check if payment state is 0 then update payment details
  		if($payitem->state == 0)
  		{
  			$tokendata = json_decode($payitem->token, true);
  			$tokendata = array_merge($tokendata, array('token'=>$token,'PayerID'=>$PayerID));
  			$db = JFactory::getDBO();
  			$query = $db->getQuery(TRUE);
  			// Fields to update.
  			$fields = array(
  					$db->quoteName('state') . ' = 1',
  					$db->quoteName('token') . ' = '.$db->quote(json_encode($tokendata)),
  					$db->quoteName('modified') . ' = ' . $db->quote($date)
  				);
  			$conditions = array(
  							$db->quoteName('ref') . ' = '.$db->quote('ddcshopbox'),
  							$db->quoteName('ref_id') . ' = ' . $payitem->ref_id);
  			$query->update($db->quoteName('#__ddc_payments'))->set($fields)->where($conditions);
  			$db->setQuery($query);
  			$result = $db->execute();
  		}
  		
   		
   		try {
   			$payment = Payment::get($paymentId,$api);
   		} catch (PayPal\Exception\PayPalConnectionException $ex) {
   			echo $ex->getCode(); // Prints the Error Code
   			echo $ex->getData(); // Prints the detailed error message
   			die($ex);
   		} catch (Exception $ex) {
   			die($ex);
   		}
   		
   		
   		$execute = new PaymentExecution();
   		$execute->setPayerId($PayerID);
  		
   		try {
   			$payment->execute($execute,$api);
   		} catch (PayPal\Exception\PayPalConnectionException $ex) {
   			echo $ex->getCode(); // Prints the Error Code
   			echo $ex->getData(); // Prints the detailed error message
   			die($ex);
   		} catch (Exception $ex) {
   			die($ex);
   		}
   		
   		

   		$db = JFactory::getDBO();
   		$query = $db->getQuery(TRUE);
   		// Fields to update.
   		$fields = array($db->quoteName('state') . ' = 2',
   				$db->quoteName('modified') . ' = ' . $db->quote($date)
   		);
   		
   		// Conditions for which records should be updated.
   		$conditions = array(
   				$db->quoteName('ref') . ' = '.$db->quote('ddcshopbox'),
   				$db->quoteName('token') . ' = ' . $db->quote(json_encode($tokendata))
   		);
   		$query->update($db->quoteName('#__ddc_payments'))->set($fields)->where($conditions);
   		$db->setQuery($query);
   		$result = $db->execute();
   		
   		$db = JFactory::getDBO();
   		$query = $db->getQuery(TRUE);
   		// Fields to update.
   		$fields = array($db->quoteName('state') . ' = 4',$db->quoteName('modified_on'). ' = '.$db->quote($date));
   		
   		// Conditions for which records should be updated.
   		$conditions = array(
   				$db->quoteName('ddc_shoppingcart_header_id') . ' = '.$this->_session->get('shoppingcart_header_id',null)
   		);
   		$query->update($db->quoteName('#__ddc_shoppingcart_headers'))->set($fields)->where($conditions);
   		$db->setQuery($query);
   		$result = $db->execute();
   		echo "Thank you, your payment is complete. ";
   		echo '<a href="'.JUri::root().'">Click here</a> to return to the homepage.';
   		$this->_session->clear('shoppingcart_header_id');
   		//$url = 'index.php?option=com_ddcshopbox&view=shopcart&layout=complete&shoppingcart_header_id='.$this->_session->get('shoppingcart_header_id',null);
   		//$this->_app->redirect($url, JText::_('COM_DDC_PAYMENT_COMPLETE'));
  	}
  }

}