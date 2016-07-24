<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableVendors extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_vendor_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_vendors', 'ddc_vendor_id', $db);
  	}
}