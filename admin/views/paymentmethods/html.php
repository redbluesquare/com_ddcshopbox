<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsPaymentmethodsHtml extends JViewHtml
{

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    $paymentmethodsModel = new DdcshopboxModelsPaymentmethods();
    $paymentmethodFormModel = new DdcshopboxModelsPaymentmethod();
 
    switch($layout) {
 
      case "default":
      	default:
      	DdcshopboxHelpersDdcshopbox::addSubmenu('paymentmethods');
        $this->items = $paymentmethodsModel->listItems();
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
        
      break;
      
      case "edit":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('paymentmethods');
      	$this->form = $paymentmethodFormModel->getForm();
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
  	JToolBarHelper::title(JText::_('COM_DDC_PAYMENTMETHODS'));
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcshopbox');
  	}
  	if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 )
  	{
  		JToolbarHelper::addNew('paymentmethod.add');
  	}
  	if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
  	{
  		JToolbarHelper::editList('paymentmethod.edit');
  	}
  	JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = (isset($this->model->getItem()->ddc_paymentmethod_id));
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_PAYMENTMETHOD_EDIT'): JText::_('COM_DDC_MANAGER_PAYMENTMETHOD_NEW'));
  	JToolBarHelper::save('paymentmethod.save');
  	JToolBarHelper::cancel('paymentmethod.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  protected function UpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	JToolBarHelper::title(JText::_('COM_DDC_MANAGER_PAYMENTMETHOD_EDIT'));
  	JToolbarHelper::apply('paymentmethod.apply');
  }
}