<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsRecipedetails extends DdcshopboxModelsDefault
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
  	$this->_recipe_header_id = $this->_app->input->get('recipeid',null);
  	$this->_recipe_detail_id = $this->_app->input->get('recipe_detail_id',null);
  	
    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('rd.*');
    $query->select('vp.*');
    $query->select('i.details, i.image_link');
    $query->from('#__ddc_recipe_details as rd');
    $query->leftJoin('#__ddc_vendor_products as vp on (vp.product_id = rd.product_id) AND (rd.product_id <> "0")');
    $query->leftJoin('#__ddc_images as i on (i.link_id = vp.ddc_vendor_product_id) AND (i.linked_table = "ddc_products")');
    $query->group('rd.ddc_recipe_detail_id');
    $query->group('vp.product_id');

    return $query;
  }

  protected function _buildWhere(&$query,$id = null,$id2 = null)
  {
    if($this->_recipe_header_id!=null)
    {
    	$query->where('rd.recipe_header_id = "'. (int)$this->_recipe_header_id .'"');
    }
    if($this->_recipe_detail_id!=null)
    {
    	$query->where('rd.ddc_recipe_detail_id = "'. (int)$this->_recipe_detail_id .'"');
    }
    if($id!=null)
    {
    	$query->where('rd.recipe_header_id = "'. (int)$id .'"');
    }
    if($id2!=null)
    {
    	$query->where('rd.ddc_recipe_detail_id = "'. (int)$id2 .'"');
    }   
    return $query;
  }
  
	public function store($formdata = null)
 	{
 		$formdata = $this->_app->input->get('jform', array(),'array');
  		$data = array(
  				'ddc_recipe_detail_id'=> $formdata['ddc_recipe_detail_id'],
  				'recipe_header_id' => $formdata['recipe_header_id'],
  				'product_id' => $formdata['product_id'],
  				'item_detail' => $formdata['item_detail'],
  				'product_quantity' => $formdata['product_quantity'],
  				'weight' => $formdata['weight'],
  				'weight_uom' => $formdata['weight_uom'],
  				'volume' => $formdata['volume'],
  				'volume_uom' => $formdata['volume_uom'],
  				'state' => 1,
  				'table' => 'recipedetails'
  		);
  		
  		return parent::store($data);
  	}
}