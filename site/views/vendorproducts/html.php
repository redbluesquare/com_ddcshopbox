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
    	$vendorModel = new DdcshopboxModelsVendors();
    	
    	switch($layout) {
    		case "default":
    			default:
    			$this->items = $this->model->listItems();
    			foreach($this->items as $item)
    			{
    				$item->distance = $this->model->getPostcodesDistance($this->session->get('ddclocation',null),$item->shop_post_code);
    			}
    			usort($this->items,array(new DdcshopboxModelsDefault(),'sort_objects_by_distance'));
    			$this->_productsListView = DdcshopboxHelpersView::load('vendorproducts','_item','phtml');
    		break;
    		case "product":
    			$this->item = $this->model->getItem();
    			$this->item->distance = $this->model->getPostcodesDistance($this->session->get('ddclocation',null),$this->item->shop_post_code);
    			$this->model->hit($this->item->ddc_vendor_product_id);
    			break;
    	}
 
    	//display
    	return parent::render();
  	}
}