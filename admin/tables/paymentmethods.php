<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TablePaymentmethods extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddc_paymentmethod_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddc_paymentmethods', 'ddc_paymentmethod_id', $db);
  	}
}