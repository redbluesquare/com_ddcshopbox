<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsVendorproducts extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_product_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_product_id = $app->input->get('vendorproduct_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);
    
    $query->select('p.ddc_product_id,p.product_name,p.product_alias,p.product_parent_id');
    $query->select('vc.currency_symbol, vc.currency_code_3, vc.currency_name');
    $query->select('v.title as vendor_name');
    $query->select('vpr.product_price, vpr.product_currency, vpr.product_id, vpr.ddc_product_price_id');
    $query->select('c.title as category_title');
    $query->select('vp.*');
    $query->from('#__ddc_vendor_products as vp');
    $query->leftJoin('#__ddc_products as p on vp.product_id = p.ddc_product_id');
    $query->leftJoin('#__categories as c on c.id = p.category_id');
    $query->leftJoin('#__ddc_vendors as v on v.ddc_vendor_id = vp.vendor_id');
    $query->leftJoin('#__ddc_product_prices as vpr on vp.ddc_vendor_product_id = vpr.product_id');
    $query->leftJoin('#__ddc_currencies as vc on vc.ddc_currency_id = vpr.product_currency');
    $query->group("vp.ddc_vendor_product_id");


    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_product_id!=null)
  	{
  		$query->where('vp.ddc_vendor_product_id = "'. (int)$this->_product_id .'"');
  	}
  	if(($id!=null) And ($id > 0))
  	{
  		$query->where('vp.ddc_vendor_product_id = "'. (int)$id .'"');
  	}
        
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	if($formdata['vendor_product_alias'] == null)
  	{
  		$formdata['vendor_product_alias'] = JFilterOutput::stringURLSafe($formdata['vendor_product_name']);
  	}
  	$prod_params = array(
  			'min_order_level' => $formdata['min_order_level'],
  			'max_order_level' => $formdata['max_order_level'],
  			'step_order_level' => $formdata['step_order_level'],
  			'product_box' => $formdata['product_box']
  	);
  	$data = array(
  	'ddc_vendor_product_id'=>$formdata['ddc_vendor_product_id'],
  	'product_id' => $formdata['product_id'],
  	'vendor_id' => $formdata['vendor_id'],
  	'vendor_product_name' => $formdata['vendor_product_name'],
  	'vendor_product_alias' => $formdata['vendor_product_alias'],
  	'vendor_product_sku' => $formdata['vendor_product_sku'],
  	'product_gtin' => $formdata['product_gtin'],
  	'product_mpn' => $formdata['product_mpn'],
  	'product_description_small' => $formdata['product_description_small'],
	'product_description' => $formdata['product_description'],  	
  	'product_length' => $formdata['product_length'],
  	'product_width' => $formdata['product_width'],
  	'product_height' => $formdata['product_height'],
  	'product_lwh_uom' => $formdata['product_lwh_uom'],
  	'product_weight' => $formdata['product_weight'],
  	'product_weight_uom' => $formdata['product_weight_uom'],
  	'low_stock_notification' => $formdata['low_stock_notification'],
  	'product_available_date' => $formdata['product_available_date'],
  	'product_availability' => $formdata['product_availability'],
  	'product_special' => $formdata['product_special'],
  	'product_base_uom' => $formdata['product_base_uom'],
  	'product_packaging' => $formdata['product_packaging'],
  	'product_params' => json_encode($prod_params),
  	'intnotes' => $formdata['intnotes'],
  	'published' => $formdata['published'],
  	'metarobot' => $formdata['metarobot'],
  	'metaauthor' => $formdata['metaauthor'],
  	'layout' => $formdata['layout'],
  	'pordering' => $formdata['pordering'],
  	'table' => $formdata['table']);
  	
  	return parent::store($data);
  }

}