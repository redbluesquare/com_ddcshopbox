<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
//Display partial views
class DdcshopboxViewsVendorsPhtml extends JViewHTML
{
    function render()
    {
    	$this->params = JComponentHelper::getParams('com_ddcshopbox');
    	
    	return parent::render();
 	}
}