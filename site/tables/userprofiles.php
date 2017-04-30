<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableUserprofiles extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $user_id 			= null;
	var $profile_key		= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__user_profiles', array('user_id', 'profile_key'), $db);
  	}
}