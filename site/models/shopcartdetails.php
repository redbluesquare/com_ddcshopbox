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

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('sd.*');
    $query->select('(SELECT count(DISTINCT scd.ddc_shoppingcart_detail_id) FROM #__ddc_shoppingcart_details as scd WHERE scd.product_id = vp.ddc_vendor_product_id) as qty_bought');
    $query->select('v.*');
    $query->select('i.*');
    $query->select('vp.*');
    $query->select('vc.currency_name, vc.currency_code_3, vc.currency_symbol');
    $query->select('vpr.product_price, vpr.product_currency, vpr.product_id, vpr.ddc_product_price_id');
    $query->from('#__ddc_shoppingcart_details as sd');
    $query->leftJoin('#__ddc_vendor_products as vp on vp.ddc_vendor_product_id = sd.product_id');
    $query->leftJoin('#__ddc_product_prices as vpr on vp.ddc_vendor_product_id = vpr.product_id');
    $query->leftJoin('#__ddc_currencies as vc on vc.ddc_currency_id = vpr.product_currency');
    $query->leftJoin('#__ddc_images as i on (vp.ddc_vendor_product_id = i.link_id) AND (i.linked_table = "ddc_products")');
    $query->leftJoin('#__ddc_vendors as v on v.ddc_vendor_id = vp.vendor_id');
    $query->order('qty_bought desc');

    return $query;
  }

  protected function _buildWhere(&$query, $id = null, $prod_id = null)
  {
    if($this->_shoppingcart_header_id!=null)
    {
    	$query->where('sd.shoppingcart_header_id = "'. (int)$this->_shoppingcart_header_id .'"');
    	$query->group('sd.ddc_shoppingcart_detail_id');
    }
    if($id!=null)
    {
    	$query->where('vp.vendor_id = '. (int)$id .'');
    	$query->group('vp.ddc_vendor_product_id');
    }
    if($prod_id!=null)
    {
    	$query->where('vp.ddc_vendor_product_id = '. (int)$prod_id .'');
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