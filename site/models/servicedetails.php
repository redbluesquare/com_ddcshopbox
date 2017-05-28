<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsServicedetails extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     				= null;
  	var $_vendor_id  				= null;
  	var $_app		  				= null;
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
  	$this->_service_detail_id = $this->_app->input->get('service_detail_id',null);
  	
    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('sd.*');
    $query->select('vp.*');
    $query->select('vc.currency_symbol');
    $query->from('#__ddc_service_details as sd');
    $query->leftJoin('#__ddc_vendor_products as vp on vp.ddc_vendor_product_id = sd.product_id');
    $query->leftJoin('#__ddc_currencies as vc on vc.ddc_currency_id = sd.currency');
    $query->group('sd.ddc_service_detail_id');

    return $query;
  }

  protected function _buildWhere(&$query,$id = null)
  {
    if($this->_service_header_id!=null)
    {
    	$query->where('sd.service_header_id = "'. (int)$this->_service_header_id .'"');
    }
    if($this->_service_detail_id!=null)
    {
    	$query->where('sd.ddc_service_detail_id = "'. (int)$this->_service_detail_id .'"');
    }
    if($id!=null)
    {
    	$query->where('sd.service_header_id = "'. (int)$id .'"');
    }
        
    return $query;
  }
  
	public function store($formdata = null)
 	{
 		$formdata = $this->_app->input->get('jform', array(),'array');
  		$productModel = new DdcshopboxModelsVendorproducts();
  		$product = $productModel->getItem($formdata['ddc_service_id']);
  		$data = array(
  				'ddc_service_detail_id'=> '',
  				'service_header_id' => $this->_app->input->get('service_header_id',null),
  				'product_id' => $product->ddc_vendor_product_id,
  				'product_quantity' => 1,
  				'product_pack' => $this->getpartjsonfield($product->product_params, 'product_box'),
  				'product_base_uom' => $product->product_base_uom,
  				'product_price' => $productModel->getProductPrice($product->ddc_vendor_product_id),
  				'currency' => $product->product_currency,
  				'state' => 1,
  				'table' => 'servicedetails'
  		);
  		
  		return parent::store($data);
  	}
}