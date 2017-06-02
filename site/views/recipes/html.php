<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsRecipesHtml extends JViewHtml
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
    	$recipesModel = new DdcshopboxModelsRecipeheaders();
    	$recipeModel = new DdcshopboxModelsRecipeheader();
    	$profileModel = new DdcshopboxModelsProfiles();
    	
    	switch($layout) {
    		case "default":
    			default:
    			$this->items = $recipesModel->listItems();
    			$this->_recipesListView = DdcshopboxHelpersView::load('recipes','_item','phtml');
    		break;
    		case "recipe":
    			$this->model = $recipesModel;
    			$this->item = $recipesModel->getItem();
    		break;
    		case "edit":
    			$this->model = $recipeModel;
    			$this->form = $recipeModel->getForm();
    			$this->item = $recipesModel->getItem();
    			$this->profile = $profileModel->getItem();
    		break;
    	}
 
    	//display
    	return parent::render();
  	}
}