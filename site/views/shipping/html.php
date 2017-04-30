<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsShippingHtml extends JViewHtml
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
    	$schModel = new DdcshopboxModelsShopcartheaders();
    	$this->session = JFactory::getSession();
    
    	switch($layout) {
    		case "default":
    			default:
    			$this->profile = $profilesModel->getItem();
    			$this->_customloginShopboxView = DdcshopboxHelpersView::load('shopcart', '_customlogin', 'phtml');
    		break;
    		case "delnote":
    			$this->schItems = $schModel->listItems();
    		break;
    		case "deltoemail":
    			$this->schemail = $schModel->shopcart_items();
    		break;
    	}
 
    	//display
    	return parent::render();
  	}
}