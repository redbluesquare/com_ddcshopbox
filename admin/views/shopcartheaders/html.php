<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsShopcartheadersHtml extends JViewHtml
{

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    $shopcartDetailsModel = new DdcshopboxModelsShopcartdetails();
    $paymentsModel = new DdcshopboxModelsPayments();
 
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
      	$this->addUpdToolbar();
      	$this->sidebar = JHtmlSidebar::render();
      
      	break;
      
      case "payment":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('shopcartheaders');
      	$this->payment = $paymentsModel->getItem();
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
  	JToolBarHelper::title(JText::_('COM_DDC_SHOPPING_CART'));
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcshopbox');
  	}
  	if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 )
  	{
  		JToolbarHelper::addNew('shopcartheader.add');
  	}
  	if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
  	{
  		JToolbarHelper::editList('shopcartheader.edit');
  	}
  	JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = (isset($this->model->getItem()->ddc_shoppingcart_header_id));
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_SHOPPINGCART_EDIT'): JText::_('COM_DDC_MANAGER_SHOPPINGCART_NEW'));
  	JToolBarHelper::save('shopcartheader.save');
  	JToolBarHelper::cancel('shopcartheader.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  	JToolbarHelper::custom('shopcartheader.delete', 'icon icon-delete','','Delete');
  }
  protected function UpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	JToolBarHelper::title(JText::_('COM_DDC_MANAGER_VENDOR_EDIT'));
  	JToolbarHelper::apply('shopcartheaders.apply');
  }
}