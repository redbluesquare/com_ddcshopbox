<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableServicedetails extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_service_detail_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_service_details', 'ddc_service_detail_id', $db);
  	}
}