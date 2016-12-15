<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsProductsHtml extends JViewHtml
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
    			$this->_productsListView = DdcshopboxHelpersView::load('products','_item','phtml');
    		break;
    		case "product":
    			$this->product = $this->model->getItem();
    			$this->session = JFactory::getSession();
    			break;
    		case "edit":
    			$this->session = JFactory::getSession();
    			$this->form = $productModel->getForm();
    			$this->vendor = $vendorModel->getItem();
    			$this->product = $this->model->getItem();
    			$this->productimages = $productimagesModel->listItems();
    		break;
    	}
 
    	//display
    	return parent::render();
  	}
}