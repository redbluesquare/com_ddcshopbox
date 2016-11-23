<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsProductprices extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_product_id  = null;
  	var $_vendor_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_product_id = $app->input->get('product_id', null);
    $this->_productprice_id = $app->input->get('productprice_id', null);
    $this->_vendor_id = $app->input->get('vendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.*');
    $query->select('pp.*');
    $query->select('vc.*');
    $query->select('v.*');
    $query->from('#__ddc_products as p');
    $query->rightJoin('#__ddc_vendors as v on p.vendor_id = v.ddc_vendor_id');
    $query->rightJoin('#__ddc_product_prices as pp on p.ddc_product_id = pp.product_id');
    $query->rightJoin('#__ddc_currencies as vc on vc.ddc_currency_id = pp.product_currency');
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
  	if($id!=null)
  	{
  		$query->where('p.ddc_product_id = "'. (int)$id .'"');
  	}
        
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	$data = array(
  	'ddc_product_price_id'=>$formdata['ddc_product_price_id'],
  	'product_price' => $formdata['product_price'],
  	'product_currency' => $formdata['product_currency'],
  	'product_id' => $formdata['ddc_product_id'],
  	'table' => 'productprices');
  	
  	return parent::store($data);
  }

}