<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsVendorproductsHtml extends JViewHtml
{

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    $vproductModel = new DdcshopboxModelsVendorproducts();
    $vproductFormModel = new DdcshopboxModelsVendorproduct();
    $productimagesModel = new DdcshopboxModelsProductimages();
 
    switch($layout) {
 
      case "default":
      	default:
      	DdcshopboxHelpersDdcshopbox::addSubmenu('vendorproducts');
        $this->items = $vproductModel->listItems();
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
        
      break;
      
      case "edit":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('vendorproducts');
      	$this->form = $vproductFormModel->getForm();
    	$this->productimages = $productimagesModel->listItems();
      	$this->addUpdToolBar();
      	$this->sidebar = JHtmlSidebar::render();
      
      	break;
      
    }
    
 
    //display
    return parent::render();
  }
  
  protected function addToolbar()
  {
  	$canDo  = DdcshopboxHelpersDdcshopbox::getActions();
  	// Get the toolbar object instance
  	$bar = JToolBar::getInstance('toolbar');
  	JToolBarHelper::title(JText::_('COM_DDC_VENDOR_PRODUCTS'));
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcshopbox');
  	}
  	if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 )
  	{
  		JToolbarHelper::addNew('vendorproduct.add');
  	}
  	if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
  	{
  		JToolbarHelper::editList('vendorproduct.edit');
  	}
  	JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = (isset($this->model->getItem()->ddc_vendor_product_id));
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_PRODUCT_EDIT'): JText::_('COM_DDC_MANAGER_PRODUCT_NEW'));
  	JToolBarHelper::save('vendorproduct.save');
  	JToolBarHelper::cancel('vendorproduct.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  protected function UpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	JToolBarHelper::title(JText::_('COM_DDC_MANAGER_PRODUCT_EDIT'));
  	JToolbarHelper::apply('vendorproduct.apply');
  }
}