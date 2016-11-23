<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableShoppingcartdetails extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_shoppingcart_detail_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_shoppingcart_details', 'ddc_shoppingcart_detail_id', $db);
  	}
}