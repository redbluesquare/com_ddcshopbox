<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsProducts extends DdcshopboxModelsDefault
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
    $query->select('i.*');
    $query->select('v.*');
    $query->from('#__ddc_products as p');
    $query->leftJoin('#__ddc_images as i on (p.ddc_product_id = i.link_id) AND (i.linked_table = "ddc_products")');
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
  	$prod_params = array(
  			'min_order_level' => $formdata['min_order_level'],
  			'max_order_level' => $formdata['max_order_level'],
  			'step_order_level' => $formdata['step_order_level'],
  			'product_box' => $formdata['product_box']
  	);
  	$data = array(
  	'ddc_product_id'=>$formdata['ddc_product_id'],
  	'product_parent_id' => $formdata['product_parent_id'],
  	'product_name' => $formdata['product_name'],
  	'product_alias' => $formdata['product_alias'],
  	'product_sku' => $formdata['product_sku'],
  	'product_gtin' => $formdata['product_gtin'],
  	'product_mpn' => $formdata['product_mpn'],
  	'product_url' => $formdata['product_url'],
  	'product_length' => $formdata['product_length'],
  	'product_width' => $formdata['product_width'],
  	'product_height' => $formdata['product_height'],
  	'product_lwh_uom' => $formdata['product_lwh_uom'],
  	'product_weight' => $formdata['product_weight'],
  	'product_weight_uom' => $formdata['product_weight_uom'],
  	'product_base_uom' => $formdata['product_base_uom'],
  	'product_description_small' => $formdata['product_description_small'],
  	'product_description' => $formdata['product_description'],
  	'product_params' => json_encode($prod_params),
  	'metarobot' => $formdata['metarobot'],
  	'metaauthor' => $formdata['metaauthor'],
  	'vendor_id' => $formdata['vendor_id'],
  	'table' => $formdata['table']);
  	
  	return parent::store($data);
  }

}