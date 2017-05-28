<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsEventsHtml extends JViewHtml
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
    	$profileModel = new DdcshopboxModelsProfile();
    	
    
    	switch($layout) {
    		case "default":
    			default:
    			$this->form = $profileModel->getForm();

    		break;
    	}
 
    	//display
    	return parent::render();
  	}
}