<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableUservendors extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_user_vendor_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_user_vendor', 'ddc_user_vendor_id', $db);
  	}
}