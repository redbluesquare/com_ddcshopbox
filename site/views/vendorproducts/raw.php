<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewsVendorproductsRaw extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $type = $app->input->get('type');
    $id = $app->input->get('product_id');
    $view = $app->input->get('view');
 
    //retrieve task list from model
    $model = new DdcshopboxModelsProducts();
 
    $this->product = $model->getItem($id,$view,FALSE);
    
    //display
    echo $this->product;
  } 
}
