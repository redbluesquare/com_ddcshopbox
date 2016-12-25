<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsVendorproductsHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;
	/**
	 * Method to display the view.
	 *
	 * @param   string	The template file to include
	 * @since   1.6
	 */
	function render()
  	{
    	$app = JFactory::getApplication();
    	$layout = $this->getLayout();
    	
    	//retrieve task list from model
    	$productModel = new DdcshopboxModelsProduct();
    	$productimagesModel = new DdcshopboxModelsProductimages();
    	$vendorModel = new DdcshopboxModelsVendors();
    	
    	switch($layout) {
    		case "default":
    			default:
    			$this->items = $this->model->listItems();
    			$this->session = JFactory::getSession();
    			$this->_productsListView = DdcshopboxHelpersView::load('vendorproducts','_item','phtml');
    		break;
    		case "product":
    			$this->item = $this->model->getItem();
    			$this->session = JFactory::getSession();
    			break;
    	}
 
    	//display
    	return parent::render();
  	}
}