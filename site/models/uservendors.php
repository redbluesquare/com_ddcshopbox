<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsUservendors extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_vendor_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    $this->_user_vendor_id = $app->input->get('uservendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);
	$query->select('v.title');
	$query->select('uv.*');
    $query->select('u.name as owner_name');
    $query->from('#__ddc_user_vendor as uv');
    $query->leftJoin('#__ddc_vendors as v on uv.vendor_id = v.ddc_vendor_id');
    $query->leftJoin('#__users as u on uv.user_id = u.id');
    $query->group("u.name,uv.vendor_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    if($this->_user_vendor_id!=null)
    {
    	$query->where('uv.ddc_user_vendor_id = "'. (int)$this->_user_vendor_id .'"');
    }
        
    return $query;
  }

}