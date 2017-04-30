<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsPayments extends DdcshopboxModelsDefault
{

  /**
  * Protected fields
  **/

  var $_cat_id		    	= null;
  var $_pagination  		= null;
  var $_payment_id  		= null;
  var $_published   		= 1;
  var $_user_id     		= null;
  var $_shopcart_id			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$app = JFactory::getApplication();
  	$this->session = JFactory::getSession();

  	$this->_payment_id = $app->input->get('payment_id', null);
  	$this->_shopcart_id = $app->input->get('shopcart_id', null);

  	  	
    parent::__construct();       
  }
    
  /**
  * Builds the query to be used by the product model
  * @return   object  Query object
  *
  *
  */
  protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.*');
    $query->from('#__ddc_payments as p');

    return $query;
    
  }

  /**
  * Builds the filter for the query
  * @param    object  Query object
  * @return   object  Query object
  *
  */
  protected function _buildWhere(&$query)
  {
  	if($this->_payment_id!=null)
  	{
  		$query->where('p.ddc_payment_id = "'.$this->_payment_id.'"');
  	}
  	if($this->_shopcart_id!=null)
  	{
  		$query->where('p.ref_id = "'.$this->_shopcart_id.'"');
  	}
   return $query;
  }
  
  
}