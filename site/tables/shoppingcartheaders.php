<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableShoppingcartheaders extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_shoppingcart_header_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_shoppingcart_headers', 'ddc_shoppingcart_header_id', $db);
  	}
}