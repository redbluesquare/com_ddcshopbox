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

    $query->select('v.*');
    $query->select('u.name as owner_name');
    $query->from('#__ddc_vendors as v');
    $query->leftJoin('#__users as u on v.owner = u.id');
    $query->group("v.ddc_vendor_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    if($this->_vendor_id!=null)
    {
    	$query->where('v.ddc_vendor_id = "'. (int)$this->_vendor_id .'"');
    }
        
    return $query;
  }

}