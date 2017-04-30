<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsPaymentmethods extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_paymentmethod_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_paymentmethod_id = $app->input->get('ddc_paymentmethod_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.*');
    $query->from('#__ddc_paymentmethods as p');
    $query->group("p.ddc_paymentmethod_id");


    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_paymentmethod_id!=null)
  	{
  		$query->where('p.ddc_paymentmethod_id = "'. (int)$this->_paymentmethod_id .'"');
  	}
  	if($id!=null)
  	{
  		$query->where('p.ddc_paymentmethod_id = "'. (int)$id .'"');
  	}
        
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	
  	$payment_params = array(
  			'paymentmethod_mode'=>$formdata['paymentmethod_mode'],
  			'test_api_key' => $formdata['test_api_key'],
  			'test_api_secret' => $formdata['test_api_secret'],
  			'test_paymentmethod_url' => $formdata['test_paymentmethod_url'],
  			'test_paymentmethod_url_success' => $formdata['test_paymentmethod_url_success'],
  			'test_paymentmethod_url_cancel' => $formdata['test_paymentmethod_url_cancel'],
  			'api_key' => $formdata['api_key'],
  			'api_secret' => $formdata['api_secret'],
  			'paymentmethod_url' => $formdata['paymentmethod_url'],
  			'paymentmethod_url_success' => $formdata['paymentmethod_url_success'],
  			'paymentmethod_url_cancel' => $formdata['paymentmethod_url_cancel'],
  			'paymentmethod_logo' => $formdata['paymentmethod_logo']
  	);
  	
  	if($formdata['paymentmethod_alias'] == null)
  	{
  		$formdata['paymentmethod_alias'] = $formdata['paymentmethod_name'];
  	}
  	$data = array(
	  	'ddc_paymentmethod_id'=>$formdata['ddc_paymentmethod_id'],
	  	'paymentmethod_name' => $formdata['paymentmethod_name'],
	  	'paymentmethod_alias' => JFilterOutput::stringURLSafe($formdata['paymentmethod_alias']),
	  	'payment_element' => $formdata['payment_element'],
	  	'payment_params' => json_encode($payment_params),
	  	'currency_id' => $formdata['currency_id'],
	  	'shared' => $formdata['shared'],
	  	'ordering' => $formdata['ordering'],
	  	'published' => $formdata['published'],
	  	'created_on' => $formdata['created_on'],
	  	'created_by' => $formdata['created_by'],
	  	'modified_on' => $formdata['modified_on'],
	  	'modified_by' => $formdata['modified_by'],
	  	'locked_on' => $formdata['locked_on'],
	  	'locked_by' => $formdata['locked_by'],
	  	'table' => $formdata['table']);
  	
  	return parent::store($data);
  }

}