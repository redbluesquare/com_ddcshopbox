<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsServiceheaders extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     				= null;
  	var $_vendor_id  				= null;
  	var $_app		  				= null;
  	var $_data						= null;
  	var $_cat_id	  				= null;
  	var $_session					= null;
  	var $_service_header_id			= null;
  	var $_service_detail_id			= null;
  	var $_published   				= 1;

  function __construct()
  {

    $this->_app = JFactory::getApplication();

    $this->_vendor_id = $this->_app->input->get('vendor_id', null);
    $this->_session = JFactory::getSession();
  	$this->_service_header_id = $this->_session->get('service_header_id',null);
  	if($this->_service_header_id == null)
  	{
  		$this->_service_header_id = $this->_app->input->get('service_header_id',null);
  	}
  	$this->_data = $this->_app->input->get('jform', array(),'array');

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('sh.*');
    $query->select('u.*');
    $query->select('v.title, v.address1, v.address2, v.city, v.county, v.post_code, v.ddc_vendor_id,v.images');
    $query->from('#__ddc_service_headers as sh');
    $query->leftJoin('#__ddc_vendors as v on v.ddc_vendor_id = sh.vendor_id');
    $query->leftJoin('#__users as u on u.id = v.owner');
    $query->group('sh.ddc_service_header_id');

    return $query;
  }

  protected function _buildWhere(&$query,$bookDate = null,$time = array())
  {
    if($this->_service_header_id!=null)
    {
    	$query->where('sh.ddc_service_header_id = "'. (int)$this->_service_header_id .'"');
    }
    if($bookDate!=null)
    {
    	$query->where('sh.book_date = "'. $bookDate .'"');
    }
    if($time!=array())
    {
    	$query->where('(("'.$time[0].'" between sh.planned_start_time AND sh.planned_end_time) Or ("'.$time[1].'" between sh.planned_start_time AND sh.planned_end_time))');
    }
        
    return $query;
  }
  
	public function store($formdata = null)
 	{
 		
  		$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  		$vpModel = new DdcshopboxModelsVendorproducts();
  		$product = $vpModel->getItem($formdata['ddc_service_id']);
  		$start_time = date('H:i:s',strtotime($formdata['ddc_el2_id'].':00:00'));
  		if($product->product_base_uom==6)
  		{
  			$end_time = strtotime('+'.$this->getpartjsonfield($product->product_params, 'product_box').' hours',strtotime($start_time))-1;
  			$end_time = date('H:i:s',$end_time);
  		}
  		elseif($product->product_base_uom==5)
  		{
  			$end_time = strtotime('+'.$this->getpartjsonfield($product->product_params, 'product_box').' minutes',strtotime($start_time))-1;
  			$end_time = date('H:i:s',$end_time);
  		}
  		$data = array(
  				'ddc_service_header_id'=>$formdata['ddc_service_header_id'],
  				'vendor_id' => $formdata['vendorid'],
  				'session_id' => $this->_session->getId(),
  				'first_name' => $formdata['first_name'],
  				'last_name' => $formdata['last_name'],
  				'payment_method' => $formdata['payment_method'],
  				'email_to' => $formdata['email_to'],
  				'mobile_no' => $formdata['mobile'],
  				'book_date' => JHtml::date($formdata['ddc_day_id'],'Y-m-d'),
  				'planned_start_time' => $start_time,
  				'planned_end_time' => $end_time,
  				'actual_start_time' => '',
  				'actual_end_time' => '',
  				'catid' => '',
  				'state' => 1,
  				'table' => 'serviceheaders');
  		
  		
  		return parent::store($data);
  	}
  	
  	public function storePayment($vendor,$ddc_service_header_id)
  	{
  		//Get form data
  		$formdata = JRequest::getVar('jform', array(), 'post', 'array');
  		if(isset($formdata['payment_method']) && ($formdata['payment_method']==2))
  		{
  			$ddcstripe = new DdcshopboxModelsDdcstripe();
  			$ddcprofile = new DdcshopboxModelsProfiles();
  			$user_id = 0;
  			//check if logged in
  			if(JFactory::getUser()->id!=0)
  			{
  				//user logged in
  				$user_id = JFactory::getUser()->id;
  				//check if user is setup as stripe customer
  				if($ddcstripe->isStripeCustomer())
  				{
  					if($formdata['stripeCusToken']=='false')
  					{
  						$ddcstripe->updateStripeCustomer();
  					}
  			  	
  					$dbCustomer = $ddcstripe->getStripeCustomer();
  					$stripeCustomerToken = json_decode($dbCustomer->profile_value);
  		
  					//save payment for later
  					$result = $this->storePaymentForLater($vendor,$ddc_service_header_id,$stripeCustomerToken->stripeCustomerToken);
  					return $result;
  				}
  				else
  				{
  					//convert token to customer token and save
  					$return = $ddcstripe->createStripeCustomer();
  								
  					$dbCustomer = $ddcstripe->getStripeCustomer();
  					$stripeCustomerToken = json_decode($dbCustomer->profile_value);
  					//save payment for later
  					$result = $this->storePaymentForLater($vendor,$ddc_service_header_id,$stripeCustomerToken->stripeCustomerToken);
  					return $result;
  				}
  			}
  			else
  			{
  				//save payment for later
  				$result = $this->storePaymentForLater($vendor,$ddc_service_header_id);
  				return $result;
  			}
  		}
  		else {
  			$result = $this->storePaymentForLater($vendor,$ddc_service_header_id,"pay by cash");
  			return $result;
  		}
  	}
  	
  	public function storePaymentForLater($ref, $ref_id,$stripeChargeToken = null)
  	{
  		//get customer variable back and save to db
  		if($stripeChargeToken==null)
  		{
  			$stripeChargeToken = $this->_data['stripeToken'];
  		}
  		$date = date("Y-m-d H:i:s");
  		//add customer value to #__user_profiles table
  		// Get a db connection.
  		$db = JFactory::getDbo();
  		// Create a new query object.
  		$query = $db->getQuery(true);
  		// Insert columns.
  		$columns = array('ref','ref_id', 'token', 'state', 'created', 'modified', 'created_by', 'modified_by');
  		// Insert values.
  		$values = array($db->quote($ref),$ref_id,$db->quote($stripeChargeToken),1,$db->quote($date),$db->quote($date),0,0);
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
  	
  	public function getService($id)
  	{
  		$this->_app->input->set('service_header_id',$id);
  		$serviceModel = new DdcshopboxModelsServiceheaders();
  		$service = $serviceModel->getItem();
  		$serviceDModel = new DdcshopboxModelsServicedetails();
  		$serviceD = $serviceDModel->getItem();
  		$img = JRoute::_($service->images);
  		$emailheader = JText::_('COM_DDC_BOOKING_CONFIRMATION');
  		$appointmentDate = JHtml::date($service->book_date,'D, d M Y');
  		$appointmentTime = JHtml::date($service->planned_start_time,'H:i');
  		$message_header = <<<EOT
  		<div style="width:800px; box-shadow:#ccc 0px 0px 5px;">
  			<div style="background:#262262;display:block;color:#F399C0;padding:1px;">
  			<img src="$img" style="float:left;height:50px;padding:2px 20px 1px 20px;border-radius:5px;" vspace="9" />
  			<h1 style="">$service->title</h1></div>
			<div style="background:#ffffff;display:block;padding:10px;"><h2>$emailheader</h2><hr />
			<table><tbody>
			<tr><td style="width:200px;padding-top:5px;">Full Name: </td><td style="padding-top:5px;">$service->first_name $service->last_name</td></tr>
  			<tr><td style="width:200px;padding-top:5px;">Service: </td><td style="padding-top:5px;">$serviceD->vendor_product_name</td></tr>
  			<tr><td style="width:200px;padding-top:5px;">Price: </td><td style="padding-top:5px;">$serviceD->currency_symbol $serviceD->product_price</td></tr>
  			<tr><td style="width:200px;padding-top:5px;">Appointment Date: </td><td style="padding-top:5px;">$appointmentDate</td></tr>
  			<tr><td style="width:200px;padding-top:5px;">Appointment Time: </td><td style="padding-top:5px;">$appointmentTime</td></tr>
  			<tr><td style="width:200px;padding-top:5px;">Appointment Address: </td><td style="padding-top:5px;">$service->address1</td></tr>
  			<tr><td></td><td>$service->address2</td></tr>
  			<tr><td></td><td>$service->city</td></tr>
  			<tr><td></td><td>$service->county</td></tr>
  			<tr><td></td><td>$service->post_code</td></tr>
  			</tbody>
  			<tfoot>
  			<tr><td colspan="2" style="padding:10px;"> </td></tr>
  			<tr><td colspan="2" style="padding:10px;">This e-mail is sent by <a href="www.ushbub.co.uk">Ushbub</a>, on behalf of $service->title. Please contact $service->title directly for all subsequent communication.<br></td></tr>
  			</tfoot>
  			</table></div>
  		</div>
EOT;
  		return array($message_header,$service->email,$service->name);
  	}
}