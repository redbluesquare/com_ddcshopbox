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
    	$this->session = JFactory::getSession();
    	
    	//retrieve task list from model
    	$productModel = new DdcshopboxModelsProduct();
    	$productimagesModel = new DdcshopboxModelsProductimages();
    	$shopcartdetailModel = new DdcshopboxModelsShopcartdetails();
    	$vendorModel = new DdcshopboxModelsVendors();
    	
    	switch($layout) {
    		case "default":
    			default:
    			$this->items = $this->model->listItems();
    			$this->vendorModel = $vendorModel;
    			$this->_productsListView = DdcshopboxHelpersView::load('vendorproducts','_item','phtml');
    			$this->_catsListView = DdcshopboxHelpersView::load('vendorproducts','_search','phtml');
    		break;
    		case "product":
    			$this->item = $this->model->getItem();
    			$this->vendor = $vendorModel->getItem($this->item->vendor_id);
    			$this->model->hit($this->item->ddc_vendor_product_id);
    			$this->cart_items = $shopcartdetailModel->listItems($this->item->vendor_id);
    			break;
    	}
 
    	//display
    	return parent::render();
  	}
}