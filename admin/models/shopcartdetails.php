<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsShopcartdetails extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_vendor_id  = null;
  	var $_cat_id	  = null;
  	var $_shoppingcart_header_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    $this->_vendor_id = $app->input->get('vendor_id', null);
    $this->_shoppingcart_header_id = $app->input->get('shoppingcart_header_id', null);
    $this->_shoppingcart_detail_id = $app->input->get('shoppingcart_detail_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('sd.*');
    $query->select('vp.*');
    $query->from('#__ddc_shoppingcart_details as sd');
    $query->leftJoin('#__ddc_vendor_products as vp on vp.ddc_vendor_product_id = sd.product_id');
    $query->group('sd.ddc_shoppingcart_detail_id');


    return $query;
  }

  protected function _buildWhere(&$query, $id = null)
  {
    if($this->_shoppingcart_header_id!=null)
    {
    	$query->where('sd.shoppingcart_header_id = "'. (int)$this->_shoppingcart_header_id .'"');
    }
    if($this->_shoppingcart_detail_id!=null)
    {
    	$query->where('sd.shoppingcart_detail_id = "'. (int)$this->_shoppingcart_detail_id .'"');
    }
    if($id!=null)
    {
    	$query->where('vp.vendor_id = "'. (int)$id .'"');
    }
        
    return $query;
  }
  
	public function store($formdata = null)
 	{
  		$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  		
  		if($formdata['alias'] == null)
  		{
  			$formdata['alias'] = JFilterOutput::stringURLSafe($formdata['title']);
  		}
  	 
  		return parent::store($formdata);
  	}
  
  
}