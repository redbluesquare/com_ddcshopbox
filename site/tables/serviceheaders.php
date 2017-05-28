<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableServiceheaders extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_service_header_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_service_headers', 'ddc_service_header_id', $db);
  	}
}