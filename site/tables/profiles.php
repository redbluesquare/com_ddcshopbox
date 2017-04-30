<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableProfiles extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_userinfo_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_userinfos', 'ddc_userinfo_id', $db);
  	}
}