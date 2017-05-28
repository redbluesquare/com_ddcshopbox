<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcpostings extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_posting_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_postings', 'ddc_posting_id', $db);
  	}
}