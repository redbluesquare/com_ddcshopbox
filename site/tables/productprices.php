<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableProductprices extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_product_price_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_product_prices', 'ddc_product_price_id', $db);
  	}
}