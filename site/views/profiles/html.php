<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsProfilesHtml extends JViewHtml
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
    	$profilesModel = new DdcshopboxModelsProfiles();
    	$profileModel = new DdcshopboxModelsProfile();
    	switch($layout) {
    		case "default":
    			default:
    			$this->profile = $profilesModel->getItem();
    			$this->form = $profileModel->getForm();
    			$this->_profileAddressView = DdcshopboxHelpersView::load('profiles','_addressform','phtml');
    		break;
    	}
 
    	//display
    	return parent::render();
  	}
}