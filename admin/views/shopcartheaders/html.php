<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsShopcartheadersHtml extends JViewHtml
{

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    $shopcartDetailsModel = new DdcshopboxModelsShopcartdetails();
 
    switch($layout) {
 
      case "default":
      	default:
      	DdcshopboxHelpersDdcshopbox::addSubmenu('shopcartheaders');
        $this->items = $this->model->listItems();
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
        
      break;
      
      case "shopcart":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('shopcartheaders');
      	$this->schItems = $this->model->listItems();
      	$this->addToolbar();
      
      	break;
      
      case "edit":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('shopcartheaders');
      	$this->form = $vendorFormModel->getForm();
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
  	JToolBarHelper::title(JText::_('COM_DDC_VENDORS'));
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcshopbox');
  	}
  	if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 )
  	{
  		JToolbarHelper::addNew('vendor.add');
  	}
  	if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
  	{
  		JToolbarHelper::editList('vendor.edit');
  	}
  	JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = (isset($this->model->getItem()->ddc_vendor_id));
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_VENDOR_EDIT'): JText::_('COM_DDC_MANAGER_VENDOR_NEW'));
  	JToolBarHelper::save('vendor.save');
  	JToolBarHelper::cancel('vendor.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  protected function UpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	JToolBarHelper::title(JText::_('COM_DDC_MANAGER_VENDOR_EDIT'));
  	JToolbarHelper::apply('vendor.apply');
  }
}