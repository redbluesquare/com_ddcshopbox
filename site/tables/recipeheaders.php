<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableRecipeheaders extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_recipe_header_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_recipe_headers', 'ddc_recipe_header_id', $db);
  	}
}