<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
//Display partial views
class DdcshopboxViewsShippingPhtml extends JViewHTML
{
    function render()
    {
    	$this->params = JComponentHelper::getParams('com_ddcshopbox');
    	
    	$schModel = new DdcshopboxModelsShopcartheaders();
    	$this->schItems = $schModel->listItems();
    	return parent::render();
 	}
}