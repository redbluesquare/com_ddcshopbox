<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsCoupons extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_coupon_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_coupon_id = $app->input->get('coupon_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('c.*');
    $query->select('v.*');
    $query->from('#__ddc_coupons as c');
    $query->leftJoin('#__ddc_vendors as v on v.ddc_vendor_id = c.vendor_id');
    $query->group("c.ddc_coupon_id");


    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_coupon_id!=null)
  	{
  		$query->where('c.ddc_coupon_id = "'. (int)$this->_coupon_id .'"');
  	}
  	if(($id!=null) And ($id > 0))
  	{
  		$query->where('c.ddc_coupon_id = "'. (int)$id .'"');
  	}
        
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	$data = array(
  	'ddc_coupon_id'=>$formdata['ddc_coupon_id'],
  	'coupon_code' => $formdata['coupon_code'],
  	'coupon_type' => $formdata['coupon_type'],
  	'vendor_id' => $formdata['vendor_id'],
  	'percent_or_total' => $formdata['percent_or_total'],
  	'coupon_value' => $formdata['coupon_value'],
  	'coupon_start_date' => $formdata['coupon_start_date'],
  	'coupon_expiry_date' => $formdata['coupon_expiry_date'],
  	'coupon_value_valid' => $formdata['coupon_value_valid'],
  	'coupon_used' => $formdata['coupon_used'],
  	'published' => $formdata['published'],
  	'table' => $formdata['table']);
  	
  	return parent::store($data);
  }

}