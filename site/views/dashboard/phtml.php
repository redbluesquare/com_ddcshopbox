<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
//Display partial views
class DdcshopboxViewsDashboardPhtml extends JViewHTML
{
    function render()
    {
    	$this->params = JComponentHelper::getParams('com_ddcshopbox');
    	
    	return parent::render();
 	}
}