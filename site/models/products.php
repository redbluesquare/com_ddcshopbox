<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsProducts extends DdcshopboxModelsDefault
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
    $this->_product_id = $app->input->get('product_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.ddc_product_id');
    $query->from('#__ddc_products as p');
    $query->group("p.ddc_product_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    
        
    return $query;
  }

}