<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableCoupons extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_coupon_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_coupons', 'ddc_coupon_id', $db);
  	}
}