<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableVendorproducts extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_vendor_product_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_vendor_products', 'ddc_vendor_product_id', $db);
  	}
}