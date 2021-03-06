<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsDashboardHtml extends JViewHtml
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
    	$productsModel = new DdcshopboxModelsProducts();
    	$vendorModel = new DdcshopboxModelsVendors();
    	
    	switch($layout) {
    		case "default":
    			default:
    			$pathway = $app->getPathway();
    			$pathway->addItem('Dashboard', '');
    			$this->items = $vendorModel->listItems();
    			$this->_vendorsListView = DdcshopboxHelpersView::load('vendors','_item','phtml');
    		break;
    		case "storemanager":
    			$pathway = $app->getPathway();
    			$pathway->addItem('Store-Manager', '');
    			$this->item = $this->model->getItem();
    			$this->products = $productsModel->listItems();
    			
    			$this->gmap($this->item->post_code,'com_ddcshopbox');
    		break;
    		case "productsmanager":
    			$pathway = $app->getPathway();
    			$pathway->addItem('Products-Manager', '');
    			$this->item = $this->model->getItem();
    			$this->products = $productsModel->listItems();
    			$this->form = $vendorModel->getForm();
    			 
    			break;
    	}
 
    	//display
    	return parent::render();
  	}
  	
  	function gmap($postcode, $component)
  	{
  		$params = JComponentHelper::getParams($component);
  		$document = JFactory::getDocument();
  		$document->addScript('https://maps.googleapis.com/maps/api/js?key='.$params->get('google_api_key').'&callback=initialize','text/javascript',true,true);
  		//$document->addScript('https://maps.googleapis.com/maps/api/js?callback=initialize','text/javascript',true,true);
  		$document->addScriptDeclaration('
    			function initialize() {
  					geocoder = new google.maps.Geocoder();
  					var mapOptions = {
    					zoom: 12
  					}
  					var address = "'.$postcode.', UK";
  					geocoder.geocode( { "address": address}, function(results, status) {
    					if (status == google.maps.GeocoderStatus.OK) {
      						map.setCenter(results[0].geometry.location);
      						var marker = new google.maps.Marker({
          						map: map,
          						position: results[0].geometry.location
      						});
     					}
  					});
  					map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
     			}
     			function codeAddress() {
     				var address = "'.$postcode.', UK";
  					geocoder.geocode( { "address": address}, function(results, status) {
    					if (status == google.maps.GeocoderStatus.OK) {
      						map.setCenter(results[0].geometry.location);
      						var marker = new google.maps.Marker({
          						map: map,
          						position: results[0].geometry.location
      						});
     					}
  					});
     			}
			');
  		return true;
  	}
}