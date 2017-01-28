<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsShopcartheaders extends DdcshopboxModelsDefault
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

    $query->select('sh.ddc_shoppingcart_header_id,sh.first_name,sh.last_name, sh.state,sh.address_line_1 as del_address1,sh.address_line_2 as del_address2,sh.town as del_town,sh.county as del_county,sh.post_code as del_post_code, sh.delivery_type, sh.delivery_date, sh.delivery_time');
    $query->select('count(DISTINCT vp.vendor_id) as total_vendors,vp.vendor_id');
    $query->select('v.title, v.address1, v.address2, v.city, v.county, v.post_code');
    $query->from('#__ddc_shoppingcart_headers as sh');
    $query->leftJoin('#__ddc_shoppingcart_details as sd on sd.shoppingcart_header_id = sh.ddc_shoppingcart_header_id');
    $query->leftJoin('#__ddc_vendor_products as vp on vp.ddc_vendor_product_id = sd.product_id');
    $query->leftJoin('#__ddc_vendors as v on v.ddc_vendor_id = vp.vendor_id');
    $query->group('sh.ddc_shoppingcart_header_id');


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    if($this->_shoppingcart_header_id!=null)
    {
    	$query->group('vp.vendor_id');
    	$query->where('sh.ddc_shoppingcart_header_id = "'. (int)$this->_shoppingcart_header_id .'"');
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