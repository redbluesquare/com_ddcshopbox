<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableImages extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_image_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_images', 'ddc_image_id', $db);
  	}
}