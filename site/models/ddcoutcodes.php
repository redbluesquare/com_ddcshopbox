<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsDdcoutcodes extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_outcode_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_outcode_id = $app->input->get('ddcoutcode_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('o.*');
    $query->from('#__ddc_outcodes as o');
    $query->group("o.ddc_outcode_id");


    return $query;
  }

  protected function _buildWhere(&$query,$pc=null)
  {
  	if($this->_outcode_id!=null)
  	{
  		$query->where('o.ddc_outcode_id = "'. (int)$this->_outcode_id .'"');
  	}
  	if( $pc!=null )
  	{
  		$query->where('o.postcode = "'. $pc .'"');
  	}
        
    return $query;
  }

}