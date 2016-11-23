<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsShopcartHtml extends JViewHtml
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
    	$profilesModel = new DdcshopboxModelsProfiles();
    	$this->session = JFactory::getSession();
    
    	switch($layout) {
    		case "default":
    			default:
    			$this->profile = $profilesModel->getItem();
    			$this->items = $this->model->listItems();
    			$this->_customloginShopboxView = DdcshopboxHelpersView::load('shopcart', '_customlogin', 'phtml');

    		break;
    	}
 
    	//display
    	return parent::render();
  	}
}