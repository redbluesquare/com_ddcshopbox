<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableProducts extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_product_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_products', 'ddc_product_id', $db);
  	}
}