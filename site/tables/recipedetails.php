<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableRecipedetails extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_recipe_detail_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_recipe_details', 'ddc_recipe_detail_id', $db);
  	}
}