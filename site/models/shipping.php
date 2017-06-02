<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsShipping extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_product_id  = null;
  	var $_vendor_id  = null;
  	var $_mypostcode 	= null;
  	var $_ddclocation	= null;
  	var $_cat_id	  = null;
  	var $_session	  	= null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();
	$this->_session = JFactory::getSession();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_product_id = $app->input->get('product_id', null);
    $this->_vendor_id = $app->input->get('vendor_id', null);
    $this->_ddclocation = $app->input->get('ddclocation', $this->_session->get('ddclocation',null));
    $this->_mypostcode = explode(" ", $this->_ddclocation);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.*');
    $query->select('vp.*');
    $query->select('pp.*');
    $query->select('vc.*');
    $query->select('i.details, i.image_link');
    $query->select('v.*');
    $query->from('#__ddc_products as p');
    $query->rightJoin('#__ddc_vendor_products as vp on p.ddc_product_id = vp.product_id');
    $query->rightJoin('#__ddc_vendors as v on vp.vendor_id = v.ddc_vendor_id');
    $query->leftJoin('#__ddc_product_prices as pp on p.ddc_product_id = pp.product_id');
    $query->leftJoin('#__ddc_currencies as vc on vc.ddc_currency_id = pp.product_currency');
    $query->leftJoin('#__ddc_images as i on (p.ddc_product_id = i.link_id) AND (i.linked_table = "ddc_products")');
    $query->group("p.ddc_product_id");


    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_vendor_id!=null)
  	{
  		$query->where('p.vendor_id = "'. (int)$this->_vendor_id .'"');
  	}
  	if($this->_product_id!=null)
  	{
  		$query->where('p.ddc_product_id = "'. (int)$this->_product_id .'"');
  	}
  	if(($id!=null) And ($id > 0))
  	{
  		$query->where('p.ddc_product_id = "'. (int)$id .'"');
  	}
  	if($this->_ddclocation!=null)
  	{
  		$query->where('v.post_code LIKE "%'.$this->_ddclocation.'%" OR v.town LIKE "%'.$this->_ddclocation.'%" OR v.city LIKE "%'.$this->_ddclocation.'%"');
  	}
        
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	JRequest::checkToken() or jexit('Invalid Token');
  	$user = 0;
  	
  	//check if user e-mail exists
  	$db = JFactory::getDBO();
  	$query = $db->getQuery(TRUE);
  	$query->select('u.*')
  	->from('#__users as u')
  	->where('(u.email = "'.$formdata['email_to'].'")');
  	$db->setQuery($query);
  	$u = $db->loadObject();
  	
  	$data = array(
  	'email_to'=>$formdata['email_to'],
  	'user_id'=>$u->id,
  	'from_postcode' => $formdata['from_postcode'],
  	'to_postcode' => $formdata['to_postcode'],
  	'dim_weight' => $formdata['dim_weight'],
  	'dim_length' => $formdata['dim_length'],
  	'dim_width' => $formdata['dim_width'],
  	'dim_height' => $formdata['dim_height'],
  	'service_type' => $formdata['service_type'],
  	'req_collection_date' => $formdata['req_collection_date'],
  	'req_delivery_date' => $formdata['req_delivery_date'],
  	'delivery_time_from' => $formdata['delivery_time_from'],
  	'delivery_time_to' => $formdata['delivery_time_to'],
  	'table' => $formdata['table']);
  	
  	$this->sendEmail('New delivery quote',$data);
  	
  	return $data;
  }
//   public function sendEmail($subject, $data)
//   {
//   	//save the new booking and send to customer
//   	$params = JComponentHelper::getParams('com_ddcshopbox');
//   	$mail = JFactory::getMailer();
  
//   	$app = JFactory::getApplication();
//   	$mailfrom	= $app->getCfg('mailfrom');
//   	$fromname	= $app->getCfg('fromname');
//   	$sitename	= $app->getCfg('sitename');
  	 
//   	$name		= 'Ushbub Delivery';
//   	$email		= 'sales@ushbub.co.uk';
//   	$body		= (string)json_encode($data);
  
//   	$mail->addRecipient(array($email,$mailfrom));
//   	$mail->addReplyTo(array($mailfrom, $fromname));
//   	$mail->setSender(array($mailfrom, $fromname));
//   	$mail->setSubject($sitename.': '.$subject);
//   	$mail->isHTML(true);
//   	$mail->Encoding = 'base64';
//   	$mail->setBody($body);
//   	$sent = $mail->Send();
//   	if ( $sent !== true ) {
//   		echo 'Error sending email: ';
//   	} else {
//   		return $sent;
//   	}
//   }

}