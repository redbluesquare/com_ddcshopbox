<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsVendors extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     	= null;
  	var $_vendor_id  	= null;
  	var $_cat_id	  	= null;
  	var $_session	  	= null;
  	var $_mypostcode 	= null;
  	var $_published   	= 1;
  	var $_vendor_auth 	= 0;

  function __construct()
  {

    $app = JFactory::getApplication();
	$this->_session = JFactory::getSession();
    $this->_vendor_id = $app->input->get('vendor_id', null);
    $this->_mypostcode = $this->_session->get('mypostcode', null);
    $layoutName = $app->input->getWord('layout', 'default');
    if($layoutName=='edit')
    {
    	$this->_vendor_auth = 1;
    }
    
    $this->_user_id = JFactory::getUser()->id;
    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('v.*');
    $query->select('u.name as owner_name');
    $query->select('uv.user_id');
    $query->from('#__ddc_vendors as v');
    $query->rightJoin('#__users as u on v.owner = u.id');
    $query->rightJoin('#__ddc_user_vendor as uv on v.ddc_vendor_id = uv.vendor_id');
    $query->group("v.ddc_vendor_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    if($this->_vendor_id!=null)
    {
    	$query->where('v.ddc_vendor_id = "'. (int)$this->_vendor_id .'"');
    }
    if($this->_mypostcode!=null)
    {
    	$query->where('v.post_code like "%'.$this->_mypostcode.'%"');
    }
    if($this->_vendor_auth==1)
    {
    	$query->where('uv.user_id = "'. (int)$this->_user_id .'"');
    }   
    return $query;
  }

}