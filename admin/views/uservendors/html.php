<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsUservendorsHtml extends JViewHtml
{

  function render()
  {
    $app = JFactory::getApplication();
    $layout = $app->input->get('layout');
    
    //retrieve task list from model
    $uservendorModel = new DdcshopboxModelsUservendors();
    $uservendorFormModel = new DdcshopboxModelsUservendor();
 
    switch($layout) {
 
      case "default":
      	default:
      	DdcshopboxHelpersDdcshopbox::addSubmenu('uservendors');
        $this->items = $uservendorModel->listItems();
        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();
        
      break;
      
      case "edit":
      	DdcshopboxHelpersDdcshopbox::addSubmenu('uservendors');
      	$this->form = $uservendorFormModel->getForm();
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
  	JToolBarHelper::title(JText::_('COM_DDC_USER_VENDORS'));
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcshopbox');
  	}
  	if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 )
  	{
  		JToolbarHelper::addNew('uservendor.add');
  	}
  	if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
  	{
  		JToolbarHelper::editList('uservendor.edit');
  	}
  	JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = (isset($this->model->getItem()->ddc_user_vendor_id));
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_MANAGER_USER_VENDOR_EDIT'): JText::_('COM_DDC_MANAGER_USER_VENDOR_NEW'));
  	JToolBarHelper::save('uservendor.save');
  	JToolBarHelper::cancel('uservendor.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  protected function UpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	JToolBarHelper::title(JText::_('COM_DDC_MANAGER_VENDOR_EDIT'));
  	JToolbarHelper::apply('uservendor.apply');
  }
}