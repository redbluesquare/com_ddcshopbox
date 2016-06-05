<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsVendors extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_vendor_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    $this->_vendor_id = $app->input->get('vendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.ddc_vendor_id');
    $query->from('#__ddc_vendors as p');
    $query->group("p.ddc_vendor_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    
        
    return $query;
  }

}