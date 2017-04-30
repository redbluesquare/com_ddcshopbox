<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsCouponsHtml extends JViewHtml
{

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    $couponFormModel = new DdcshopboxModelsCoupon();
 
    switch($layout) {
 
      case "default":
      	default:
      	DdcshopboxHelpersDdcshopbox::addSubmenu('coupons');
        $this->items = $this->model->listItems();
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
        
      break;
      
      case "edit":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('coupons');
      	$this->form = $couponFormModel->getForm();
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
  	JToolBarHelper::title(JText::_('COM_DDC_COUPONS'));
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcshopbox');
  	}
  	if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 )
  	{
  		JToolbarHelper::addNew('coupon.add');
  	}
  	if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
  	{
  		JToolbarHelper::editList('coupon.edit');
  	}
  	JToolbarHelper::help('JHELP_COUPON_MANAGER');
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = (isset($this->model->getItem()->ddc_user_vendor_id));
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_COUPON_EDIT'): JText::_('COM_DDC_MANAGER_COUPON_NEW'));
  	JToolBarHelper::save('coupon.save');
  	JToolBarHelper::cancel('coupon.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  protected function UpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	JToolBarHelper::title(JText::_('COM_DDC_MANAGER_COUPON_EDIT'));
  	JToolbarHelper::apply('coupon.apply');
  }
}