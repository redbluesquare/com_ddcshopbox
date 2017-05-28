<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableUservendorinterests extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_user_vendor_interest_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_user_vendor_interests', 'ddc_user_vendor_interest_id', $db);
  	}
}