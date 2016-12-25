<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsProductimages extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_product_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    $this->_product_id = $app->input->get('vendorproduct_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('i.*');
    $query->from('#__ddc_images as i');
    $query->group("i.ddc_image_id");


    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_product_id!=null)
  	{
  		$query->where('(i.link_id = "'. (int)$this->_product_id .'") AND (i.linked_table = "ddc_products")');
  	}   
    return $query;
  }

}